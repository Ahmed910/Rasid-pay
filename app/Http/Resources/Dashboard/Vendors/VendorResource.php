<?php

namespace App\Http\Resources\Dashboard\Vendors;

use App\Http\Resources\Dashboard\ImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Http\Resources\Dashboard\GlobalTransResource;
use App\Http\Resources\Dashboard\PackageResource;

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
                'created_at' => $this->created_at,
                'logo'=> $this->logo,
                "images" => ImagesResource::collection($this->whenLoaded("images")),
                'activity' => ActivityLogResource::collection($this->whenLoaded('activity')),
                'packages' => PackageResource::collection($this->whenLoaded('packages')),
                'actions' => $this->when($request->routeIs('Vendors.index'), [
                    'show' => auth()->user()->hasPermissions('Vendors.show'),
                    $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                        'create' => auth()->user()->hasPermissions('Vendors.store'),
                        'update' => auth()->user()->hasPermissions('Vendors.update'),
                        'destroy' => auth()->user()->hasPermissions('Vendors.destroy'),
                    ])
                ])
            ] + $locales;
    }
}
