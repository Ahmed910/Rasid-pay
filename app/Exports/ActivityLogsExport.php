<?php

namespace App\Exports;

use App\Models\ActivityLog;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ActivityLogsExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {

        $activatyLogsQuery = ActivityLog::select('activity_logs.id','activity_logs.user_id','activity_logs.auditable_type','activity_logs.auditable_id','activity_logs.sub_program','activity_logs.action_type','activity_logs.ip_address','activity_logs.created_at')->search($this->request)
        ->CustomDateFromTo($this->request)
        ->get();

        return view('dashboard.exports.activity_log', [
            'activity_logs' => $activatyLogsQuery
        ]);
    }
}
