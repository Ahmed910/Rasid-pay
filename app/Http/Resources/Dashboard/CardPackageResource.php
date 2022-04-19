<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CardPackageResource extends JsonResource
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
        return [
                "id" => $this->id,
                "is_active" => $this->is_active,
                "ordering" => $this->ordering,
                "price" => $this->price,
                "offer" => $this->offer,
                "color" => $this->color,
                "available_for_promo" => $this->available_for_promo,
                "cash_back" => $this->cash_back,
                "promo_cash_back" => $this->promo_cash_back,
                "discount_promo_code" => $this->discount_promo_code,
                "images"    => ImagesResource::collection($this->whenLoaded("images")),

            ] + $locales;
    }
}
