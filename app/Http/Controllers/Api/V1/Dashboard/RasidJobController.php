<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use Illuminate\Http\Request;
use App\Models\RasidJob\RasidJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\RasidJobResource;
use App\Http\Requests\V1\Dashboard\RasidJobRequest;
use Symfony\Component\HttpFoundation\Response;

class RasidJobController extends Controller
{

    public function index(Request $request)
    {
        $rasidJobs = RasidJob::search($request)->latest()->paginate((int)($request->perPage ?? 10));

        return RasidJobResource::collection($rasidJobs)
            ->additional([
                'message' => '',
                'status' => true
            ]);
    }



    public function store(RasidJobRequest $request, RasidJob $rasidJob)
    {

        $rasidJob->fill($request->validated())->save();

        return RasidJobResource::make($rasidJob)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_add')
            ]);
    }


    public function show($id)
    {
        $rasidJob  = RasidJob::withTrashed()->findOrFail($id);

        return RasidJobResource::make($rasidJob->load('translations'))
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RasidJobRequest $request, RasidJob $rasidJob)
    {
        $rasidJob->fill($request->validated())->save();

        return RasidJobResource::make($rasidJob)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_update')
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function archive(Request $request)
    {
        $rasidJobs = RasidJob::onlyTrashed()->latest()->paginate((int)($request->perPage ?? 10));

        return RasidJobResource::collection($rasidJobs)
            ->additional([
                'message' => 'success',
                'status' => true
            ]);
    }




    public function restore($id)
    {

        $rasidJob = RasidJob::onlyTrashed()->findOrFail($id);

        $rasidJob->restore();

        return RasidJobResource::make($rasidJob)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.restore')

            ]);
    }


    public function destroy(RasidJob $rasidJob)
    {

        $rasidJob->delete();

        return CityResource::make($rasidJob)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_archive')
            ]);
    }

    public function forceDelete($id)
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
