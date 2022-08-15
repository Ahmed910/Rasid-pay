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
        set_time_limit(-1);
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
        $names = [];
        foreach (($activatyLogsQuery->chunk(200)) as $key => $activity_logs) {
            $mpdf = new \Mpdf\Mpdf([
                'fontDir' => [
                    public_path() . '/dashboardAssets/fonts',
                ],
                'fontdata' => [
                    'cairo' => [
                        'R' => 'Cairo-Regular.ttf',
                        'I' => 'Cairo-Regular.ttf',
                        'useOTL' => 0xFF,
                        'useKashida' => 75,
                    ]
                ],
                'default_font' => 'cairo',
                'debug' => true,
                'allow_output_buffering' => true,
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_top' => 60,     // 30mm not pixel
                'margin_footer' => 10,     // 10mm
                'orientation' => 'L'
            ]);

            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->simpleTables = true;
            $mpdf->packTableData = true;
            $mpdf->SetHTMLHeader(view('dashboard.exports.header', ['topic' => 'المتابعة', 'count' => 5]));
            if (!Route::is('summary_file')) {
                $mpdf->SetWatermarkImage(public_path('dashboardAssets/images/brand/fintech.png'), -3, 'F');
                $mpdf->showWatermarkImage = true;
                $mpdf->SetDirectionality(LaravelLocalization::getCurrentLocaleDirection());
            }
            $basePath = base_path('storage/app/public/');
            $folder = 'activityLogs/pdfs/';
            $filename = $basePath . $folder . uniqid() . time() . ".pdf";
            $names[] = $filename;
            $mpdfPath = view('dashboard.exports.activity_log', compact('activity_logs', 'key'));
            $mpdf->WriteHTML($mpdfPath);
            $mpdf->Output($filename, \Mpdf\Output\Destination::FILE);
        }

        $final_path = base_path('storage/app/public/activityLogs/pdfs/activity_log.pdf');
        $this->mergePDFFiles($names, $final_path);
        $file = url($final_path);
        return response()->json([
            'data' => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }

    function mergePDFFiles(array $filenames, $outFile)
    {
        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => [
                public_path() . '/dashboardAssets/fonts',
            ],
            'fontdata' => [
                'cairo' => [
                    'R' => 'Cairo-Regular.ttf',
                    'I' => 'Cairo-Regular.ttf',
                    'useOTL' => 0xFF,
                    'useKashida' => 75,
                ]
            ],
            'default_font' => 'cairo',
            'pagenumPrefix' => __('dashboard.general.page_number'),
            'pagenumSuffix' => ' | ',
            'nbpgPrefix' => ' ',
            'nbpgSuffix' => ' ',
            'mode' => 'utf-8',
            'orientation' => 'L'
        ]);
        $mpdf->SetFooter('{PAGENO}{nbpg}');
        if ($filenames) {
            $filesTotal = sizeof($filenames);
            $fileNumber = 1;
            if (!file_exists($outFile)) {
                $handle = fopen($outFile, 'w');
                fclose($handle);
            }

            foreach ($filenames as $fileName) {
                if (file_exists($fileName)) {
                    $pagesInFile = $mpdf->setSourceFile($fileName);
                    for ($i = 1; $i <= $pagesInFile; $i++) {
                        $tplId = $mpdf->ImportPage($i); // in mPdf v8 should be 'importPage($i)'
                        $mpdf->UseTemplate($tplId);
                        if (($fileNumber < $filesTotal) || ($i != $pagesInFile)) {
                            $mpdf->WriteHTML('<pagebreak />');
                        }
                    }
                }
                $fileNumber++;
            }
            $mpdf->Output($outFile, \Mpdf\Output\Destination::FILE);
            File::delete($filenames);
        }
    }


    public function exportExcel(Request $request)
    {
        $fileName = uniqid() . time();
        Excel::store(new ActivityLogsExport($request), 'activity_logs/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'activity_logs/excels/' . $fileName . '.xlsx');

        return response()->json([
            'data' => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
