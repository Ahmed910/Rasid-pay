<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Dashboard\Banks\BankBranchResource;
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
        if ($this->relationLoaded('translations')) {
            foreach (config('translatable.locales') as $locale) {
                $locales['translations'][$locale] = GlobalTransResource::make($this->translations->firstWhere('locale', $locale));
            }
        }
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'transactions_count' => $this->transactions_count ?? 0,
            'actions' => $this->when($request->routeIs('banks.index') || $request->routeIs('banks.archive'), [
                'show' => auth()->user()->hasPermissions('banks.show'),
                $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                    'create' => auth()->user()->hasPermissions('banks.store'),
                    'update' => auth()->user()->hasPermissions('banks.update'),
                    'destroy' => auth()->user()->hasPermissions('banks.destroy'),
                ]),
                $this->mergeWhen($request->route()->getActionMethod() == 'archive', [
                    'restore' => auth()->user()->hasPermissions('banks.restore'),
                    'forceDelete' => auth()->user()->hasPermissions('banks.force_delete')
                ]),
            ])

        ] + $locales;
    }
}
