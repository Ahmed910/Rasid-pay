<?php

namespace App\Http\Resources\Api\Dashboard\StaticPages;

use App\Http\Resources\Api\Dashboard\ActivityLogResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Dashboard\GlobalTransResource;
use App\Http\Resources\Api\Dashboard\SimpleUserResource;
use App\Http\Resources\Api\Dashboard\ImagesResource;

class StaticPageResource extends JsonResource
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
            'description'      => $this->description,
            'is_active'        => (bool)$this->is_active,
            "images"           => ImagesResource::collection($this->whenLoaded("images")),
            'created_at'       => $this->created_at_date,
            'added_by_id'      => $this->whenLoaded('addedBy', SimpleUserResource::make($this->addedBy)),
            'show_in_app'      =>(bool)$this->show_in_app,
            'show_in_website'  =>(bool)$this->show_in_website,
            'has_link'         =>(bool)$this->link()->exists(),
            'actions'          => $this->when($request->routeIs('static_pages.index') || $request->routeIs('static_pages.archive'), [
                'show' => auth()->user()->hasPermissions('static_pages.show'),
                $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                    'create'  => auth()->user()->hasPermissions('static_pages.store'),
                    'update'  => auth()->user()->hasPermissions('static_pages.update'),
                    'destroy' => auth()->user()->hasPermissions('static_pages.destroy'),
                ]),

            ])
        ] + $locales;

    }
}
