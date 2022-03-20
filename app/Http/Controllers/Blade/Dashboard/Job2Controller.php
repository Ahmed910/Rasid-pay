<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RasidJobs\{JobRequest, FiltetJobsRequest};
use App\Models\Department\Department;
use App\Models\RasidJob\RasidJob;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Job2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FiltetJobsRequest $request)
    {
        // dd('enter');



        // if ($request->ajax()) {

        //     $model = RasidJob::without('employee')->search($request)->CustomDateFromTo($request)->get();
        //     // dd($jobs);
        //     return DataTables::of($model)
        //         ->addIndexColumn()
        //         ->editColumn('actions', function ($model) {

        //             $all = ' <a href="' . route("dashboard.jobs.show",  $model->id) . '" class="azureIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="' . trans('dashboard.job.show') . '"><i class="mdi mdi-eye-outline"></i></a>';
        //             //$all .= '<a onClick="return confirm(\'Are You Sure You Want To Delete This Record ?  \')" data-toggle="tooltip" data-skin-class="tooltip-danger"  data-placement="top" title = "Delete" href = "' . url('/doctors/' . $model->id . '/delete') . '"  class="btn btn-sm btn-outline-danger" style="margin:0 10px"><i class="fa fa-trash"></i></a>';
        //             $all .=  '<a href="' . route("dashboard.jobs.destroy",  $model->id) . '" class="warningIcon" data-bs-toggle="tooltip" data-bs-placement="top" title="تعديل"><i class="mdi mdi-square-edit-outline"></i></a>';
        //             $all .= ' <a href="#" class="primaryIcon" data-bs-toggle="tooltip" data-bs-placement="top"  title="أرشفة"><i data-bs-toggle="modal" data-bs-target="#archiveModal" class="mdi mdi-archive-arrow-down-outline"></i></a>';
        //             return $all;
        //         })->editColumn('department_id', function ($model) {
        //             return  "<div class='flex-shrink-0'> <img src='https://picsum.photos/seed/picsum/100' width='25' class='avatar brround cover-image' alt='...' data-toggle='popoverIMG' /> </div><div class='flex-grow-1 ms-3'>" . $model->department->name . "</div></div>";
        //         })->editColumn('is_active', function ($model) {  // hospital
        //             return $model->is_active ? '<span class="badge bg-success-opacity py-2 px-4" >' . trans("dashboard.job.is_active.active") . '</span>' : '<span class="badge bg-danger-opacity py-2 px-4" >' . trans("dashboard.job.is_active.disactive") . '</span>';
        //         })->editColumn('is_vacant', function ($model) {  // hospital
        //             return  $model->is_vacant ? '<span class="occupied">' . trans("dashboard.job.is_vacant.false") . '</span>' : '<span class="vacant">' . trans("dashboard.job.is_vacant.false") . '</span>';
        //         })->rawColumns(['actions', 'department_id', 'is_active', 'is_vacant'])->make(true);
        // }
        // $departments = Department::get()->pluck('name', 'id');
        // return view('dashboard.job.index', compact('departments'));
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
    public function store(JobRequest $request, RasidJob $job)
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
        //
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
    public function update(JobRequest $request, $id)
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
