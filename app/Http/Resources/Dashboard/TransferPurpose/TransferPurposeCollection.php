<?php

namespace App\Http\Resources\Dashboard\TransferPurpose;

use App\Http\Resources\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Models\TransferPurpose\TransferPurpose;

class TransferPurposeCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $transferPurpose  = TransferPurpose::with('translations')->findOrFail($request->route()->parameters['rasid_job']);
        return [
            'transfer_purpose' => TransferPurposeResource::make($transferPurpose),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
