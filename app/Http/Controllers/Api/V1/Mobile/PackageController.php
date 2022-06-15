<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Resources\Mobile\PackageResource;
use App\Models\Package\Package;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->paginate((int)($request->per_page ?? config("globals.per_page")));
        return PackageResource::collection($packages)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function show($id)
    {
        $package = Package::where('is_active', true)->findOrFail($id);
        return PackageResource::make($package)->additional([
            'status' => true,
            'message' => ''
        ]);
    }
}
