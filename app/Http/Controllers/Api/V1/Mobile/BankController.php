<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\BankResource;
use App\Models\Bank\Bank;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::where('is_active',true)->get();
        return BankResource::collection($banks)->additional([
            'status'=>true,
            'message'=>''
        ]);
    }
}
