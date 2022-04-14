<?php

namespace App\Exports;

use App\Models\RasidJob\RasidJob;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JobsExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $jobsQuery = RasidJob::without('employee')->search($this->request)
            ->CustomDateFromTo($this->request)
            ->ListsTranslations('name')
            ->sortBy($this->request)
            ->addSelect('rasid_jobs.created_at', 'rasid_jobs.is_active', 'rasid_jobs.department_id', 'rasid_jobs.is_vacant')
            ->get();

        return view('dashboard.rasid_job.export', [
            'jobs' => $jobsQuery
        ]);
    }
}
