<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $locales = [];
        if ($this->relationLoaded('translations')) {
            foreach (config('translatable.locales') as $locale) {
                $locales['translations'][$locale] = GlobalTransResource::make($this->translations->firstWhere('locale', $locale));
            }
        }

        return ['id' => $this->id,
                'type' => $this->type,
                'commercial_record' => $this->commercial_record,
                'tax_number' => $this->tax_number,
                'is_support_maak' => $this->is_support_maak,
                'is_active' => $this->is_active,
                "iban" => $this->iban,
                "email" => $this->email,
                "phone" => $this->phone,
                "images" => ImagesResource::collection($this->whenLoaded("images")),
            ] + $locales;
    }
}
