<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\DepartmentsArchiveExport;
use App\Exports\DepartmentsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\DepartmentRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\Department\{DepartmentResource, DepartmentCollection, ParentResource};
use App\Models\Department\Department;
use App\Services\GeneratePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::search($request)
            ->ListsTranslations('name')
            ->customDateFromTo($request)
            ->with('parent.translations')
            ->addSelect('departments.created_at', 'departments.is_active', 'departments.parent_id', 'departments.added_by_id')
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
                    ->whereNull('parent_id');
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

    public function getAllDepartments(Request $request)
    {
        return response()->json([
            'data' => Department::select('id')->when($request->department_id, function ($q) use ($request) {
                $children = Department::flattenChildren(Department::withTrashed()->findOrFail($request->department_id));
                $q->whereNotIn('departments.id', $children);
            })->when($request->department_type == 'children', function ($q) {
                $q->where(function ($q) {
                    $q->has('children')->orWhereNull('parent_id');
                });
            })->when($request->activate_case, function ($q) use ($request) {
                switch ($request->activate_case) {
                    case 'active':
                        $q->where('is_active', 1);
                        break;
                    case 'hold':
                        $q->where('is_active', 0);
                        break;
                }
            })->when($request->has_jobs, function ($q) use ($request) {
                $q->whereHas('rasidJobs', function ($q) use ($request) {
                    $q->where(['rasid_jobs.is_active' => true, 'is_vacant' => true])
                        ->orWhere(function ($q) use ($request) {
                            $q->where(['is_active' => true, 'is_vacant' => false])
                                ->whereHas('employee.user', fn ($q) => $q->where('users.id', $request->admin_id));
                        });
                });
            })->ListsTranslations('name')
                ->addSelect('departments.is_active')
                ->without(['images', 'addedBy', 'translations'])->get(),
            'status' => true,
            'message' =>  '',
        ]);
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
        $department = Department::withTrashed()->findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $department->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return DepartmentCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function update(DepartmentRequest $request,  $department)
    {
        $dep = Department::withTrashed()->findOrFail($department);
        $dep->fill($request->validated() + ['updated_at' => now()])->save();


        return DepartmentResource::make($dep)
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
        $departments = Department::onlyTrashed()
            ->search($request)
            ->ListsTranslations('name')
            ->customDateFromTo($request, 'deleted_at', 'deleted_from', 'deleted_to')
            ->with('parent.translations')
            ->addSelect('departments.created_at', 'departments.deleted_at', 'departments.is_active', 'departments.parent_id', 'departments.added_by_id')
            ->latest("deleted_at")
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

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

    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $departmentsQuery = Department::search($request)
            ->customDateFromTo($request)
            ->with('parent.translations')
            ->ListsTranslations('name')
            ->sortBy($request)
            ->addSelect('departments.created_at', 'departments.is_active', 'departments.parent_id', 'departments.added_by_id')
            ->get();

        if (!$request->has('created_from')) {
            $createdFrom = Department::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.department',
                [
                    'departments' => $departmentsQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('departments/pdfs/');
        $file  = url('/storage/' . $mpdfPath);

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }

    public function exportExcel(Request $request)
    {
        $fileName = uniqid() . time();
        Excel::store(new DepartmentsExport($request), 'departments/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'departments/excels/' . $fileName . '.xlsx');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }

    public function exportPDFArchive(Request $request, GeneratePdf $pdfGenerate)
    {
        $departmentsQuery =  Department::onlyTrashed()
            ->search($request)
            ->ListsTranslations('name')
            ->customDateFromTo($request, 'deleted_at', 'deleted_from', 'deleted_to')
            ->with('parent.translations')
            ->addSelect('departments.created_at', 'departments.deleted_at', 'departments.is_active', 'departments.parent_id', 'departments.added_by_id')
            ->latest("deleted_at")
            ->sortBy($request)
            ->get();

        if (!$request->has('created_from')) {
            $createdFrom = Department::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.archive.department',
                [
                    'departments_archive' => $departmentsQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('departmentsArchive/pdfs/');
        $file  = url('/storage/' . $mpdfPath);

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }

    public function exportExcelArchive(Request $request)
    {
        $fileName = uniqid() . time();
        Excel::store(new DepartmentsArchiveExport($request), 'departmentsArchive/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'departmentsArchive/excels/' . $fileName . '.xlsx');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
