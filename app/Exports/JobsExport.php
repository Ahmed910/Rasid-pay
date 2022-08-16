<?php

namespace App\Exports;

use App\Models\RasidJob\RasidJob;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JobsExport implements FromView, ShouldAutoSize, WithEvents
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
        $jobsQuery = RasidJob::without('employee')->search($this->request)
            ->customDateFromTo($this->request)
            ->ListsTranslations('name')
            ->sortBy($this->request)
            ->addSelect('rasid_jobs.created_at', 'rasid_jobs.is_active', 'rasid_jobs.department_id', 'rasid_jobs.is_vacant')
            ->get();
            if (!$this->request->has('created_from')) {
                $createdFrom = RasidJob::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
            }

        return view('dashboard.exports.job', [
            'rows' => $jobsQuery,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,

        ]);
    }
}
