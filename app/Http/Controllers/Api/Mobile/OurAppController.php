<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Mobile\OurAppResource;
use App\Models\OurApp\OurApp;

class OurAppController extends Controller
{
    public function index()
    {
        $ourApps = OurApp::where('is_active', true)
            ->select('our_apps.*')
            ->withTranslation()
            ->orderBy('order')
            ->get();

        return OurAppResource::collection($ourApps)->additional([
            'status' => true,
            'message' => ''
        ]);
    }
}
