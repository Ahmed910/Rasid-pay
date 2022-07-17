<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\VendorRequest;
use App\Http\Resources\Dashboard\Vendors\VendorCollection;
use App\Http\Resources\Dashboard\Vendors\VendorResource;
use App\Models\Vendor\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $vendors = Vendor::search($request)
                            ->ListsTranslations('name')
                            ->addSelect('vendors.type', 'vendors.is_active', 'vendors.commercial_record', 'vendors.tax_number','vendors.iban')
                            ->withCount('branches')
                            ->CustomDateFromTo($request)
                            ->sortBy($request)
                            ->paginate((int)($request->per_page ?? config("globals.per_page")));
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
            "message" => trans("dashboard.success_add")
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
        $vendor = Vendor::with('images')->findOrFail($id);
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
        $vendor = Vendor::findorfail($id);
        $vendor->fill($request->validated() + ["updated_at" => now()])->save();
        $vendor->load("translations");
        return VendorResource::make($vendor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
