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
