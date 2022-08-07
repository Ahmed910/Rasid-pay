<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use App\Models\StaticPage\StaticPage;
use App\Models\TransferPurpose\TransferPurpose;
use App\Models\Vendor\Vendor;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VendorExport implements FromView, ShouldAutoSize, WithEvents
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
        $vendors =   Vendor::search($this->request)
        ->ListsTranslations('name')
        ->with('branches')
        ->addSelect('vendors.type', 'vendors.is_active', 'vendors.commercial_record', 'vendors.tax_number', 'vendors.iban')
        ->withCount('branches')
        ->customDateFromTo($this->request)
        ->sortBy($this->request)
        ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = Vendor::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.vendor', [
            'vendors' => $vendors,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
