<?php

namespace App\Http\Resources\Dashboard\Currency;

use App\Http\Resources\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\GlobalTransResource;
use App\Http\Resources\Dashboard\SimpleUserResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $locales = [];
        if ($this->relationLoaded('translations')) {
            foreach (config('translatable.locales') as $locale) {
                $locales['translations'][$locale] = GlobalTransResource::make($this->translations->firstWhere('locale',$locale));
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value,
            'created_at'=>$this->created_at,
            'added_by_id' => SimpleUserResource::make($this->whenloaded('addedBy')),
            'activity'  => ActivityLogResource::collection($this->whenLoaded('activity')),
            'actions' => $this->when(in_array($request->route()->getActionMethod(),['index','archive']), [
                'show' => auth()->user()->hasPermissions('currencies.show'),
                $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                    'create' => auth()->user()->hasPermissions('currencies.store'),
                    'update' => auth()->user()->hasPermissions('currencies.update'),
                    'destroy' => auth()->user()->hasPermissions('currencies.destroy'),
                ]),
                $this->mergeWhen($request->route()->getActionMethod() == 'archive', [
                    'restore' => auth()->user()->hasPermissions('currencies.restore'),
                    'forceDelete' => auth()->user()->hasPermissions('currencies.force_delete')
                ]),
            ])
        ] + $locales;

    }
}
