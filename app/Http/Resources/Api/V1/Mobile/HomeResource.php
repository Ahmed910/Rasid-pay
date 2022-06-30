<?php

namespace App\Http\Resources\Api\V1\Mobile;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $app_mode = setting('home_card_cover_day') ?? asset('dashboardAssets/images/app_images/home_card_day.png');
        if ($request->night_mode) {
            $app_mode = setting('home_card_cover_night') ?? asset('dashboardAssets/images/app_images/home_card_night.png');
        }
        return [
            'wallet_number'  => (string)$this->wallet_number,
            'main_balance'   => (string)$this->main_balance,
            'cash_back'      => (string)$this->cash_back,
            'total_balance'  => (string)($this->main_balance + $this->cash_back),
            'last_updated'   => $this->last_updated_at?->diffForHumans(),
            'card_cover'     => $app_mode,
        ];
    }
}
