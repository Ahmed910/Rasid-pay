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
use App\Exports\JobsExport ;
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

        $departments = Department::where('is_active', 1)
            ->select("id")
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

        $departments = Department::with('parent.translations')->ListsTranslations('name')->where('is_active', 1)->pluck('name', 'id');
        $locales = config('translatable.locales');
        return view('dashboard.rasid_job.create', compact('departments', 'locales'));
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
        $rasidJob = RasidJob::findorfail($id);
        $departments = Department::with('parent.translations')->ListsTranslations('name')->where('parent_id', null)->pluck('name', 'id')->toArray();
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
    public function update(JobBladeRequest $request, RasidJob $rasid_job)
    {
        if (!request()->ajax()) {
            $rasid_job->fill($request->validated() + ['updated_at' => now()])->save();
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
            ->CustomDateFromTo($request)
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
                $q->doesntHave('children')
                    ->WhereNull('parent_id');
            })

            ->select("id")
            ->ListsTranslations("name")
            ->pluck('name', 'id');

        return view('dashboard.archive.rasid_job.index', compact('departments'));
    }
    public function restore(ReasonRequest $request, $id)
    {
        $RasidJob = RasidJob::onlyTrashed()->findOrFail($id);

        $RasidJob->restore();
        return redirect()->back()->withSuccess(__('dashboard.general.success_restore'));
    }

    public function forceDelete(ReasonRequest $request, $id)
    {
        $RasidJob = RasidJob::onlyTrashed()->findOrFail($id);
        $RasidJob->forceDelete();
        return redirect()->back()->withSuccess(__('dashboard.general.success_delete'));
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


    // public function exportPDF(Request $request)
    // {
    //     return  Excel::download(new JobsExport($request), 'jobs.pdf');
    // }

    public function exportPDF(Request $request)
    {
        $jobs = RasidJob::without('employee')->search($request)
        ->CustomDateFromTo($request)
        ->ListsTranslations('name')
        ->sortBy($request)
        ->addSelect('rasid_jobs.created_at', 'rasid_jobs.is_active', 'rasid_jobs.department_id', 'rasid_jobs.is_vacant')
        ->get();


        $data = [
            'jobs' => $jobs
        ];

        $pdf = PDF::loadView('dashboard.rasid_job.export', $data);
        return $pdf->stream('jobs.pdf');
    }
}
