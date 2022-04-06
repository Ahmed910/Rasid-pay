<?php

namespace App\Exports;

use App\Models\RasidJob\RasidJob;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
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

        return view('dashboard.job.export', [
            'jobs' => $jobsQuery
        ]);
    }


}
