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
                'admin_names' => $this->admins()->pluck('fullname')->join(','),
                'admins_count' => $this->admins_count,
                'created_at' => $this->created_at,
                'activity' => ActivityLogResource::collection($this->whenLoaded('activity')),
                'actions' => $this->when($request->routeIs('message_types.index') || $request->routeIs('message_types.archive'), [
                    'show' => auth()->user()->hasPermissions('message_types.show'),
                    $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                        'create' => auth()->user()->hasPermissions('message_types.store'),
                        'update' => auth()->user()->hasPermissions('message_types.update'),
                        'destroy' => auth()->user()->hasPermissions('message_types.destroy'),
                    ]),

                ])
            ] + $locales;
    }
}
