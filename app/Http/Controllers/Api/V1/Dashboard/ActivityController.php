<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\ActivityLogsExport;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department\Department;
use App\Http\Resources\Dashboard\ActivityLogResource;
use App\Http\Resources\Dashboard\SimpleEmployeeResource;
use App\Http\Resources\Dashboard\OnlyResource;
use App\Jobs\GeneratePdfFile;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Traits\Loggable;
class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $activatyLogs = ActivityLog::search($request)
            ->where('user_type', 'admin')
            ->customDateFromTo($request)
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return ActivityLogResource::collection($activatyLogs)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }


    public function show(ActivityLog $activityLog)
    {

        return ActivityLogResource::make($activityLog)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);
    }

    public function getDepartments()
    {
        $departments = Department::without("images", 'addedBy')
            ->select("id")
            ->ListsTranslations("name")
            ->get();

        return OnlyResource::collection($departments)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    public function getEmployees()
    {
        $employees = User::select('id', 'fullname')->whereIn('user_type', ['admin', 'superadmin'])
            ->when(request('department_list'), function ($employees) {
                $employees->whereHas('employee', function ($employees) {
                    if (is_array(request('department_list'))) {
                        $employees->whereIn('department_id', request('department_list'));
                    }
                });
            })->get();

        return OnlyResource::collection($employees)
            ->additional([
                'status' => true,
                'message' => "",
            ]);
    }

    public function getMainPrograms()
    {
        $mainPrograms = collect(AppServiceProvider::MORPH_MAP)
            ->put('UserCitizen', 'UserCitizen')
            ->except([
                'Region',
                'Chat',
                'Device',
                'Message',
                'City',
                'Country',
                'Currency',
                'Card',
                'Admin',
                'Setting',
                'Citizen',
                'Transfer',
                'BankTransfer',
                'Slide',
                'Package',
                'RecieveOption',
                'TransferRelation'
            ])->transform(function ($class, $model) {
                $data['name'] = $model;
                $data['trans'] = trans("dashboard." . Str::snake($model) . "." . str_plural(Str::snake($model)));

                return $data;
            })->unique()->values();

        return OnlyResource::collection($mainPrograms);
    }

    public function getSubPrograms($main_progs = null)
    {
        $subPrograms = collect([]);

        if ($main_progs) {
            $subPrograms = collect(trans('dashboard.' . mb_strtolower(Str::snake($main_progs)) . '.sub_progs'))->transform(function ($trans, $key) {
                $data['name'] = $key;
                $data['trans'] = $trans;

                return $data;
            })->values();
        } else {
            $mainPrograms = array_keys(AppServiceProvider::MORPH_MAP);

            foreach ($mainPrograms as $main_progs) {
                $subPrograms[] = collect(trans('dashboard.' . mb_strtolower(Str::snake($main_progs)) . '.sub_progs'))->transform(function ($trans, $key) {
                    $data['name'] = $key;
                    $data['trans'] = $trans;

                    return $data;
                })->values();
            }

            $subPrograms = $subPrograms->flatten(1);
        }

        return response()->json([
            'data' => $subPrograms,
            'status' => true,
            'message' => ''
        ]);
    }

    public function getEvents()
    {
        $data['events'] = ActivityLog::EVENTS;
        data_set($data['events'], 0, 'all');

        return OnlyResource::make($data)->additional([
            'status' => true,
            'message' => "",
        ]);
    }

    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $activatyLogsQuery = ActivityLog::select(
            'activity_logs.id',
            'activity_logs.user_id',
            'activity_logs.auditable_type',
            'activity_logs.auditable_id',
            'activity_logs.sub_program',
            'activity_logs.action_type',
            'activity_logs.ip_address',
            'activity_logs.created_at'
        )->search($request)
            ->sortBy($request)
            ->customDateFromTo($request)
            ->cursor();

            Loggable::addGlobalActivity(ActivityLog::class, array_merge($request->query(), ['department_list' => Department::find($request->department_list)?->name,
            'employee_list' => User::find($request->employee_list)?->fullname]), ActivityLog::EXPORT, 'index');

        if (!$request->has('created_from')) {
            $createdFrom = ActivityLog::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        foreach (($activatyLogsQuery->chunk($chunk)) as $key => $rows) {
            $names[] = base_path('storage/app/public/') . $generatePdf->newFile()
                ->setHeader(trans('dashboard.activity_log.activity_logs'), $createdFrom)
                ->view('dashboard.exports.activity_log', $rows, $key, $chunk)
                ->storeOnLocal('activityLogs/pdfs/');
        }

        $file = GeneratePdf::mergePdfFiles($names, 'activityLogs/pdfs/activity_log.pdf');

        return response()->json([
            'data' => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }




    public function exportExcel(Request $request)
    {
        $fileName = uniqid() . time();
        Excel::store(new ActivityLogsExport($request), 'activity_logs/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'activity_logs/excels/' . $fileName . '.xlsx');
        Loggable::addGlobalActivity(ActivityLog::class, array_merge($request->query(), ['department_list' => Department::find($request->department_list)?->name,
        'employee_list' => User::find($request->employee_list)?->fullname]), ActivityLog::EXPORT, 'index');

        return response()->json([
            'data' => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
