<?php

namespace App\Exports;

use App\Models\RasidJob\RasidJob;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RasidJobsArchiveExport implements FromView, ShouldAutoSize, WithEvents
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
        $rasid_jobs_archiveQuery = RasidJob::onlyTrashed()
            ->without('employee')
            ->search($this->request)
            ->customDateFromTo($this->request, 'deleted_at', 'deleted_from', 'deleted_to')
            ->ListsTranslations('name')
            ->sortBy($this->request)
            ->addSelect('rasid_jobs.department_id', 'rasid_jobs.deleted_at', 'rasid_jobs.is_active')
            ->get();
        if (!$this->request->has('created_from')) {
            $createdFrom = RasidJob::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.archive.rasid_job', [
            'jobs_archive' => $rasid_jobs_archiveQuery,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
