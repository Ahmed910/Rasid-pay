<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RasidJob\RasidJobRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Blade\Dashboard\Activitylog\ActivityLogCollection;
use App\Http\Resources\Blade\Dashboard\Job\JobCollection;
use App\Models\Department\Department;
use App\Models\RasidJob\RasidJob;
use Illuminate\Http\Request;
use App\Exports\JobsExport;
use Maatwebsite\Excel\Facades\Excel;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {


            $jobsQuery = RasidJob::without('employee')->search($request)
                ->CustomDateFromTo($request)
                ->ListsTranslations('name')
                ->sortBy($request)
                ->addSelect('rasid_jobs.created_at', 'rasid_jobs.is_active', 'rasid_jobs.department_id', 'rasid_jobs.is_vacant');
            $jobCount = $jobsQuery->count();
            $jobs = $jobsQuery->skip($request->start)
                ->take($request['length'] == '-1' ? $jobCount : $request['length'])
                ->get();

            return JobCollection::make($jobs)
                ->additional(['total_count' => $jobCount]);
        }

        $departments = Department::where('is_active', 1)
            ->select("id")
            ->ListsTranslations("name")
            ->pluck('name', 'id');

        return view('dashboard.job.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $departments = Department::with('parent.translations')->ListsTranslations('name')->pluck('name', 'id');
        $locales = config('translatable.locales');
        return view('dashboard.job.create', compact('departments', 'locales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RasidJobRequest $request, RasidJob $rasidJob)
    {

        $rasidJob->fill($request->validated())->save();


        return redirect()->route('dashboard.job.index')->with('success', __('dashboard.general.success_add'));
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
            $activities = $activitiesQuery->skip($request->start)
                ->take(($request->length == -1) ? $activityCount : $request->length)
                ->get();

            return ActivityLogCollection::make($activities)
                ->additional(['total_count' => $activityCount]);
        }

        return view('dashboard.job.show', compact('rasidJob'));
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
        $departments = Department::with('parent.translations')->ListsTranslations('name')->where('parent_id', null)->pluck('name', 'id');
        $locales = config('translatable.locales');
        return view('dashboard.job.edit', compact('departments', 'rasidJob', 'locales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RasidJobRequest $request, RasidJob $job)
    {
        $job->fill($request->validated() + ['updated_at' => now()])->save();

        return redirect()->route('dashboard.job.index')->withSuccess(__('dashboard.general.success_update'));
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

        $jobsQuery = RasidJob::onlyTrashed()
            ->without('employee')
            ->search($request)
            ->CustomDateFromTo($request)
            ->ListsTranslations('name')
            ->sortBy($request)
            ->addSelect('rasid_jobs.department_id', 'rasid_jobs.deleted_at', 'rasid_jobs.is_active');
        if ($request->ajax()) {
            $jobCount = $jobsQuery->count();
            $jobs = $jobsQuery->skip($request->start)
                ->take($request['length'] == '-1' ? $jobCount : $request['length'])
                ->get();

            return JobCollection::make($jobs)
                ->additional(['total_count' => $jobCount]);
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

        return view('dashboard.archive.job.index', compact('departments'));
    }
    public function restore(ReasonRequest $request, $id)
    {
        $rasidJob = RasidJob::onlyTrashed()->findOrFail($id);

        $rasidJob->restore();
        return redirect()->back();
    }

    public function forceDelete(ReasonRequest $request, $id)
    {
        $rasidJob = RasidJob::onlyTrashed()->findOrFail($id);
        $rasidJob->forceDelete();
        return redirect()->back();
    }
    public function destroy(RasidJob $rasidJob, \App\Http\Requests\Dashboard\ReasonRequest $request)
    {
        if (!$rasidJob->is_vacant) $rasidJob->delete();
        return redirect()->route('dashboard.job.index');

    }

    public function export(Request $request)
    {
        return Excel::download(new JobsExport($request), 'jobs.xlsx');
    }
    public function exportPDF(Request $request)
    {
        return  Excel::download(new JobsExport($request), 'jobs.pdf');
    }
}
