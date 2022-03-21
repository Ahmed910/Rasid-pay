<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\DepartmentRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Blade\Dashboard\Department\DepartmentCollection;
use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Models\Department\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $sortingColumns = [
            'id',
            'name',
            'parent',
            'created_at',
            'is_active'
        ];

        if(isset($request->order[0]['column'])){
            $request['sort'] = ['column' => $sortingColumns[$request->order[0]['column']], 'dir' => $request->order[0]['dir']];
        }

        $departmentsQuery = Department::search($request)
            ->CustomDateFromTo($request)
            ->with('parent.translations')
            ->ListsTranslations('name')
            ->addSelect('departments.created_at', 'departments.is_active', 'departments.parent_id', 'departments.added_by_id')
            ->sortBy($request);


        if ($request->ajax()) {
            $departmentCount = $departmentsQuery->count();
            $departments = $departmentsQuery->skip($request->start)
                ->take(($request->length == -1) ? $departmentCount : $request->length)
                ->get();

            return DepartmentCollection::make($departments)
                ->additional(['total_count' => $departmentCount]);
        }

        $parentDepartments = Department::where('is_active', 1)
            ->has("children")
            ->orWhere(function ($q) {
                $q->doesntHave('children')
                    ->WhereNull('parent_id');
            })
            ->without("images", 'addedBy')
            ->select("id")
            ->ListsTranslations("name")
            ->pluck('name', 'id');

        return view('dashboard.department.index', compact('parentDepartments'));
    }

    public function create()
    {
        $departments = Department::with('parent.translations')->ListsTranslations('name')->where('parent_id', null)->pluck('name', 'id');
        $locales = config('translatable.locales');
        return view('dashboard.department.create', compact('departments', 'locales'));
    }

    public function store(DepartmentRequest $request, Department $department)
    {
        $department->fill($request->validated())->save();
        return redirect()->route('dashboard.departments.index')->with('success', __('dashboard.general.success_add'));
    }

    public function show(Request $request,$id)
    {
        $department = Department::withTrashed()->findOrFail($id);
        $activitiesQuery  = $department->activity()->get();

    if ($request->ajax()) {
        $activityCount = $activitiesQuery->count();
        $activities = $activitiesQuery->skip($request->start)
            ->take(($request->length == -1) ? $activityCount : $request->length)
            ->get();

        return ActivityLogResource::collection($department->activity())
            ->additional(['total_count' => $activityCount]);
    }


        return view('dashboard.department.show',compact('department','activitiesQuery'));
    }

    public function edit(Department $department)
    {
        $departments = Department::with('parent.translations')->ListsTranslations('name')->where('parent_id', null)->pluck('name', 'id');
        $locales = config('translatable.locales');
        return view('dashboard.department.edit', compact('departments', 'department','locales'));
    }


    public function update(DepartmentRequest $request, Department $department)
    {
        $department->fill($request->validated() + ['updated_at' => now()])->save();
        return redirect()->route('dashboard.departments.index')->with('success', __('dashboard.general.success_update'));
    }


    public function destroy(ReasonRequest $request, Department $department)
    {
    }


}
