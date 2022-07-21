<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\OurAppResource;
use App\Models\OurApp\OurApp;
use Illuminate\Http\Request;

class OurAppController extends Controller
{
    public function index(Request  $request)
    {
        $ourApps = OurApp::search($request)
            ->withTranslation()
            ->sortBy($request)->paginate((int)($request->per_page ?? config("globals.per_page")));

        return OurAppResource::collection($ourApps)->additional([
            'status' => true,
            'message' => ''
        ]);
    }
}
