<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use App\Models\StaticPage\StaticPage;
use App\Models\TransferPurpose\TransferPurpose;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransferPurposeExport implements FromView, ShouldAutoSize, WithEvents
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
        $transferPursposes =  TransferPurpose::search($this->request)
        ->sortBy($this->request)
        ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = TransferPurpose::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.transfer_purpose', [
            'transfer_purposes' => $transferPursposes,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
