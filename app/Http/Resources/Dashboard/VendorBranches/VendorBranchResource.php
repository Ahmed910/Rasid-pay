<?php

namespace App\Http\Resources\Dashboard\VendorBranches;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\ActivityLogResource;
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
           'type'          =>$this->vendor?->type,
           'address_details'=>$this->address_details,
           'phone'          =>$this->phone,
           'is_active'          =>$this->is_active,
           'activity' => ActivityLogResource::collection($this->whenLoaded('activity')),
           'actions' => $this->when($request->routeIs('vendor_branches.index'), [
               'show' => auth()->user()->hasPermissions('vendor_branches.show'),
               $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                   'destroy' => auth()->user()->hasPermissions('vendor_branches.destroy'),
               ])
           ])
        ];
    }
}
