<?php

namespace App\Http\Resources\Dashboard\VendorBranches;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\GlobalTransResource;

class VendorBranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        return [
           'id'=>$this->id,
           'name'          =>$this->vendor?->name,
           'branch_name' =>$this->name,
           'vendor_number'=>$this->vendor?->is_support_maak,
           'type'          =>$this->vendor?->type
        ];
    }
}
