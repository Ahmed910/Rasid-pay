<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\DepartmentRequest;
use App\Http\Resources\Dashboard\Department\DepartmentCollection;
use App\Http\Resources\Dashboard\Department\DepartmentResource;
use App\Models\Department\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Department2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departments = Department::search($request)
            ->CustomDateFromTo($request)
            ->with('parent.translations'
            )
            ->ListsTranslations('name')
            ->addSelect('created_at', 'is_active', 'parent_id', 'added_by_id')
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));
        $res = DepartmentResource::collection($departments);
//        dd($dapartments);
        return View("dashboard.department2.index", ["dapartments" => $res]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View()->make("dashboard.department2.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $departmentRequest)
    {
        $dapartment = Department::create($departmentRequest->validated());
        dd($dapartment);
        return Redirect::to("dashboard.department2.index");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)

    {
        $department = Department::withTrashed()->with('translations')->findOrFail($id);
        $activities = $department->activity()
        ->sortBy($request)
        ->get();

        return View("dashboard.department2.show", ["department" => $department, 'activity' => $activities]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the shark
        $department = Department::withTrashed()->with('translations')->findOrFail($id);

        return View('dashboard.department2.edit')
            ->with('department', $department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
