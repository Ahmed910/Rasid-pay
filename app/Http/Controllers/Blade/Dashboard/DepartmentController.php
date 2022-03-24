<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\DepartmentRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Blade\Dashboard\Activitylog\ActivityLogCollection;
use App\Http\Resources\Blade\Dashboard\Department\DepartmentCollection;
use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Models\Department\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
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
        $departments = Department::with('parent.translations')->ListsTranslations('name')->where('parent_id', null)->pluck('name', 'id')->toArray();
        $locales = config('translatable.locales');
        return view('dashboard.department.create', compact('departments', 'locales'));
    }

    public function store(DepartmentRequest $request, Department $department)
    {
        $department->fill($request->validated())->save();
        return redirect()->route('dashboard.department.index')->withSuccess(__('dashboard.general.success_add'));
    }

    public function show(Request $request, $id)
    {
        $department = Department::withTrashed()->findOrFail($id);
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

        $activitiesQuery  = $department->activity()
            ->sortBy($request);

        if ($request->ajax()) {
            $activityCount = $activitiesQuery->count();
            $activities = $activitiesQuery->skip($request->start)
                ->take(($request->length == -1) ? $activityCount : $request->length)
                ->get();

            return ActivityLogCollection::make($activities)
                ->additional(['total_count' => $activityCount]);
        }

        return view('dashboard.department.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $departments = Department::with('parent.translations')->ListsTranslations('name')->where('parent_id', null)->pluck('name', 'id')->toArray();
        $locales = config('translatable.locales');
        return view('dashboard.department.edit', compact('departments', 'department', 'locales'));
    }


    public function update(DepartmentRequest $request, Department $department)
    {
        $department->fill($request->validated() + ['updated_at' => now()])->save();
        return redirect()->route('dashboard.department.index')->withSuccess(__('dashboard.general.success_update'));
    }


    public function archive(Request $request)
    {

        $sortingColumns = [
            'id',
            'name',
            'parent',
            'deleted_at',

        ];

        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $sortingColumns[$request->order[0]['column']], 'dir' => $request->order[0]['dir']];
        }

        $departmentsQuery = Department::onlyTrashed()
            ->search($request)
            ->CustomDateFromTo($request)
            ->with('parent.translations')
            ->ListsTranslations('name')
            ->addSelect('departments.deleted_at', 'departments.parent_id')
            ->sortBy($request);

        if ($request->ajax()) {
            $departmentCount = $departmentsQuery->count();
            $departments = $departmentsQuery->skip($request->start)
                ->take(($request->length == -1) ? $departmentCount : $request->length)
                ->get();

            return DepartmentCollection::make($departments)
                ->additional(['total_count' => $departmentCount]);
        }

        $parentDepartments = Department::onlyTrashed()->where('is_active', 1)
            ->has("children")
            ->orWhere(function ($q) {
                $q->doesntHave('children')
                    ->WhereNull('parent_id');
            })
            // ->without("images", 'addedBy')
            ->select("id")
            ->ListsTranslations("name")
            ->pluck('name', 'id');

        return view('dashboard.archive.department.index', compact('parentDepartments'));
    }

    public function restore(ReasonRequest $request, $id)
    {

        $department = Department::onlyTrashed()->findOrFail($id);

        $department->restore();
        return redirect()->back();
    }

    public function forceDelete(ReasonRequest $request, $id)
    {
        $department = Department::onlyTrashed()->findOrFail($id);
        $department->forceDelete();
        return redirect()->back();
    }
}
