<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\DepartmentRequest;
use App\Http\Resources\Dashboard\DepartmentResource;
use App\Models\Department\Department;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::with("children")->whereNull("parent_id")
            ->paginate((int)($request->page ?? 15));

        return DepartmentResource::collection($departments)
            ->additional([
                'status' => true,
                'message' => ""
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


    public function show(Department $department)
    {
        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => ""
            ]);;
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
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $department->delete();

        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_delete")
            ]);
    }
}
