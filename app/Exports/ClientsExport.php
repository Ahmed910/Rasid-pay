<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClientsExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {

        $clientsQuery = Client::whereHas("user.bankAccount", function ($q) {
            $q->whereIn("account_status", ["pending", "accepted", "reviewed"]);
        })->search($this->request)->get();
        return view('dashboard.client.export', [
            'clients' => $clientsQuery
        ]);
    }
}
