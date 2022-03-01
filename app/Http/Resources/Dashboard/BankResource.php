<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
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
        if ($this->relationLoaded('translations') && !in_array($request->route()->getActionMethod(),['index','archive'])) {
            foreach (config('translatable.locales') as $locale) {
                $locales['translations'][$locale] = GlobalTransResource::make($this->translations->firstWhere('locale',$locale));
            }
        }
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'actions' => [
                'show' => auth()->user()->hasPermissions('banks.show'),
                'create' => auth()->user()->hasPermissions('banks.store'),
                'update' => auth()->user()->hasPermissions('banks.update'),
                'archive' => auth()->user()->hasPermissions('banks.archive'),
                'destroy' => auth()->user()->hasPermissions('banks.destroy'),
                'restore' => auth()->user()->hasPermissions('banks.restore'),
                'forceDelete' => auth()->user()->hasPermissions('banks.force_delete'),
            ]

        ] + $locales;
    }
}
