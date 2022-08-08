<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => @$this->data['title'] ?? 'Test',
            'body' => @$this->data['body'] ?? 'إذا كان لديك بالفعل مجال عمل مخصص (Niche) وكنت على استعداد للبدء في تجارتك الإلكترونية، فقنوات توفر آلاف المنتجات التي تناسب تجارتك والتي يمكنك استيرادها بضغطة زر.',
            'notify_type' => @$this->data['notify_type'] ?? 'management',
            'created_at' => $this->created_at_date?->diffForHumans(),
            'read_at' => optional($this->read_at)->format("Y-m-d H:i"),
            'logo' => setting('erp_logo')
        ];

    }
}
