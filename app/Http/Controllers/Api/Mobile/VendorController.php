<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Mobile\VendorDetailsResource;
use App\Http\Resources\Api\Mobile\VendorResource;
use App\Models\Vendor\Vendor;
use Illuminate\Http\Request;


class VendorController extends Controller
{
     public function index(Request $request)
     {

        $vendors = Vendor::active()->when($request->name,function ($query) use($request){
                 $query->whereTranslationLike('name',"%{$request->name}%",'ar')
                ->orWhereTranslationLike('name',"%{$request->name}%",'en');
        })
        ->join('vendor_packages','vendor_packages.vendor_id','vendors.id')
        ->select('vendors.*',\DB::raw("GREATEST(vendor_packages.basic_discount,vendor_packages.golden_discount,vendor_packages.platinum_discount) as max_discount"))
        // ->select('vendors.*',\DB::raw("GREATEST(vendor_packages.basic_discount,vendor_packages.golden_discount,vendor_packages.platinum_discount) as max_discount"))

        ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return VendorResource::collection($vendors)->additional(['status' => true,'message'=>'']);
     }


     public function show(Request $request,$id)
     {
         $vendor = Vendor::with(['branches','package'])->when($request->lat && $request->lng,
         fn($query) =>
            $query->whereHas('branches',fn($query) =>
                $query->nearest($request->lat,$request->lng)
            )
         )->with(['branches'=>fn($query) => $query->active()->latest()])
         ->findOrFail($id);

         return VendorDetailsResource::make($vendor)->additional([
            'status' => true,
            'message' => '',
         ]);
     }
}
