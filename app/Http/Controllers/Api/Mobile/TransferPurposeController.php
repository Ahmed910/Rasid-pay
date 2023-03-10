<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Mobile\TransferPurposeResource;
use App\Models\TransferPurpose\TransferPurpose;
use Illuminate\Http\Request;

class TransferPurposeController extends Controller
{
    public function index()
    {
        $transfer_purposes = TransferPurpose::where('is_active',true)
        ->orderBy('is_default_value','desc')
        ->orderBy('is_another','asc')
        ->get();
        return TransferPurposeResource::collection($transfer_purposes)->additional([
            'status'=>true,
            'message'=>''
        ]);
    }
}
