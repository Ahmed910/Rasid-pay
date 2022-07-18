<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\OurApp\OurApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\OurAppRequest;
use App\Http\Resources\Dashboard\OurApp\OurAppResource;

class OurAppController extends Controller
{

    public function index(Request $request)
    {
        $ourApp = OurApp::search($request)
                    ->ListsTranslations('name')
                    ->CustomDateFromTo($request)
                    // ->addSelect('our_apps.created_at', 'our_apps.is_active','our_apps.order')
                    ->sortBy($request)
                    ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return OurAppResource::collection($ourApp)->additional([
            'status'=>true,
            'message'=>''
        ]);

    }


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
