<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\VendorBranchExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\VendorBranchRequest;
use App\Http\Resources\Dashboard\VendorBranches\VendorBranchCollection;
use App\Http\Resources\Dashboard\VendorBranches\VendorBranchResource;
use App\Models\Vendor\Vendor;
use App\Models\VendorBranches\VendorBranch;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;

class VendorBranchController extends Controller
{
    public function index(Request $request)
    {
        $vendorBranches = VendorBranch::query()
                                    ->ListsTranslations('name')
                                    ->search($request)
                                    ->sortBy($request)
                                    ->addSelect('vendor_branches.*')
                                    ->paginate((int)($request->per_page ?? config("globals.per_page")));
        return VendorBranchResource::collection($vendorBranches)->additional([
                                        'status' => true,
                                        'message' => ""
                                    ]);
    }

    /**
     * pluck vendors in independent service.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVendors()
    {
        $vendors = Vendor::select('id')->listsTranslations('name')->latest()->get();
        return response()->json(['data' => $vendors, 'status' => true, 'message' => '']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorBranchRequest $request)
    {
        $vendor_branch = VendorBranch::create($request->validated());
        return VendorBranchResource::make($vendor_branch)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_add'),
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
        $vendorBranch = VendorBranch::findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities = $vendorBranch->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ?? config("globals.per_page")));
        }
        return VendorBranchCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorBranchRequest $request, VendorBranch $vendor_branch)
    {
        $vendor_branch->update($request->validated());
        return VendorBranchResource::make($vendor_branch)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_update'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorBranch $vendorBranch)
    {
        $vendorBranch->delete();
        return VendorBranchResource::make($vendorBranch)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_delete')
            ]);
    }

    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $VendorBranchsQuery = VendorBranch::query()
        ->ListsTranslations('name')
        ->search($request)
        ->sortBy($request)
        ->addSelect('vendor_branches.*')
        ->get();


        if (!$request->has('created_from')) {
            $createdFrom = VendorBranch::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.vendor_branch',
                [
                    'vendorbranches' => $VendorBranchsQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('VendorBranches/pdfs/');
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
        Excel::store(new VendorBranchExport($request), 'VendorBranches/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'VendorBranches/excels/' . $fileName . '.xlsx');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
