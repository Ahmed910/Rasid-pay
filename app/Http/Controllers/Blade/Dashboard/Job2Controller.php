<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RasidJobs\JobRequest;
use App\Http\Requests\V1\Dashboard\RasidJobRequest;
use App\Http\Resources\Blade\Dashboard\Job\JobCollection;
use App\Models\Department\Department;
use App\Models\RasidJob\RasidJob;
use Illuminate\Http\Request;

class Job2Controller extends Controller
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
            ->addSelect('rasid_jobs.created_at', 'rasid_jobs.is_active', 'rasid_jobs.department_id', 'rasid_jobs.is_vacant')
            ;
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

        return view('dashboard.job2.index', compact('departments'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::get()->pluck('name', 'id');

        return view('dashboard.job2.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RasidJobRequest $request, RasidJob $job)
    {

        $job->fill($request->validated())->save();
        return redirect()->route('dashboard.jobs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = RasidJob::without('employee')->findOrFail($id);
        return view('dashboard.job2.show',compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $job = RasidJob::without('employee')->findOrFail($id);
        //  dd($job);
        $departments = Department::get()->pluck('name', 'id');
        return view('dashboard.job2.edit', compact('departments', 'job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RasidJobRequest $request, $id)
    {
        $job = RasidJob::without('employee')->findOrFail($id);
        $job->fill($request->validated() + ['updated_at' => now()])->save();
        return redirect()->route('dashboard.jobs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
