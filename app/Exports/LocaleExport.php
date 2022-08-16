<?php

namespace App\Exports;

use App\Models\Bank\Bank;
use App\Models\Faq\Faq;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use App\Models\Locale\Locale;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LocaleExport implements FromView, ShouldAutoSize, WithEvents
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
        $localeQuery = Locale::query()
        ->ListsTranslations('value')
        ->where('file', 'vue_static')
        ->addSelect('locale_id', 'key', 'value', 'locale', 'desc')
        ->search($this->request)
        ->sortBy($this->request)
        ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = Locale::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.locale', [
            'rows' => $localeQuery,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
