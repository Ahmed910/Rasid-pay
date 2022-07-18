<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\OurApp\OurApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\OurAppRequest;
use App\Http\Resources\Dashboard\OurApp\OurAppCollection;
use App\Http\Resources\Dashboard\OurApp\OurAppResource;

class OurAppController extends Controller
{

    public function index(Request $request)
    {
        $ourApps = OurApp::search($request)
            ->ListsTranslations('name')
            ->CustomDateFromTo($request)
            ->addSelect(
                'our_apps.created_at',
                'our_apps.is_active',
                'our_apps.order',
                'our_apps.android_link',
                'our_apps.ios_link'
            )
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));


        return OurAppResource::collection($ourApps)->additional([
            'status' => true,
            'message' => ''
        ]);
    }


    public function show(Request $request, $id)
    {
        $ourApp  = OurApp::findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $ourApp->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return OurAppCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
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
    public function update(OurAppRequest $request,  $our_app)
    {
        $ourApp =OurApp::findOrFail($our_app);
        $ourApp->update($request->validated());
        return OurAppResource::make($ourApp)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_update'),
        ]);
    }

    public function destroy($id){
        $ourApp = OurApp::findOrFail($id);
        $ourApp->delete();
        return OurAppResource::make($ourApp)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_delete")
            ]);
    }
}
