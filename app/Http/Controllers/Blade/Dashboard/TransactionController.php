<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blade\Dashboard\Transaction\TransactionCollection;
use App\Models\CardPackage\CardPackage;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }

        if ($request->ajax()) {
            $transactionsQuery = Transaction::search($request)
                ->CustomDateFromTo($request)
                ->with('card', 'client', 'citizen.citizen.enabledCard')
                ->sortBy($request);
            $transactionCount = $transactionsQuery->count();
            $transactions = $transactionsQuery->skip($request->start)
                ->take(($request->length == -1) ? $transactionCount : $request->length)
                ->get();

            return TransactionCollection::make($transactions)
                ->additional(['total_count' => $transactionCount]);
        }

        $clients = User::where('user_type', 'client')
            ->pluck('fullname', 'id')->toArray();

        $allCards = CardPackage::CARD_TYPES;
        foreach ($allCards as $key => $value) {
           $cards["$value"] = __("dashboard.citizens.card_type.$value");
        }

        return view('dashboard.transaction.index', compact('clients', 'cards'));
    }
}
