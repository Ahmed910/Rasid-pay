<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\DepartmentRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Blade\Dashboard\Department\DepartmentCollection;
use App\Models\Department\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function getDataForIndex(Request $request)
    {
        $sortingColumns = [
            'id',
            'name',
            'parent',
            'created_at',
            'is_active'
        ];
        $request['sort'] = ['column' => $sortingColumns[$request->order[0]['column']], 'dir' => $request->order[0]['dir']];

        $departmentsQuery = Department::search($request)
            ->CustomDateFromTo($request)
            ->with('parent.translations')
            ->ListsTranslations('name')
            ->addSelect('departments.created_at', 'departments.is_active', 'departments.parent_id', 'departments.added_by_id')
            ->sortBy($request);

        $departmentCount = $departmentsQuery->count();
        $departments = $departmentsQuery->skip($request->start)
            ->take($request->length)
            ->get();

        return DepartmentCollection::make($departments)
            ->additional(['total_count' => $departmentCount]);
    }

    public function index(Request $request)
    {
        $departments = Department::where('is_active', 1)
            ->has("children")
            ->orWhere(function ($q) {
                $q->doesntHave('children')
                    ->WhereNull('parent_id');
            })
            ->without("images", 'addedBy')
            ->select("id")
            ->ListsTranslations("name")
            ->take(20)
            ->pluck('name', 'id');

        return view('dashboard.department.index', compact('departments'));
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
