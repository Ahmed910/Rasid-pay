<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClientsExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(app()->getLocale() == 'ar' ? true : false);
            },
        ];
    }
    public function view(): View
    {

        $clientsQuery = Client::whereHas("user.bankAccount", function ($q) {
            $q->whereIn("account_status", ["pending", "accepted", "reviewed"]);
        })->search($this->request)
        ->sortBy($this->request)
        ->get();
        return view('dashboard.client.export', [
            'clients' => $clientsQuery
        ]);
    }
}
