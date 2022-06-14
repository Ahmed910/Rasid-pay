<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\JobBladeRequest;
use App\Http\Requests\Dashboard\RasidJob\RasidJobRequest;
use App\Http\Requests\Dashboard\ReasonRequest;
use App\Http\Resources\Blade\Dashboard\Activitylog\ActivityLogCollection;
use App\Http\Resources\Blade\Dashboard\RasidJob\RasidJobCollection;
use App\Models\Department\Department;
use App\Models\RasidJob\RasidJob;
use Illuminate\Http\Request;
use App\Exports\JobsExport;
use App\Exports\RasidJobsArchiveExport;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class RasidJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }
        if ($request->ajax()) {

            $rasid_jobsQuery = RasidJob::without('employee')->search($request)
                ->CustomDateFromTo($request)
                ->ListsTranslations('name')
                ->addSelect('rasid_jobs.created_at', 'rasid_jobs.is_active', 'rasid_jobs.department_id', 'rasid_jobs.is_vacant')
                ->sortBy($request);


            $rasid_jobCount = $rasid_jobsQuery->count();
            $rasid_jobs = $rasid_jobsQuery->skip($request->start)
                ->take(($request['length'] == '-1') ? $rasid_jobCount : $request->length)
                ->get();

            return RasidJobCollection::make($rasid_jobs)
                ->additional(['total_count' => $rasid_jobCount]);
        }

        $departments = Department::/*where('is_active', 1)
            ->*/select("id")
            ->ListsTranslations("name")
            ->pluck('name', 'id')
            ->toArray();

        return view('dashboard.rasid_job.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'rasid_job')) ? session(['perviousPage' => 'rasid_job']) : session(['perviousPage' => 'home']);

        $departments = Department::with('parent.translations')->ListsTranslations('name')->where('is_active', 1)->pluck('name', 'id')->toArray();
        $locales = config('translatable.locales');
        return view('dashboard.rasid_job.create', compact('departments', 'locales', 'previousUrl'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobBladeRequest $request, RasidJob $RasidJob)
    {
        if (!request()->ajax()) {
            $RasidJob->fill($request->validated())->save();
            return redirect()->back()->with('success', __('dashboard.general.success_add'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $rasidJob = RasidJob::withTrashed()->findOrFail($id);
        $sortingColumns = [
            'id',
            'user_name',
            'department_name',
            'created_at',
            'action_type',
            'reason'
        ];
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $sortingColumns[$request->order[0]['column']], 'dir' => $request->order[0]['dir']];
        }

        $activitiesQuery  = $rasidJob->activity()
            ->sortBy($request);

        if ($request->ajax()) {
            $activityCount = $activitiesQuery->count();
            $activities = $activitiesQuery->skip($request->start)->take($request->length == -1 ? $activityCount : $request->length)->get();
            return ActivityLogCollection::make($activities)
                ->additional(['total_count' => $activityCount]);
        }

        return view('dashboard.rasid_job.show', compact('rasidJob'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'rasid_job')) ? session(['perviousPage' => 'rasid_job']) : session(['perviousPage' => 'home']);

        $rasidJob = RasidJob::withTrashed()->findOrFail($id);
        $departments = Department::with('parent.translations')->ListsTranslations('name')->where(function ($q) {
            $q->/*where('parent_id', null)->*/where('is_active', 1);
        })->orWhere('departments.id',$rasidJob->department_id)->pluck('name', 'id')->toArray();
        $locales = config('translatable.locales');
        return view('dashboard.rasid_job.edit', compact('departments', 'rasidJob', 'locales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobBladeRequest $request,  $rasid_job)
    {
        if (!request()->ajax()) {
            $job = RasidJob::withTrashed()->findOrFail($rasid_job) ;
            $job->fill($request->validated() + ['updated_at' => now()])->save();
            return redirect()->route('dashboard.rasid_job.index')->withSuccess(__('dashboard.general.success_update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function archive(Request $request)
    {
        $sortingColumns = [
            'id',
            'name',
            'department_id',
            'deleted_at',
            'is_active'

        ];

        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $sortingColumns[$request->order[0]['column']], 'dir' => $request->order[0]['dir']];
        }

        $rasid_jobsQuery = RasidJob::onlyTrashed()
            ->without('employee')
            ->search($request)
            ->searchDeletedAtFromTo($request)
            ->ListsTranslations('name')
            ->sortBy($request)
            ->addSelect('rasid_jobs.department_id', 'rasid_jobs.deleted_at', 'rasid_jobs.is_active');
        if ($request->ajax()) {
            $rasid_jobCount = $rasid_jobsQuery->count();
            $rasid_jobs = $rasid_jobsQuery->skip($request->start)
                ->take($request['length'] == '-1' ? $rasid_jobCount : $request['length'])
                ->get();

            return RasidJobCollection::make($rasid_jobs)
                ->additional(['total_count' => $rasid_jobCount]);
        }

        $departments = Department::where('is_active', 1)
            ->has("children")
            ->orWhere(function ($q) {
                $q->doesntHave('children');
            })
            ->select("id")
            ->ListsTranslations("name")
            ->pluck('name', 'id')->toArray();

        return view('dashboard.archive.rasid_job.index', compact('departments'));
    }
    public function restore(ReasonRequest $request, $id)
    {
        if ($request->ajax()) {
            $RasidJob = RasidJob::onlyTrashed()->findOrFail($id);
            $RasidJob->restore();
            return response()->json([
                'message' => __('dashboard.general.success_restore')
            ]);
        }
    }

    public function forceDelete(ReasonRequest $request, $id)
    {
        if ($request->ajax()) {

            $RasidJob = RasidJob::onlyTrashed()->findOrFail($id);
            $RasidJob->forceDelete();
            return response()->json([
                'message' => __('dashboard.general.success_delete')
            ]);
        }
    }
    public function destroy($RasidJob, \App\Http\Requests\Dashboard\ReasonRequest $request)
    {
        $rasid_job = RasidJob::findorfail($RasidJob);

        if ($request->ajax()) {
            $rasid_job->delete();
            return response()->json([
                'message' => __('dashboard.general.success_archive')
            ]);
        }
    }



    public function export(Request $request)
    {

        return Excel::download(new JobsExport($request), 'jobs.xlsx');
    }



    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $jobsQuery = RasidJob::without('employee')->search($request)
            ->CustomDateFromTo($request)
            ->ListsTranslations('name')
            ->sortBy($request)
            ->addSelect('rasid_jobs.created_at', 'rasid_jobs.is_active', 'rasid_jobs.department_id', 'rasid_jobs.is_vacant')
            ->get();

        if (!$request->has('created_from')) {
            $createdFrom = RasidJob::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdf = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.job',
                [
                    'jobs' => $jobsQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->export();

        return $mpdf;
    }

    public function exportArchieve(Request $request)
    {

        return Excel::download(new RasidJobsArchiveExport($request), 'rasidjobs_archive.xlsx');
    }

    public function exportPDFArchieve(Request $request, GeneratePdf $pdfGenerate)
    {
        $rasid_jobs_archiveQuery = RasidJob::onlyTrashed()
            ->without('employee')
            ->search($request)
            ->searchDeletedAtFromTo($request)
            ->ListsTranslations('name')
            ->addSelect('rasid_jobs.department_id', 'rasid_jobs.deleted_at', 'rasid_jobs.is_active')
            ->get();
        if (!$request->has('created_from')) {
            $createdFrom = RasidJob::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdf = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.archive.rasid_job',
                [
                    'jobs_archive' => $rasid_jobs_archiveQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,
                ]
            )
            ->export();

        return $mpdf;
    }

    public function getVacantJobs($id)
    {
        $rasid_jobs = RasidJob::where(['department_id' => $id, 'is_vacant' => true,'is_active' => 1])->select('id')->ListsTranslations('name')
            ->without(['images', 'addedBy', 'translations', 'department', 'employee'])->get()->pluck('name', 'id')->toArray();
        $view = view('dashboard.admin.ajax.rasid_job',compact('rasid_jobs'))->render();
        return response()->json(['view' => $view]);
    }
}
