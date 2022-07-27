<?php

namespace App\Http\Middleware;

use Closure;

class TransactionMiddleware
{
    public function handle($request, Closure $next)
    {
        $maxTransactionPerDay = setting('rasidpay_usertransaction_maxvalue_perday');
        $maxTransactionPerMonth = setting('rasidpay_usertransaction_maxvalue_permonth');
        $dailyTransactions = auth()->user()->citizenTransactions()
            ->where('trans_type', '!=', 'charge')
            ->whereDate('created_at', date('Y-m-d'))
            ->sum('amount');
        if ($dailyTransactions >= $maxTransactionPerDay) {
            return response()->json(['status' => false, 'message' => trans('mobile.transaction.transaction_details.reach_max_transaction_day'), 'data' => null], 422);
        }
        $monthlyTransactions = auth()->user()->citizenTransactions()
            ->where('trans_type', '!=', 'charge')
            ->whereBetween('created_at', [now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d')])
            ->sum('amount');
        if ($monthlyTransactions >= $maxTransactionPerMonth) {
            return response()->json(['status' => false, 'message' => trans('mobile.transaction.transaction_details.reach_max_transaction_month'), 'data' => null], 422);
        }
        return $next($request);
    }
}
