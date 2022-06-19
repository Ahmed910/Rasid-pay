<?php

namespace App\Services;

class WalletBalance
{
    public static function calcWalletMainBackBalance($wallet, $total_amount)
    {
        $main_amount = 0;
        $cashback_amount = $total_amount;
        if ($total_amount > $wallet->cash_back) {
            $cashback_amount = $wallet->cash_back;
            $main_amount = $total_amount - $cashback_amount;
        }
        return (object) ['cashback_amount' => $cashback_amount, 'main_amount' => $main_amount];
    }








}
