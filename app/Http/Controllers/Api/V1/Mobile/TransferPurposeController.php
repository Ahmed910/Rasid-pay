<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\TransferPurposeResource;
use App\Models\TransferPurpose\TransferPurpose;
use Illuminate\Http\Request;

class TransferPurposeController extends Controller
{
    public function index()
    {
        $transfer_purposes = TransferPurpose::where('is_active',true)->get();
        return TransferPurposeResource::collection($transfer_purposes)->additional([
            'status'=>true,
            'message'=>''
        ]);
    }
}
