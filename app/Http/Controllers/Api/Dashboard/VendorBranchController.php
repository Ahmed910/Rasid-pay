<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\VendorBranchExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\VendorBranchRequest;
use App\Http\Resources\Api\Dashboard\VendorBranches\VendorBranchCollection;
use App\Http\Resources\Api\Dashboard\VendorBranches\VendorBranchResource;
use App\Models\ActivityLog;
use App\Models\Vendor\Vendor;
use App\Models\VendorBranches\VendorBranch;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
use App\Http\Requests\Dashboard\ReasonRequest;

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

    public function getVendors()
    {
        $vendors = Vendor::select('id')->listsTranslations('name')->latest()->get();
        return response()->json(['data' => $vendors, 'status' => true, 'message' => '']);
    }


    public function store(VendorBranchRequest $request)
    {
        $vendor_branch = VendorBranch::create($request->validated());
        return VendorBranchResource::make($vendor_branch)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_add'),
        ]);
    }


    public function show(Request $request, $id)
    {
        $vendorBranch = VendorBranch::findOrFail($id);
        $activities = [];
        if ((!$request->has('with_activity') || $request->with_activity) && $request->routeIs('*.show')) {
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


    public function update(VendorBranchRequest $request, VendorBranch $vendor_branch)
    {
        $vendor_branch->update($request->validated() + ['updated_at' => now()]);
        return VendorBranchResource::make($vendor_branch)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_update'),
        ]);
    }

    public function destroy(ReasonRequest $request,VendorBranch $vendorBranch)
    {
        $vendorBranch->delete();
        return VendorBranchResource::make($vendorBranch)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_delete')
            ]);
    }

    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $VendorBranchesQuery = VendorBranch::query()
            ->ListsTranslations('name')
            ->search($request)
            ->sortBy($request)
            ->addSelect('vendor_branches.*')
            ->get();

        Loggable::addGlobalActivity(VendorBranch::class, $request->query(), ActivityLog::EXPORT, 'index');

        if (!$request->has('created_from')) {
            $createdFrom = VendorBranch::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        foreach (($VendorBranchesQuery->chunk($chunk)) as $key => $rows) {
            $names[] = base_path('storage/app/public/') . $generatePdf->newFile()
                    ->setHeader(trans('dashboard.vendor_branch.vendors_branches'), $createdFrom)
                    ->view('dashboard.exports.vendor_branch', $rows, $key, $chunk)
                    ->storeOnLocal('vendor_branches/pdfs/');
        }

        $file = GeneratePdf::mergePdfFiles($names, 'vendor_branches/pdfs/vendors_branches.pdf');

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
        Loggable::addGlobalActivity(VendorBranch::class, $request->query(), ActivityLog::EXPORT, 'index');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
