<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\VendorExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\VendorRequest;
use App\Http\Resources\Api\Dashboard\Vendors\VendorCollection;
use App\Http\Resources\Api\Dashboard\Vendors\VendorResource;
use App\Models\ActivityLog;
use App\Models\Vendor\Vendor;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
use App\Http\Requests\Dashboard\ReasonRequest;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $vendors = Vendor::search($request)
            ->ListsTranslations('name')
            ->with('branches')
            ->addSelect('vendors.type', 'vendors.is_active', 'vendors.commercial_record', 'vendors.tax_number', 'vendors.iban','vendors.discount')
            ->withCount('branches')
            ->customDateFromTo($request)
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));
        // dd($vendors);
        return VendorResource::collection($vendors)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }


    public function store(VendorRequest $request, Vendor $vendor)
    {
        $vendor->fill($request->validated() + ["added_by" => auth()->id()])->save();
        $vendor->load("images");
        return VendorResource::make($vendor)->additional([
            "status" => true,
            "message" => __("dashboard.general.success_add")
        ]);
    }


    public function show(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $activities = [];
        if ((!$request->has('with_activity') || $request->with_activity) && $request->routeIs('*.show')) {
            $activities = $vendor->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ?? config("globals.per_page")));
        }
        return VendorCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }


    public function update(VendorRequest $request, $id)
    {
        $vendor = Vendor::with("translations")->findorfail($id);
        $vendor->fill($request->validated() + ["updated_at" => now()])->save();
        return VendorResource::make($vendor)
            ->additional([
                "status" => true,
                "message" => __("dashboard.general.success_update")
            ]);
    }


    public function destroy(ReasonRequest $request, $id)
    {
        $vendor = Vendor::findorfail($id);
        $vendor->delete();
        return VendorResource::make($vendor)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_delete')
            ]);
    }

    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $VendorsQuery = Vendor::search($request)
            ->ListsTranslations('name')
            ->with('branches')
            ->addSelect('vendors.type', 'vendors.is_active', 'vendors.commercial_record', 'vendors.tax_number', 'vendors.iban','vendor.discount')
            ->withCount('branches')
            ->customDateFromTo($request)
            ->sortBy($request)
            ->get();
        Loggable::addGlobalActivity(Vendor::class, $request->query(), ActivityLog::EXPORT, 'index');

        if (!$request->has('created_from')) {
            $createdFrom = Vendor::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        if (!$VendorsQuery->count()) {
            $file = GeneratePdf::createNewFile(
                trans('dashboard.vendor.vendors'),
                $createdFrom,'dashboard.exports.vendor',
                $VendorsQuery,0,$chunk,'vendors/pdfs/'
            );
            $file =  url(str_replace(base_path('storage/app/public/'), 'storage/', $file));
            return response()->json([
                'data'   => [
                    'file' => $file
                ],
                'status' => true,
                'message' => ''
            ]);
        }
        foreach (($VendorsQuery->chunk($chunk)) as $key => $rows) {
            $names[] = GeneratePdf::createNewFile(
                trans('dashboard.vendor.vendors'),$createdFrom,
                'dashboard.exports.vendor',
                $rows,$key,$chunk,'vendors/pdfs/'
            );
        }

        $file = GeneratePdf::mergePdfFiles($names, 'vendors/pdfs/vendors.pdf');

        return response()->json([
            'data' => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }

    public function exportExcel(Request $request)
    {
        $fileName = uniqid() . time();
        Excel::store(new VendorExport($request), 'Vendors/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'Vendors/excels/' . $fileName . '.xlsx');
        Loggable::addGlobalActivity(Vendor::class, $request->query(), ActivityLog::EXPORT, 'index');

        return response()->json([
            'data' => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
