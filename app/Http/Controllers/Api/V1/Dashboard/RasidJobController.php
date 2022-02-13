<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RasidJob\RasidJob;
use App\Http\Resources\Dashboard\RasidJobResource;
use Illuminate\Http\Request;

class RasidJobController extends Controller
{

    public function index(Request $request)
    {
        $rasidJobs = RasidJob::latest()->paginate((int)($request->perPage ?? 10));

        return RasidJobResource::collection($rasidJobs)
            ->additional([
                'message' => '',
                'status' => true
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
