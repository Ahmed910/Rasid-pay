<?php

namespace App\Http\Resources\Dashboard\Banks;

use App\Http\Resources\Dashboard\GlobalTransResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BankForEditResource extends JsonResource
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
            'created_at' => $this->created_at,
            'transactions_count' => $this->transactions_count ?? 0,
            'branches' => $this->whenLoaded('branches', BankBranchResource::collection($this->branches))
        ] + $locales;
    }
}
