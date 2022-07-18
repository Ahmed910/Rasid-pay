<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\ClientPackageRequest;
use App\Http\Resources\Dashboard\PackageResource;
use App\Http\Resources\Dashboard\MainPackageResource;
use App\Http\Resources\Dashboard\SimpleUserResource;
use App\Http\Resources\Dashboard\Vendors\VendorResource;
use App\Models\ClientPackageView;
use App\Models\Package\Package;
use App\Models\User;
use App\Models\Vendor\Vendor;
use App\Models\VendorPackage;
use Illuminate\Http\Request;

class VendorPackageController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }

        $packages = VendorPackage::query()
            ->with('vendor')
            ->search($request)
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return PackageResource::collection($packages)->additional([
            'status' => true,
            'message' => ""
        ]);
    }

    public function getClients(Request $request)
    {
        $fileds = $this->validate($request, [
            "has_card" => "required|boolean"
        ]);

        $clients = $request->has_card
            ? Vendor::with('translations')->has('packages')->get()
            : Vendor::with('translations')->doesntHave('packages')->get();

        return VendorResource::collection($clients)->additional([
            'status' => true,
            'message' => ""
        ]);
    }

    public function store(ClientPackageRequest $request)
    {
        $client = Vendor::findOrFail($request->vendor_id);
        $client->packages()->create($request->validated());

        return PackageResource::make($client)->additional([
            'status' => true,
            'message' => __('dashboard.package.discount_success_add')
        ]);
    }

    public function show($id)
    {
        $vendor = VendorPackage::with('vendor')->findOrFail($id);

        return PackageResource::make($vendor)->additional([
            'status' => true,
            'message' => __('')
        ]);
    }

    public function update(ClientPackageRequest $request)
    {
        $client = Vendor::findOrFail($request->vendor_id);
        $client->packages()->create($request->validated());

        return PackageResource::make($client)->additional([
            'status' => true,
            'message' => trans("dashboard.package.discount_success_update")
        ]);
    }


    public function getMainPackages()
    {
        $packages = Package::where('is_active', 1)->get();
        return MainPackageResource::collection($packages)->additional([
            'status' => true,
            'message' => ""
        ]);
    }
}
