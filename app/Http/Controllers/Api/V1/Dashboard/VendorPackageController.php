<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\VendorPackageExport;
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
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;

class VendorPackageController extends Controller
{
    public function index(Request $request)
    {
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

    public function getVendors(Request $request)
    {
        $fileds = $this->validate($request, [
            "has_card" => "required|boolean"
        ]);

        $clients = $request->has_card
            ? Vendor::with('translations')->has('package')->get()
            : Vendor::with('translations')->doesntHave('package')->get();

        return VendorResource::collection($clients)->additional([
            'status' => true,
            'message' => ""
        ]);
    }

    public function store(ClientPackageRequest $request)
    {
        $client = Vendor::findOrFail($request->vendor_id);
        $client->package()->create($request->validated());

        return PackageResource::make($client->package)->additional([
            'status' => true,
            'message' => __('dashboard.package.discount_success_add')
        ]);
    }

    public function show($id)
    {
        $package = VendorPackage::with('vendor')->findOrFail($id);

        return PackageResource::make($package)->additional([
            'status' => true,
            'message' => __('')
        ]);
    }

    public function update(ClientPackageRequest $request, VendorPackage $vendorPackage)
    {
        $vendorPackage->update($request->validated());

        return PackageResource::make($vendorPackage)->additional([
            'status' => true,
            'message' => trans("dashboard.package.discount_success_update")
        ]);
    }

    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $vendorPackagesQuery =  VendorPackage::query()
        ->with('vendor')
        ->search($request)
        ->sortBy($request)
        ->get();


        if (!$request->has('created_from')) {
            $createdFrom = VendorPackage::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        foreach (($vendorPackagesQuery->chunk($chunk)) as $key => $rows) {
            $names[] = base_path('storage/app/public/') . $generatePdf->newFile()
                    ->setHeader(trans('dashboard.vendor_package.vendor_packages'), $createdFrom)
                    ->view('dashboard.exports.vendor_package', $rows, $key, $chunk)
                    ->storeOnLocal('vendor_packages/pdfs/');
        }

        $file = GeneratePdf::mergePdfFiles($names, 'vendor_packages/pdfs/vendor_packages.pdf');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }

    public function exportExcel(Request $request)
    {
        $fileName = uniqid() . time();
        Excel::store(new VendorPackageExport($request), 'VendorPackage/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'VendorPackage/excels/' . $fileName . '.xlsx');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
