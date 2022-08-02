<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $transactionsQuery = Transaction::search($this->request)
            ->customDateFromTo($this->request)
            ->sortBy($this->request)
            ->with('citizenPackage', 'toUser', 'fromUser.citizen.enabledPackage', 'transactionable')
            ->paginate((int)($this->request->per_page ?? config("globals.per_page")));

        if (!$this->request->has('created_from')) {
            $createdFrom = Transaction::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.transactions', [
            'transactions' => $transactionsQuery,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
