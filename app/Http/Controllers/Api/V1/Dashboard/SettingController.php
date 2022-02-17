<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\SettingResource;
use App\Http\Requests\V1\Dashboard\SettingRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $settings = Setting::select('key','value')->latest()->paginate((int)($request->perPage ?? 10));

        return SettingResource::collection($settings)
            ->additional([
                'message' => 'success',
                'status' => true
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingRequest $request)
    {
        foreach ($request->all() as $key => $value) {
            Setting::updateOrCreate(['key' =>$key],['value'=> $value]);
        }

        $settings = Setting::select('key','value')->latest()->paginate((int)($request->perPage ?? 10));

        return SettingResource::collection($settings)
        ->additional([
            'message' => 'success',
            'status' => true
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
