<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\VendorDetailsResource;
use App\Http\Resources\Api\V1\Mobile\VendorResource;
use App\Models\Vendor\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
     public function index(Request $request){

        $vendors = Vendor::when($request->name,function ($query) use($request){
            $query->whereTranslationLike('name',"%{$request->name}%",'ar')
                ->orWhereTranslationLike('name',"%{$request->name}%",'en')
            ;
        })->get();

        return VendorResource::collection($vendors)->additional(['status' => true,'message'=>'']);
     }
     public function show(Request $request,$id){
         $vendor = Vendor::with(['branches','package'])->when($request->lat && $request->lng,
         fn($query) =>
            $query->whereHas('branches',fn($query) =>
                $query->nearest($request->lat,$request->lng)
            )
         )->whereHas('branches',fn($query) => $query->latest())
         ->findOrFail($id);
         return VendorDetailsResource::make($vendor)->additional([
            'status' => true,
            'message' => '',
         ]);

     }
}
