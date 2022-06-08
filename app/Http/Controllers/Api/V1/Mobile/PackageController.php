<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Resources\Mobile\PackageResource;
use App\Models\Package\Package;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{

    public function getPackages()
    {
        $packages = Package::where('is_active', true)->get();
        return PackageResource::collection($packages)->additional(
            ['status' => true,
                'message' => '']);
    }
}
