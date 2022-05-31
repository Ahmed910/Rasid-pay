<?php

namespace App\Exports;

use App\Models\RasidJob\RasidJob;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RasidJobsArchiveExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $rasid_jobs_archiveQuery = RasidJob::onlyTrashed()
        ->without('employee')
        ->search($this->request)
        ->searchDeletedAtFromTo($this->request)
        ->ListsTranslations('name')
        ->addSelect('rasid_jobs.department_id', 'rasid_jobs.deleted_at', 'rasid_jobs.is_active')
        ->get();

        return view('dashboard.exports.archive.rasid_job', [
            'jobs_archive' => $rasid_jobs_archiveQuery
        ]);
    }
}
