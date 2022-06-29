<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class TranslationResource extends JsonResource
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
            "id" => $this->locale_id,
            "key" => $this->key,
            "value" => $this->value,
            "locale" => $this->locale,
            "desc" => $this->desc,
        ] + $locales;
    }
}
