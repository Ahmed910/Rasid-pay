<?php

use App\Models\ActivityLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActionTypeTransToActivityLogsTable extends Migration
{
    public function up()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->string('action_type_ar')->after('action_type');
        });
        $this->transActionTypes();
    }

    public function down()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn('action_type_ar');
        });
    }

    public function transActionTypes()
    {
        $allActivityLogs = ActivityLog::select('id', 'action_type')->get();
        $allActivityLogs->map(function ($item) {
            $item->where('id', $item->id)->update(['action_type_ar'=> trans('dashboard.activity_log.action_types.' . $item->action_type)]);
        });
    }
}
