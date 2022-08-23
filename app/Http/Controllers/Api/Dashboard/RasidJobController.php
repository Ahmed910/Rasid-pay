<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\JobsExport;
use App\Exports\RasidJobsArchiveExport;
use Illuminate\Http\Request;
use App\Models\RasidJob\RasidJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Dashboard\RasidJob\{RasidJobResource, RasidJobCollection};
use App\Http\Requests\Dashboard\RasidJobRequest;
use App\Http\Requests\Dashboard\ReasonRequest;
use App\Models\ActivityLog;
use App\Models\Department\Department;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;

class RasidJobController extends Controller
{

    public function index(Request $request)
    {
        $rasidJobs = RasidJob::search($request, 'index')
            ->has("department")
            ->ListsTranslations('name')
            ->select('rasid_jobs.*')
            ->customDateFromTo($request)
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return RasidJobResource::collection($rasidJobs)
            ->additional([
                'message' => '',
                'status' => true
            ]);
    }



    public function store(RasidJobRequest $request, RasidJob $rasidJob)
    {
        $rasidJob->fill($request->validated() + ['added_by_id' => auth()->id()])->save();

        return RasidJobResource::make($rasidJob)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_add')
            ]);
    }


    public function show(Request $request, $id)
    {

        $rasidJob  = RasidJob::withTrashed()->findOrFail($id);

        $activities = [];
        if ((!$request->has('with_activity') || $request->with_activity) && $request->routeIs('*.show')) {
            $activities  = $rasidJob->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }


        return RasidJobCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);
    }


    public function update(RasidJobRequest $request, $rasid_job)
    {

        $rasidJob = RasidJob::withTrashed()->findOrFail($rasid_job);
        $rasidJob->fill($request->validated() + ['updated_at' => now()])->save();

        return RasidJobResource::make($rasidJob)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_update')
            ]);
    }



    public function archive(Request $request)
    {
        $rasidJobs = RasidJob::onlyTrashed()
            ->search($request, 'archive')
            ->ListsTranslations('name')
            ->with('department')
            ->select('rasid_jobs.*')
            ->sortBy($request, 'archive')
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return RasidJobResource::collection($rasidJobs)
            ->additional([
                'message' => '',
                'status' => true
            ]);
    }




    public function restore(ReasonRequest $request, $id)
    {

        $rasidJob = RasidJob::onlyTrashed()->findOrFail($id);

        $rasidJob->restore();

        return RasidJobResource::make($rasidJob)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.restore')

            ]);
    }


    public function destroy(ReasonRequest $request, RasidJob $rasidJob)
    {

        if (!$rasidJob->is_vacant) {

            return response()->json([
                'status' => false,
                'message' => trans("dashboard.rasid_job.jobs_hired_archived"),
                'data' => null
            ], 422);
        }

        $rasidJob->delete();



        return RasidJobResource::make($rasidJob)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_archive')
            ]);
    }

    public function forceDelete($id)
    {

        $rasidJob = RasidJob::onlyTrashed()->findOrFail($id);

        if (!$rasidJob->is_vacant) {

            return response()->json([
                'status' => false,
                'message' => trans("dashboard.rasid_job.jobs_hired_deleted"),
                'data' => null
            ], 422);
        }

        $rasidJob->forceDelete();

        return RasidJobResource::make($rasidJob)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_delete')
            ]);
    }


    public function getVacantJobs($id, Request $request)
    {
        return response()->json([
            'data' => RasidJob::query()
                ->where(['department_id' => $id])
                ->when($request->is_active, fn ($q) => $q->where('is_active', true))
                ->when($request->admin_id, fn ($q) =>  $q->whereHas('employee', fn ($q) => $q->where('user_id', '<>', $request->admin_id)))
                ->select('id')
                ->ListsTranslations('name')
                ->when($request->has('is_vacant'), fn ($q) => $q->where('is_vacant', true)
                    ->orWhereRelation('employee', 'user_id', $request->admin_id))
                ->without(['images', 'addedBy', 'translations', 'department', 'employee'])->get(),
            'status' => true,
            'message' =>  '',
        ]);
    }

    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $jobsQuery = RasidJob::without('employee')->search($request, 'index')
            ->customDateFromTo($request)
            ->ListsTranslations('name')
            ->sortBy($request)
            ->addSelect('rasid_jobs.created_at', 'rasid_jobs.is_active', 'rasid_jobs.department_id', 'rasid_jobs.is_vacant')
            ->get();

        Loggable::addGlobalActivity(RasidJob::class, array_merge($request->query(), ['department_id' => Department::find($request->department_id)?->name]), ActivityLog::EXPORT, 'index');

        if (!$request->has('created_from')) {
            $createdFrom = RasidJob::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        foreach (($jobsQuery->chunk($chunk)) as $key => $rows) {
            $names[] = base_path('storage/app/public/') . $generatePdf->newFile()
                ->setHeader(trans('dashboard.rasid_job.rasid_jobs'), $createdFrom)
                ->view('dashboard.exports.job', $rows, $key, $chunk)
                ->storeOnLocal('rasid_jobs/pdfs/');
        }

        $file = GeneratePdf::mergePdfFiles($names, 'rasid_jobs/pdfs/rasid_jobs.pdf');

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
        Excel::store(new JobsExport($request), 'rasidJobs/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'rasidJobs/excels/' . $fileName . '.xlsx');
        Loggable::addGlobalActivity(RasidJob::class, array_merge($request->query(), ['department_id' => Department::find($request->department_id)?->name]), ActivityLog::EXPORT, 'index');

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
        $rasidJobsQuery = RasidJob::onlyTrashed()
            ->search($request, 'archive')
            ->ListsTranslations('name')
            ->customDateFromTo($request, 'deleted_at', 'deleted_from', 'deleted_to')
            ->with('department')
            ->select('rasid_jobs.*')
            ->sortBy($request, 'archive')
            ->get();

        Loggable::addGlobalActivity(RasidJob::class, array_merge($request->query(), ['department_id' => Department::find($request->department_id)?->name]), ActivityLog::EXPORT, 'archive');

        if (!$request->has('created_from')) {
            $createdFrom = RasidJob::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        foreach (($rasidJobsQuery->chunk($chunk)) as $key => $rows) {
            $names[] = base_path('storage/app/public/') . $pdfGenerate->newFile()
                ->setHeader(trans('dashboard.rasid_job.rasid_job_archive'), $createdFrom)
                ->view('dashboard.exports.archive.rasid_job', $rows, $key, $chunk)
                ->storeOnLocal('rasidJobsArchive/pdfs/');
        }

        $file = GeneratePdf::mergePdfFiles($names, 'rasidJobsArchive/pdfs/rasid_jobs.pdf');

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
        Excel::store(new RasidJobsArchiveExport($request), 'rasidJobsArchive/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'rasidJobsArchive/excels/' . $fileName . '.xlsx');
        Loggable::addGlobalActivity(RasidJob::class, array_merge($request->query(), ['department_id' => Department::find($request->department_id)?->name]), ActivityLog::EXPORT, 'archive');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
