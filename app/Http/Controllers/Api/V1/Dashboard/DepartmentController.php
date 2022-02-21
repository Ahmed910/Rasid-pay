<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\DepartmentRequest;
use App\Http\Resources\Dashboard\Departments\DepartmentResource;
use App\Http\Resources\Dashboard\Departments\ParentResource;
use App\Models\Department\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        //TODO : check this query is not correct
        $departments = Department::search($request)
            ->with(["parent", "translations"])
            ->where(function ($q) {
                $q->has('children')
                ->orWhereNull('parent_id');
            })
            ->sortBy($request)
            ->paginate((int)($request->page ?? 15));

        return DepartmentResource::collection($departments)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    public function getAllParents()
    {
        $parents = Department::where('is_active', 1)
            ->whereHas("children")
            ->orWhere(function ($q) {
                $q->doesntHave('children')
                    ->WhereNull('parent_id');
            })
            ->without("images")
            ->select("id")
            ->ListsTranslations("name")
            ->get();

        return ParentResource::collection($parents)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    public function create()
    {
        //
    }

    public function store(DepartmentRequest $request, Department $department)
    {
        $department->fill($request->validated())->save();

        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_add")
            ]);
    }


    public function show($id)

    {
        $department =   Department::withTrashed()->findOrFail($id);

        return DepartmentResource::make($department->load('translations'))
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);
    }

    public function edit($id)
    {
        //
    }


    public function update(DepartmentRequest $request, Department $department)
    {
        $department->fill($request->validated())->save();

        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_update")
            ]);;
    }


    public function destroy(Department $department)
    {
        if ($department->children()->exists()) {
            return response()->json([
                'status' => false,
                'message' => trans("dashboard.general.has_relationship_cannot_delete"),
                'data' => null
            ], 422);
        }

        $department->delete();

        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_delete")
            ]);
    }

    public function archive(Request $request)
    {
        $departments = Department::onlyTrashed()->latest()->paginate((int)($request->perPage ?? 10));

        return DepartmentResource::collection($departments)
            ->additional([
                'message' => 'success',
                'status' => true
            ]);
    }


    public function restore($id)
    {
        $department = Department::onlyTrashed()->findOrFail($id);

        $department->restore();

        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.restore')
            ]);
    }


    public function forceDelete($id)
    {
        $department = Department::onlyTrashed()->findOrFail($id);

        if ($department->children()->exists()) {
            return response()->json([
                'status' => false,
                'message' => ['error' => trans("dashboard.general.has_relationship_cannot_delete")],
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
