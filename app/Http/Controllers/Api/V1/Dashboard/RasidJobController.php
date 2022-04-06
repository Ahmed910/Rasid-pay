<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use Illuminate\Http\Request;
use App\Models\RasidJob\RasidJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\RasidJob\{RasidJobResource, RasidJobCollection};
use App\Http\Requests\V1\Dashboard\RasidJobRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;

class RasidJobController extends Controller
{

    public function index(Request $request)
    {
        $rasidJobs = RasidJob::search($request)
            ->ListsTranslations('name')
            ->CustomDateFromTo($request)
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
                ->paginate((int)($request->per_page ?? 15));
        }

        return RasidJobCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);
    }


    public function update(RasidJobRequest $request, RasidJob $rasidJob)
    {
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
            ->CustomDateFromTo($request)
            ->sortBy($request)
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


    public function getVacantJobs($id)
    {
        return response()->json([
            'data' => RasidJob::where(['department_id' => $id, 'is_vacant' => true])->select('id')->ListsTranslations('name')
                ->without(['images', 'addedBy', 'translations', 'department', 'employee'])->get(),
            'status' => true,
            'message' =>  '',
        ]);
    }
}
