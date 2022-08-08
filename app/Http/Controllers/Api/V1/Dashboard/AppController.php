<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\OurAppRequest;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OurAppRequest $request)
    {
        $app = OurApp::create($request->validated());
        return OurAppResource::make($app)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_add'),
        ]);
    }


       /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OurAppRequest $request,OurApp $our_app)
    {
        $our_app->update($request->validated());
        return OurAppResource::make($our_app)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_update'),
        ]);
    }
}
