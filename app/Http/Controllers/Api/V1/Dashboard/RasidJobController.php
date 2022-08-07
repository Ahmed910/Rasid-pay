<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\JobsExport;
use App\Exports\RasidJobsArchiveExport;
use Illuminate\Http\Request;
use App\Models\RasidJob\RasidJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\RasidJob\{RasidJobResource, RasidJobCollection};
use App\Http\Requests\V1\Dashboard\RasidJobRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;



class RasidJobController extends Controller
{

    public function index(Request $request)
    {
        $rasidJobs = RasidJob::search($request)
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
        if (!$request->has('with_activity') || $request->with_activity) {
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
            ->search($request)
            ->ListsTranslations('name')
            ->customDateFromTo($request, 'deleted_at', 'deleted_from', 'deleted_to')
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
                ->orWhereRelation('employee','user_id',$request->admin_id))
                ->without(['images', 'addedBy', 'translations', 'department', 'employee'])->get(),
            'status' => true,
            'message' =>  '',
        ]);
    }

    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $jobsQuery = RasidJob::without('employee')->search($request)
            ->customDateFromTo($request)
            ->ListsTranslations('name')
            ->sortBy($request)
            ->addSelect('rasid_jobs.created_at', 'rasid_jobs.is_active', 'rasid_jobs.department_id', 'rasid_jobs.is_vacant')
            ->get();


        if (!$request->has('created_from')) {
            $createdFrom = RasidJob::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.job',
                [
                    'jobs' => $jobsQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('rasidJobs/pdfs/');
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
        Excel::store(new JobsExport($request), 'rasidJobs/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'rasidJobs/excels/' . $fileName . '.xlsx');

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
            ->search($request)
            ->ListsTranslations('name')
            ->customDateFromTo($request, 'deleted_at', 'deleted_from', 'deleted_to')
            ->with('department')
            ->select('rasid_jobs.*')
            ->sortBy($request, 'archive')
            ->get();

        if (!$request->has('created_from')) {
            $createdFrom = RasidJob::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.archive.rasid_job',
                [
                    'jobs_archive' => $rasidJobsQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('rasidJobsArchive/pdfs/');
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
        Excel::store(new RasidJobsArchiveExport($request), 'rasidJobsArchive/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'rasidJobsArchive/excels/' . $fileName . '.xlsx');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
