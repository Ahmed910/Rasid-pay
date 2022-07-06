<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageTypeResource extends JsonResource
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
                'message_type' => $this->name,
                'admins' => SimpleUserResource::collection($this->whenLoaded('admins')),
                'admins_count' => $this->admins_count,
                'actions' => $this->when($request->routeIs('massage_types.index') || $request->routeIs('massage_types.archive'), [
                    'show' => auth()->user()->hasPermissions('massage_types.show'),
                    $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                        'create' => auth()->user()->hasPermissions('massage_types.store'),
                        'update' => auth()->user()->hasPermissions('massage_types.update'),
                        'destroy' => auth()->user()->hasPermissions('massage_types.destroy'),
                    ]),

                ])
            ] + $locales;
    }
}
