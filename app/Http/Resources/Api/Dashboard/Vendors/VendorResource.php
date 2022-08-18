<?php

namespace App\Http\Resources\Api\Dashboard\Vendors;

use App\Http\Resources\Api\Dashboard\GlobalTransResource;
use App\Http\Resources\Api\Dashboard\ImagesResource;
use App\Http\Resources\Api\Dashboard\PackageResource;
use App\Http\Resources\Api\Dashboard\VendorBranches\branchCooridnatesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    public function toArray($request)
    {
        $locales = [];
        if ($this->relationLoaded('translations')) {
            foreach (config('translatable.locales') as $locale) {
                $locales['translations'][$locale] = GlobalTransResource::make($this->translations->firstWhere('locale', $locale));
            }
        }
        return [
                'id' => $this->id,
                'branches_count' => $this->branches_count??0,
                'name' => $this->name,
                'type' => $this->type,
                'commercial_record' => $this->commercial_record,
                'tax_number' => $this->tax_number,
                'iban' => $this->iban,
                'is_active' => (bool)$this->is_active,
                'is_support_maak' => (bool)$this->is_support_maak,
                'email' => $this->email,
                'country_code' => substr($this->phone, 0, 3),
                'phone' => substr($this->phone, 3),
                'created_at' => $this->created_at_date,
                'logo'=> $this->logo,
                "images" => ImagesResource::collection($this->whenLoaded("images")),
                // 'activity' => ActivityLogResource::collection($this->whenLoaded('activity')),
                'package' => PackageResource::collection($this->whenLoaded('package')),
                'branch_coordinates' => branchCooridnatesResource::collection($this->whenLoaded('branches')),
                'actions' => $this->when($request->routeIs('vendors.index'), [
                    'show' => auth()->user()->hasPermissions('vendors.show'),
                    'create' => auth()->user()->hasPermissions('vendors.store'),
                    'update' => auth()->user()->hasPermissions('vendors.update'),
                    'vendor_branches' => auth()->user()->hasPermissions('vendor_branches.index'),
                    'force_delete' => auth()->user()->hasPermissions('vendors.destroy'),
                ])
            ] + $locales;
    }
}
