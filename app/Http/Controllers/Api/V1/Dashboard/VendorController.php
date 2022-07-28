<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\VendorExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\VendorRequest;
use App\Http\Resources\Dashboard\Vendors\VendorCollection;
use App\Http\Resources\Dashboard\Vendors\VendorResource;
use App\Models\Vendor\Vendor;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $vendors = Vendor::search($request)
            ->ListsTranslations('name')
            ->with('branches')
            ->addSelect('vendors.type', 'vendors.is_active', 'vendors.commercial_record', 'vendors.tax_number', 'vendors.iban')
            ->withCount('branches')
            ->CustomDateFromTo($request)
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));
            // dd($vendors);
        return VendorResource::collection($vendors)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request, Vendor $vendor)
    {
        $vendor->fill($request->validated() + ["added_by" => auth()->id()])->save();
        $vendor->load("images");
        return VendorResource::make($vendor)->additional([
            "status" => true,
            "message" => __("dashboard.general.success_add")
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
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

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::findorfail($id);
        $vendor->delete();
        return VendorResource::make($vendor)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_delete')
            ]);
    }

    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $VendorsQuery = Vendor::search($request)
        ->ListsTranslations('name')
        ->with('branches')
        ->addSelect('vendors.type', 'vendors.is_active', 'vendors.commercial_record', 'vendors.tax_number', 'vendors.iban')
        ->withCount('branches')
        ->CustomDateFromTo($request)
        ->sortBy($request)
        ->get();


        if (!$request->has('created_from')) {
            $createdFrom = Vendor::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.vendor',
                [
                    'vendors' => $VendorsQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('Vendors/pdfs/');
        $file  = url('/storage/' . $mpdfPath);

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
        Excel::store(new VendorExport($request), 'Vendors/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'Vendors/excels/' . $fileName . '.xlsx');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
