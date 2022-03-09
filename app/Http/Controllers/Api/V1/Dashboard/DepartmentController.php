<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\DepartmentRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\Department\{DepartmentResource, DepartmentCollection, ParentResource};
use App\Models\Department\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::search($request)
            ->CustomDateFromTo($request)
            ->with('parent.translations')
            ->ListsTranslations('name')
            ->addSelect('created_at', 'is_active', 'parent_id', 'added_by_id')
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return DepartmentResource::collection($departments)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    public function getAllParents()
    {
        $parents = Department::where('is_active', 1)
            ->has("children")
            ->orWhere(function ($q) {
                $q->doesntHave('children')
                    ->WhereNull('parent_id');
            })
            ->without("images", 'addedBy')
            ->select("id")
            ->ListsTranslations("name")
            ->get();

        return ParentResource::collection($parents)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    public function getAllDepartments()
    {
        return response()->json([
            'data' => Department::ListsTranslations('name')->without(['images', 'addedBy'])->get(),
            'status' => true,
            'message' =>  '',
        ]);
    }

    public function create()
    {
        //
    }

    public function store(DepartmentRequest $request, Department $department)
    {
        $department->fill($request->validated() + ['added_by_id' => auth()->id()])->save();

        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_add")
            ]);
    }

    public function show(Request $request, $id)
    {
        $department = Department::withTrashed()->with('translations')->findOrFail($id);
        $activities  = $department->activity()->paginate((int)($request->per_page ?? 15));
        data_set($activities, 'department', $department);

        return DepartmentCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function edit($id)
    {
        //
    }


    public function update(DepartmentRequest $request, Department $department)
    {
        $department->fill($request->validated() + ['updated_at' => now()])->save();


        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_update")
            ]);;
    }


    public function destroy(ReasonRequest $request, Department $department)
    {
        if ($department->rasidJobs()->exists()) {
            return response()->json([
                'status' => false,
                'message' => trans("dashboard.department.has_jobs_cannot_delete"),
                'data' => null
            ], 422);
        }

        if ($department->children()->exists()) {
            return response()->json([
                'status' => false,
                'message' => trans("dashboard.department.department_has_relationship_cannot_delete"),
                'data' => null
            ], 422);
        }

        $department->delete();

        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_archive")
            ]);
    }

    public function archive(Request $request)
    {
        $departments = Department::onlyTrashed()->search($request)->latest()->paginate((int)($request->perPage ?? 10));

        return DepartmentResource::collection($departments)
            ->additional([
                'message' => 'success',
                'status' => true
            ]);
    }


    public function restore(ReasonRequest $request, $id)
    {
        $department = Department::onlyTrashed()->findOrFail($id);

        $department->restore();

        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.restore')
            ]);
    }


    public function forceDelete(ReasonRequest $request, $id)
    {
        $department = Department::onlyTrashed()->findOrFail($id);

        if ($department->rasidJobs()->exists()) {
            return response()->json([
                'status' => false,
                'message' => trans("dashboard.department.has_jobs_cannot_delete"),
                'data' => null
            ], 422);
        }

        if ($department->children()->exists()) {
            return response()->json([
                'status' => false,
                'message' => ['error' => trans("dashboard.department.department_has_relationship_cannot_delete")],
                'data' => null
            ], 422);
        }

        $department->forceDelete();

        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_delete")
            ]);
    }
}
