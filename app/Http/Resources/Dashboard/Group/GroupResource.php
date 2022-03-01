<?php

namespace App\Http\Resources\Dashboard\Group;

use App\Http\Resources\Dashboard\{GlobalTransResource , SimpleUserResource};
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
            'admins_count' => $this->admins->count(),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
             $this->mergeWhen(!in_array($request->route()->getActionMethod(),['index','archive']), $locales),
            'created_at' => $this->created_at,
            'actions' => [
                'update' => auth()->user()->hasPermissions('groups.update'),
                'show' => auth()->user()->hasPermissions('groups.show')
            ]
        ] + $locales;
    }
}
