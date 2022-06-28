<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class TranslationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "key" => $this->key,
            "value" => $this->value,
            "desc" => $this->desc,
        ];
    }
}
