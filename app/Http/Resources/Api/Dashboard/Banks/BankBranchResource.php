<?php

namespace App\Http\Resources\Api\Dashboard\Banks;

use App\Http\Resources\Api\Dashboard\BankResource;
use App\Http\Resources\Api\Dashboard\GlobalTransResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BankBranchResource extends JsonResource
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
            'id'   => $this->id,
            'name' => $this->name,
            'type' => trans("dashboard.bank.types.{$this->type}"),
            'type_name' => $this->type,
            'code' => $this->code,
            'site' => $this->site,
            'transfer_amount' => (float) number_format((float)$this->transfer_amount, 2),
            'commercial_record' => $this->commercial_record,
            'tax_number' => $this->tax_number,
            'service_customer' => $this->service_customer,
            'is_active' => (bool) $this->is_active,
            'bank' => $this->whenLoaded('bank', BankResource::make($this->bank)),
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
