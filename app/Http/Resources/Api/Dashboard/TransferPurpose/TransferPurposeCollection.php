<?php

namespace App\Http\Resources\Api\Dashboard\TransferPurpose;

use App\Http\Resources\Api\Dashboard\ActivityLogResource;
use App\Models\TransferPurpose\TransferPurpose;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
        $transferPurpose  = TransferPurpose::with('translations')->findOrFail($request->route()->parameters['transfer_purpose']);
        return [
            'transfer_purpose' => TransferPurposeResource::make($transferPurpose),
            'activity' => ActivityLogResource::collection($this->collection)
        ];
    }
}
