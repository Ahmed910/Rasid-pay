<?php

namespace App\Http\Resources\Api\V1\Mobile\Beneficiary;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Api\V1\Mobile\WalletResource;

class BeneficiaryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'wallet' => WalletResource::make(auth()->user()->citizenWallet),
            'beneficiaries' => BeneficiaryResource::collection($this->collection)
        ];
    }
}
