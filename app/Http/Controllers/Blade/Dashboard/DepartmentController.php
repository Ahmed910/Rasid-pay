<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Exports\DepartmentsArchiveExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DepartmentRequest;
use App\Http\Requests\Dashboard\ReasonRequest;
use App\Http\Resources\Blade\Dashboard\Activitylog\ActivityLogCollection;
use App\Http\Resources\Blade\Dashboard\Department\DepartmentCollection;
use App\Models\Department\Department;
use Illuminate\Http\Request;
use App\Exports\DepartmentsExport;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }

        if ($request->ajax()) {
            $departmentsQuery = Department::search($request)
                ->CustomDateFromTo($request)
                ->with('parent.translations')
                ->ListsTranslations('name')
                ->addSelect('departments.created_at', 'departments.is_active', 'departments.parent_id', 'departments.added_by_id')
                ->sortBy($request);

            $departmentCount = $departmentsQuery->count();
            $departments = $departmentsQuery->skip($request->start)
                ->take(($request->length == -1) ? $departmentCount : $request->length)
                ->get();

            return DepartmentCollection::make($departments)
                ->additional(['total_count' => $departmentCount]);
        }

        $parentDepartments = Department::/*where('is_active', 1)
            ->*/has("children")
            ->orWhere(function ($q) {
                $q->doesntHave('children')
                    ->WhereNull('parent_id');
            })
            ->without("images", 'addedBy')
            ->select("id")
            ->ListsTranslations("name")
            ->pluck('name', 'id')->toArray();


        return view('dashboard.department.index', compact('parentDepartments'));
    }

    public function create()
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'department')) ? session(['perviousPage' => 'department']) : session(['perviousPage' => 'home']);

        $departments = Department::with('parent.translations')->ListsTranslations('name')->where(['is_active' => 1])->pluck('name', 'id')->toArray();
        $locales = config('translatable.locales');

        $departments = array_merge(['without' => trans('dashboard.department.without_parent')], $departments);

        return view('dashboard.department.create', compact('departments', 'locales', 'previousUrl'));
    }

    public function store(DepartmentRequest $request, Department $department)
    {
        if (!request()->ajax()) {
            $department->fill($request->validated() + ['added_by_id' => auth()->id()])->save();
            return redirect()->back()->withSuccess(__('dashboard.general.success_add'));
        }
    }

    public function show(Request $request, $id)
    {
        $department = Department::withTrashed()->findOrFail($id);
        $sortingColumns = [
            'id',
            'employee',
            'main_program',
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
            $activities = $activitiesQuery->skip($request->start)->take($request->length == -1 ? $activityCount : $request->length)->get();

            return ActivityLogCollection::make($activities)
                ->additional(['total_count' => $activityCount]);
        }

        return view('dashboard.department.show', compact('department'));
    }

    public function edit($id)
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'department')) ? session(['perviousPage' => 'department']) : session(['perviousPage' => 'home']);

        $department = Department::withTrashed()->findOrFail($id);
        $departments = Department::with('parent.translations')->ListsTranslations('name')->where(['is_active' => 1])->orWhere('departments.id',$id)->pluck('name', 'id')->toArray();

        $departments = array_merge([null => trans('dashboard.department.without_parent')], $departments);

        $locales = config('translatable.locales');
        return view('dashboard.department.edit', compact('departments', 'department', 'locales', 'previousUrl'));
    }


    public function update(DepartmentRequest $request,  $department)
    {

        if (!request()->ajax()) {
            $dep = Department::withTrashed()->findOrFail($department);
            $dep->fill($request->validated() + ['updated_at' => now()])->save();
            return redirect()->route('dashboard.department.index')->withSuccess(__('dashboard.general.success_update'));
        }
    }
    public function archive(Request $request)
    {
        $sortingColumns = [
            'id',
            'name',
            'parent',
            'deleted_at',
            'is_active'
        ];

        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $sortingColumns[$request->order[0]['column']], 'dir' => $request->order[0]['dir']];
        }

        $departmentsQuery = Department::onlyTrashed()
            ->search($request)
            ->CustomDateFromTo($request)
            ->searchDeletedAtFromTo($request)
            ->with('parent.translations')
            ->ListsTranslations('name')
            ->addSelect('departments.deleted_at', 'departments.parent_id','departments.is_active')
            ->sortBy($request);

        if ($request->ajax()) {
            $departmentCount = $departmentsQuery->count();
            $departments = $departmentsQuery->skip($request->start)
                ->take(($request->length == -1) ? $departmentCount : $request->length)
                ->get();

            return DepartmentCollection::make($departments)
                ->additional(['total_count' => $departmentCount]);
        }

        $parentDepartments = Department::has("children")
            ->orWhere(function ($q) {
                $q->doesntHave('children')
                    ->WhereNull('parent_id');
            })
            // ->without("images", 'addedBy')
            ->select("id")
            ->ListsTranslations("name")
            ->pluck('name', 'id')->toArray();

        return view('dashboard.archive.department.index', compact('parentDepartments'));
    }

    public function destroy(ReasonRequest $request, Department $department)
    {
        if ($request->ajax()) {
            $department->delete();
            return response()->json([
                'message' => __('dashboard.general.success_archive')
            ]);
        }
    }


    public function restore(ReasonRequest $request, $id)
    {
        if ($request->ajax()) {
            $department = Department::onlyTrashed()->findOrFail($id);
            $department->restore();
            return response()->json([
                'message' => __('dashboard.general.success_restore')
            ]);
        }
    }

    public function forceDelete(ReasonRequest $request, $id)
    {
        if ($request->ajax()) {

            $department = Department::onlyTrashed()->findOrFail($id);
            $department->forceDelete();
            return response()->json([
                'message' => __('dashboard.general.success_delete')
            ]);
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new DepartmentsExport($request), 'departments.xlsx');
    }



    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $departmentsQuery = Department::search($request)
            ->CustomDateFromTo($request)
            ->with('parent.translations')
            ->ListsTranslations('name')
            ->addSelect('departments.created_at', 'departments.is_active', 'departments.parent_id', 'departments.added_by_id')->get();

        if (!$request->has('created_from')) {
            $createdFrom = Department::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }



        $mpdf = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.department',
                [
                    'departments' => $departmentsQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->export();

        return $mpdf;
    }

    public function exportArchieve(Request $request)
    {
        return Excel::download(new DepartmentsArchiveExport($request), 'departments_archive.xlsx');
    }

    public function exportPDFArchieve(Request $request,GeneratePdf $pdfGenerate)
    {
        $departments_archiveQuery = Department::onlyTrashed()
            ->search($request)
            ->CustomDateFromTo($request)
            ->searchDeletedAtFromTo($request)
            ->with('parent.translations')
            ->ListsTranslations('name')
            ->addSelect('departments.deleted_at', 'departments.parent_id')
            ->get();

    if (!$request->has('created_from')) {
        $createdFrom = Department::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
    }



    $mpdf = $pdfGenerate->newFile()
        ->view(
            'dashboard.exports.archive.department',
            [
                'departments_archive' => $departments_archiveQuery,
                'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                'date_to'     => format_date($request->created_to) ?? format_date(now()),
                'userId'      => auth()->user()->login_id,

            ]
        )
        ->export();

    return $mpdf;
    }
}
