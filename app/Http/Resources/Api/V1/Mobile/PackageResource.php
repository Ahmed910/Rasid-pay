<?php

namespace App\Http\Resources\Api\V1\Mobile;

use App\Models\CitizenPackage;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $current_package = auth()->user()->citizen()->with('enabledPackage')->first();
        // desc for development purpose only
        $default_desc = 'وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف.';
        return [
            'name' => $this->resource,
            'price' => (string)setting('rasidpay_cards_' . $this->resource . '_price') ?? "",
            'description' => setting('rasidpay_cards_' . $this->resource . '_desc') ?? $default_desc,
            'color' => (string)setting('rasidpay_cards_' . $this->resource . '_color') ?? "",
            'image' => asset(setting('rasidpay_cards_' . $this->resource . '_bgimg')) ?? "",
            'is_current' => $current_package->enabledPackage->package_type == $this->resource,
            'end_at' => $current_package->enabledPackage->package_type == $this->resource ? $current_package->enabledPackage?->end_at : null,
            'start_at' => $current_package->enabledPackage->package_type == $this->resource ? $current_package->enabledPackage?->start_at : null,
            'has_promo_codes' => $this->resource == CitizenPackage::PLATINUM,
        ];
    }
}
