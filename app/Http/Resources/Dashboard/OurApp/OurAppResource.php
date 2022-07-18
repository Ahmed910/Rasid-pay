<?php

namespace App\Http\Resources\Dashboard\OurApp;

use App\Http\Resources\Dashboard\ImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\SimpleUserResource;
use App\Http\Resources\Dashboard\GlobalTransResource;

class OurAppResource extends JsonResource
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
            'id'               => $this->id,
            'name'             => $this->name,
            'order'            => $this->order,
            'is_active'        => (bool)$this->is_active,
            'android_link'     => $this->android_link,
            'ios_link'         => $this->ios_link,
            'image'            => $this->image,
            'created_at'       => $this->created_at,
            'added_by_id'      => $this->whenLoaded('addedBy', SimpleUserResource::make($this->addedBy)),
            'actions'          => $this->when($request->routeIs('our_apps.index') || $request->routeIs('our_apps.archive'), [
                'show' => auth()->user()->hasPermissions('our_apps.show'),
                $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                    'create'  => auth()->user()->hasPermissions('our_apps.store'),
                    'update'  => auth()->user()->hasPermissions('our_apps.update'),
                    'destroy' => auth()->user()->hasPermissions('our_apps.destroy'),
                ]),

            ])
        ] + $locales;

    }
}
