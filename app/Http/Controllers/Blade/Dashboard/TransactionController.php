<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blade\Dashboard\Transaction\TransactionCollection;
use App\Models\CardPackage\CardPackage;
use App\Models\Client;
use App\Models\Department\Department;
use App\Models\Employee;
use App\Models\RasidJob\RasidJob;
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
                ->with('card', 'client', 'citizen')
                ->sortBy($request);
            $transactionCount = $transactionsQuery->count();
            $transactions = $transactionsQuery->skip($request->start)
                ->take(($request->length == -1) ? $transactionCount : $request->length)
                ->get();

            return TransactionCollection::make($transactions)
                ->additional(['total_count' => $transactionCount]);
        }

        $clients = User::where('user_type','client')
            ->pluck('fullname', 'id')->toArray();

        $cards = CardPackage::where('is_active',1)->select('id')->ListsTranslations('name')->pluck('name','id')->toArray();
        return view('dashboard.transaction.index',compact('clients','cards'));
    }


}
