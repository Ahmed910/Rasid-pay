<?php

namespace App\Http\Resources\Dashboard\Faq;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dashboard\GlobalTransResource;
use App\Http\Resources\Dashboard\SimpleUserResource;


class FaqResource extends JsonResource
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
            'question'         => $this->question,
            'answer'           => $this->answer,
            'order'            => (int) $this->order,
            'is_active'        => (bool) $this->is_active,
            'created_at'       => $this->created_at,
            'added_by_id'      => $this->whenLoaded('addedBy', SimpleUserResource::make($this->addedBy)),
            'actions'          => $this->when($request->routeIs('faqs.index') || $request->routeIs('faqs.archive'), [
                'show' => auth()->user()->hasPermissions('faqs.show'),
                $this->mergeWhen($request->route()->getActionMethod() == 'index', [
                    'create'  => auth()->user()->hasPermissions('faqs.store'),
                    'update'  => auth()->user()->hasPermissions('faqs.update'),
                    'destroy' => auth()->user()->hasPermissions('faqs.destroy'),
                ]),

            ])
        ] + $locales;

    }
}