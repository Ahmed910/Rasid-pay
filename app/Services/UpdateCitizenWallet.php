<?php

namespace App\Services;

use App\Models\CitizenPackage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UpdateCitizenWallet
{
    public static function updateCitizenWallet($price)
    {
        $citizen_wallet = auth()->user()->citizenWallet;
        $remaining_balance = $price - $citizen_wallet->cash_back;
        if ($remaining_balance <= 0)
            $citizen_wallet->update([
                'cash_back' => $citizen_wallet->cash_back - $price,
            ]);
        else
            $citizen_wallet->update([
                'cash_back' => 0,
                'main_balance' => $citizen_wallet->main_balance - $remaining_balance,
            ]);
    }
}
