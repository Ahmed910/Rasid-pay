<?php

namespace App\Http\Middleware;

use Closure;

class TransactionMiddleware
{
    public function handle($request, Closure $next)
    {
        $maxTransactionPerDay = (float)setting('rasidpay_usertransaction_maxvalue_perday');

        $maxTransactionPerMonth = (float)setting('rasidpay_usertransaction_maxvalue_permonth');
        $dailyTransactions = auth()->user()->citizenTransactions()
            ->where('trans_type', '!=', 'charge')
            ->whereDate('created_at', date('Y-m-d'))
            ->sum('amount');
        if ($dailyTransactions >= $maxTransactionPerDay) {
            return response()->json(['status' => false, 'message' => trans('mobile.transaction.transaction_details.reach_max_transaction_day',['max_day_amount' => $maxTransactionPerDay]), 'data' => null], 422);
        }
        $monthlyTransactions = auth()->user()->citizenTransactions()
            ->where('trans_type', '!=', 'charge')
            ->whereDate('created_at', date('Y-m'))
            ->sum('amount');

        if ($monthlyTransactions >= $maxTransactionPerMonth) {

            return response()->json(['status' => false, 'message' => trans('mobile.transaction.transaction_details.reach_max_transaction_month',['max_month_amount' => $maxTransactionPerMonth]), 'data' => null], 422);
        }
        return $next($request);
    }
}
