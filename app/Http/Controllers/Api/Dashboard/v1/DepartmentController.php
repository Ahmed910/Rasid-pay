<?php

namespace App\Http\Controllers\Api\Dashboard\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboad\DepartmentRequest;
use App\Http\Resources\Dashboard\DepartmentResource;
use App\Models\Department\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::with("children")->whereNull("parent_id")
            ->paginate($request->page ?? 15);

        return DepartmentResource::collection($departments)
            ->additional([
                'status' => true,
                'message' => "Get All Departments"
            ]);
    }

    public function store(DepartmentRequest $request, Department $department)
    {
        $department->fill($request->validated())->save();

        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => "Created Successfully"
            ]);
    }


    public function show(Department $department)
    {
        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => "Created Successfully"
            ]);;
    }


    public function update(DepartmentRequest $request, Department $department)
    {
        $department->fill($request->validated()["departments"])->save();

        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => "Updated Successfully"
            ]);;
    }


    public function destroy(Department $department)
    {
        if ($department->children()->exists()) {
            return response()->json([
                'status' => false,
                'message' => "This item has relationships,so you cannot delete it ",
                'data' => null
            ], 401);
        }

        $department->delete();

        return DepartmentResource::make($department)
            ->additional([
                'status' => true,
                'message' => "Deleted Successfully"
            ]);
    }
}
