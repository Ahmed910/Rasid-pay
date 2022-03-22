<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\RasidJobRequest;
use App\Http\Resources\Dashboard\RasidJob\{RasidJobResource, RasidJobCollection};
use App\Models\Department\Department;
use App\Models\RasidJob\RasidJob;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $rasidJobs = RasidJob::search($request)
        //     ->CustomDateFromTo($request)
        //     ->ListsTranslations('name')
        //     ->sortBy($request)
        //     ->paginate((int)($request->per_page ?? config("globals.per_page")));

        $rasidJobs=RasidJob::all();

        return view('dashboard.job.index',compact('rasidJobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $departments = Department::with('parent.translations')->ListsTranslations('name')->where('parent_id', null)->pluck('name', 'id');
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
    public function show($id)
    {
        $rasidJob = RasidJob::findOrFail($id);
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
    public function update(RasidJobRequest $request, RasidJob $rasidJob)
    {
    // dd($request->validated());
    $rasidJob->fill($request->validated() + ['updated_at' => now()])->save();

        return redirect()->route('dashboard.job.index')->with('success', __('dashboard.general.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RasidJob $rasidJob)
    {
        
    }



}
