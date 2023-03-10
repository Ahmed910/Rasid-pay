<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\DepartmentsArchiveExport;
use App\Exports\DepartmentsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DepartmentRequest;
use App\Http\Requests\Dashboard\ReasonRequest;
use App\Http\Resources\Api\Dashboard\Department\{DepartmentResource, DepartmentCollection, ParentResource};
use App\Models\ActivityLog;
use App\Models\Department\Department;
use App\Services\GeneratePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::search($request, 'index')
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
                $q->when($request->admin_id, function ($q) use ($request) {
                    $q->orWhereHas('rasidJobs', function ($q) use ($request) {
                        $q->whereHas('employee.user', fn ($q) => $q->where('users.id', $request->admin_id));
                    });
                });
            })->when($request->has_jobs, function ($q) use ($request) {
                $q->whereHas('rasidJobs', function ($q) use ($request) {
                    // check if job is active and job is free
                    if ($request->job_is_active && $request->job_is_vacant) {
                        $q->where(['rasid_jobs.is_active' => true, 'is_vacant' => true]);
                        // check if job is active and job is busy
                    } elseif ($request->job_is_active && !$request->job_is_vacant) {
                        $q->where(['rasid_jobs.is_active' => true, 'is_vacant' => false])
                            ->when($request->admin_id, function ($q) use ($request) {
                                $q->whereHas('employee.user', fn ($q) => $q->where('users.id', $request->admin_id));
                            });

                        // check if job is inactive and job is free
                    } elseif (!$request->job_is_active && $request->job_is_vacant) {
                        $q->where(['rasid_jobs.is_active' => false, 'is_vacant' => true]);
                        // check if job is inactive and job is busy
                    } else {
                        $q->where(['rasid_jobs.is_active' => false, 'is_vacant' => false])
                            ->when($request->admin_id, function ($q) use ($request) {
                                $q->whereHas('employee.user', fn ($q) => $q->where('users.id', $request->admin_id));
                            });
                    }
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
        if ((!$request->has('with_activity') || $request->with_activity) && $request->routeIs('*.show')) {
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

        if ($dep->rasidJobs()->where('is_vacant', 0)->exists() && $request->is_active == 0) {
            return response()->json([
                'status' => false,
                'message' =>  trans("dashboard.department.validation.can_not_be_deactivated_has_job"),
                'data' => null
            ], 422);
        }
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
            ->search($request, 'archive')
            ->ListsTranslations('name')
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

    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {

        $departmentsQuery = Department::search($request, 'index')
            ->customDateFromTo($request)
            ->with('parent.translations')
            ->ListsTranslations('name')
            ->sortBy($request)
            ->addSelect('departments.created_at', 'departments.is_active', 'departments.parent_id', 'departments.added_by_id')
            ->get();

        Loggable::addGlobalActivity(Department::class, array_merge($request->query(), ['parent_id' => Department::find($request->parent_id)?->name]), ActivityLog::EXPORT, 'index');
        if (!$request->has('created_from')) {
            $createdFrom = Department::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        if (!$departmentsQuery->count()) {
            $file = GeneratePdf::createNewFile(
                trans('dashboard.department.departments'),
                $createdFrom,'dashboard.exports.department',
                $departmentsQuery,0,$chunk,'departments/pdfs/'
            );
            $file =  url(str_replace(base_path('storage/app/public/'), 'storage/', $file));
            return response()->json([
                'data'   => [
                    'file' => $file
                ],
                'status' => true,
                'message' => ''
            ]);
        }

        foreach (($departmentsQuery->chunk($chunk)) as $key => $rows) {

            $names[] = GeneratePdf::createNewFile(
                trans('dashboard.department.departments'),$createdFrom,
                'dashboard.exports.department',
                $rows,$key,$chunk,'departments/pdfs/'
            );
        }
        $file = GeneratePdf::mergePdfFiles($names, 'departments/pdfs/departments.pdf');

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
        Loggable::addGlobalActivity(Department::class, array_merge($request->query(), ['parent_id' => Department::find($request->parent_id)?->name]), ActivityLog::EXPORT, 'index');

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
            ->search($request, 'archive')
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

        $chunk = 200;
        $names = [];
        if (!$departmentsQuery->count()) {
            $file = GeneratePdf::createNewFile(
                trans('dashboard.department.department_archive'),
                $createdFrom,'dashboard.exports.archive.department',
                $departmentsQuery,0,$chunk,'departmentsArchive/pdfs/'
            );
            $file =  url(str_replace(base_path('storage/app/public/'), 'storage/', $file));
            return response()->json([
                'data'   => [
                    'file' => $file
                ],
                'status' => true,
                'message' => ''
            ]);
        }
        foreach (($departmentsQuery->chunk($chunk)) as $key => $rows) {
                $names[] = GeneratePdf::createNewFile(
                    trans('dashboard.department.department_archive'),$createdFrom,
                    'dashboard.exports.archive.department',
                    $rows,$key,$chunk,'departmentsArchive/pdfs/'
                );
        }

        $file = GeneratePdf::mergePdfFiles($names, 'departmentsArchive/pdfs/departments.pdf');

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
