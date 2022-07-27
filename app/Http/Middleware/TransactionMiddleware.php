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
        ->where('trans_type','!=','charge')
        ->whereDate('created_at', '>=', now()->subDay())->sum('amount');
        if ($dailyTransactions >= $maxTransactionPerDay) {
            return response()->json(['error' => 'mobile.transactions.transaction_details.reach_max_transaction_day'], 422);
        }
        $monthlyTransactions = auth()->user()->citizenTransactions()
        ->where('trans_type','!=','charge')
        ->whereDate('created_at', '>=', now()->subMonth())->sum('amount');
        if ($monthlyTransactions >= $maxTransactionPerMonth) {
            return response()->json(['error' => 'mobile.transactions.transaction_details.reach_max_transaction_month'], 422);
        }
        return $next($request);
    }
}
