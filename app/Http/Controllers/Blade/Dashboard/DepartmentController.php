<?php

namespace App\Http\Controllers\Blade\Dashboard;

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
       return view('dashboard.department.index');
    }

    public function create()
    {
        return view('dashboard.department.create');
    }

    public function store(DepartmentRequest $request, Department $department)
    {

    }

    public function show(Request $request, $id)
    {
        return view('dashboard.department.show');
    }

    public function edit($id)
    {
        return view('dashboard.department.edit');
    }


    public function update(DepartmentRequest $request, Department $department)
    {

    }


    public function destroy(ReasonRequest $request, Department $department)
    {

    }

}
