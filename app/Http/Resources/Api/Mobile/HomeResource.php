<?php

namespace App\Http\Resources\Api\Mobile;

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
            'wallet_number' => (string)$this->wallet_number,
            'main_balance' => number_format($this->main_balance, 2, '.', ''),
            'cash_back' => number_format($this->cash_back, 2, '.', ''),
            'rasid_pay_logo' => setting('rasidpay_logo'),
            'rasid_maak_logo' => setting('rasidmaak_logo'),
            'total_balance' => number_format(($this->main_balance + $this->cash_back), 2, '.', ''),
            'last_updated' => $this->last_updated_at?->format('g:i A'),
            'card_cover' => $app_mode,
        ];
    }
}
