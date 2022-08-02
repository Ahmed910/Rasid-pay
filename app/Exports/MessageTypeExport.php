<?php

namespace App\Exports;

use App\Models\Locale\Locale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\MessageType\MessageType;

class MessageTypeExport implements FromView, ShouldAutoSize ,WithEvents
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
        $messageTypes = MessageType::ListsTranslations('name')
            ->addSelect('created_at', 'is_active')
            ->withCount('admins')
            ->search($this->request)
            ->customDateFromTo($this->request)
            ->sortBy($this->request)
            ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = Locale::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.message_type', [
            'messageTypes' => $messageTypes,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
