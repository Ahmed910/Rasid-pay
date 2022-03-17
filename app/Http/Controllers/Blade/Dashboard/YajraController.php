<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\DepartmentRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\Department\{DepartmentResource, DepartmentCollection, ParentResource};
use App\Models\Department\Department;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;

class YajraController extends Controller
{
    public function index()
    {

        // $data = Department::with('parent.translations')
        // ->ListsTranslations('name')
        // ->addSelect('created_at', 'is_active', 'parent_id', 'added_by_id')->get();

        // dd($data);

        $mainDepartments = Department::where('is_active', 1)
            ->has("children")
            ->orWhere(function ($q) {
                $q->doesntHave('children')
                    ->WhereNull('parent_id');
            })
            ->without("images", 'addedBy')
            ->select("id")
            ->ListsTranslations("name")
            ->get();

        return view('dashboard.yajra.index', compact('mainDepartments'));
    }

    public function getDepartments(Request $request)
    {



        if ($request->ajax()) {
            if ($request->is_active && $request->is_active == '-1') unset($request['is_active']);;

            $data = Department::search($request)
                ->CustomDateFromTo($request)
                ->with('parent.translations')
                ->ListsTranslations('name')
                ->addSelect('created_at', 'is_active', 'parent_id', 'added_by_id');

            // $data = Department::with('parent.translations')
            //     ->ListsTranslations('name')
            //     ->addSelect('created_at', 'is_active', 'parent_id', 'added_by_id');


            return Datatables::of($data)
                ->addIndexColumn()

                ->editColumn('is_active', function ($data) {
                    if ($data->is_active == 1) {
                        $span = '<span class="badge bg-success-opacity py-2 px-4">مفعل</span>';
                    } else {
                        $span = '<span class="badge bg-danger-opacity py-2 px-4">معطل</span>';
                    }
                    return $span;
                })

                ->editColumn('created_at', function ($data) {
                    return date('Y-m-d', strtotime($data->created_at));
                })

                ->addColumn('parent.name', function ($data) {
                    if ($data->parent != null) {
                        $data = $data->parent->name;
                    } else {
                        $data = '-----';
                    }
                    return $data;
                })

                ->addColumn('action', function ($data) {
                    $actionBtn = ' <a href="department-view.html" class="azureIcon" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="التفاصيل"><i
                        class="mdi mdi-eye-outline"></i></a>
                <a href="department-add.html" class="warningIcon" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="تعديل"><i
                        class="mdi mdi-square-edit-outline"></i></a>
                <a href="#" class="primaryIcon" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="أرشفة"><i data-bs-toggle="modal"
                        data-bs-target="#notArchiveModal"
                        class="mdi mdi-archive-arrow-down-outline"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'is_active'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('dashboard.yajra.create');
    }

    public function store(DepartmentRequest $request, Department $department)
    {
    }

    public function show(Request $request, $id)
    {
        return view('dashboard.yajra.show');
    }

    public function edit($id)
    {
        return view('dashboard.yajra.edit');
    }


    public function update(DepartmentRequest $request, Department $department)
    {
    }


    public function destroy(ReasonRequest $request, Department $department)
    {
    }
}
