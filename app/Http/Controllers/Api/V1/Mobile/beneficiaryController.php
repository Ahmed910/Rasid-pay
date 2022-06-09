<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\BeneficiaryRequest;
use App\Http\Resources\Mobile\BeneficiaryResource;
use App\Models\Beneficiary;

class beneficiaryController extends Controller
{
    public function store(BeneficiaryRequest $request)
    {
        $user = auth('sanctum')->user();
        $beneficiary =  $user->benficiaryTransfer()->create($request->validated());

        return BeneficiaryResource::make($beneficiary)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function show(Beneficiary $beneficiary)
    {
        $beneficiary->load([
            'country',
            'user',
            'recieveOption'
        ]);

        return BeneficiaryResource::make($beneficiary)->additional([
            'status' => true,
            'message' => ''
        ]);
    }
}
