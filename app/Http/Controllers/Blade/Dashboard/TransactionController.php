<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blade\Dashboard\Transaction\TransactionCollection;
use App\Models\Package\Package;
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
                ->with('citizenPackage', 'client', 'citizen.citizen.enabledPackage','transactionable')
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

        $packages = Package::select("id")->ListsTranslations("name")->pluck('name', 'id')->toArray();

        return view('dashboard.transaction.index', compact('clients', 'packages'));
    }
}
