<?php

namespace App\Http\Resources\Dashboard\Group;

use App\Http\Resources\Dashboard\{ActivityLogResource, GlobalTransResource , SimpleUserResource};
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'name' => $this->name,
            'is_active' => (bool)$this->is_active,
            'added_by' => SimpleUserResource::make($this->addedBy),
            'admins_count' => $this->user_count,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'groups' => self::collection($this->whenLoaded('groups')),
            'created_at' => $this->created_at,
            'is_selected' => auth()->user()->groups()->where('groups.id',$this->id)->exists(),
            'actions' => $this->when($request->routeIs('groups.index'), [
                'update' => auth()->user()->hasPermissions('groups.update'),
                'show' => auth()->user()->hasPermissions('groups.show')
            ])
        ] + $locales;
    }
}
