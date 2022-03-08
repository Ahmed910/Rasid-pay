<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use Illuminate\Http\Request;
use App\Models\RasidJob\RasidJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\RasidJob\{RasidJobResource, RasidJobCollection};
use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Http\Requests\V1\Dashboard\RasidJobRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;

class RasidJobController extends Controller
{

    public function index(Request $request)
    {
        $rasidJobs = RasidJob::search($request)->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

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
        $rasidJob  = RasidJob::withTrashed()->with('translations')->findOrFail($id);
        $activities  = $rasidJob->activity()->paginate((int)($request->per_page ?? 15));
        data_set($activities,'job',$rasidJob);
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
        $rasidJobs = RasidJob::onlyTrashed()->latest()
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

        $rasidJob->delete();

        return RasidJobResource::make($rasidJob)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_archive')
            ]);
    }

    public function forceDelete(ReasonRequest $request, $id)
    {

        $rasidJob = RasidJob::onlyTrashed()->findOrFail($id);
        $rasidJob->forceDelete();

        return RasidJobResource::make($rasidJob)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_delete')
            ]);
    }
}
