<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\CitizenExport;
use App\Models\User;
use App\Models\Citizen;
use Illuminate\Http\Request;
use App\Models\CitizenPackage;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Dashboard\Citizen\CitizenResource;
use App\Http\Resources\Api\Dashboard\Citizen\CitizenCollection;
use App\Http\Requests\Dashboard\UpdateCitizenStatusRequest;
use App\Models\ActivityLog;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
class CitizenController extends Controller
{

    public function index(Request $request)
    {
        $citizen = Citizen::with(['user', "enabledPackage"])
            ->whereHas('user', fn ($q) => $q->where('register_status', 'completed'))
            ->customDateFromTo($request)
            ->search($request)
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return CitizenResource::collection($citizen)->additional([
            'status' => true,
            'message' => ""
        ]);
    }

    public function show(Request $request, $id)
    {
        $citizen = Citizen::where('user_id', $id)->with("user", "enabledPackage")->whereHas('user', fn ($q) => $q->where('register_status', 'completed'))->firstOrFail();
        $activities = [];
        if ((!$request->has('with_activity') || $request->with_activity) && $request->routeIs('*.show')) {
            $activities  = $citizen->user->activity()
                ->where('action_type','<>',ActivityLog::UPDATE)
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return CitizenCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }


    public function update(UpdateCitizenStatusRequest $request, $id)
    {
        $citizen = User::where('user_type', "citizen")->where('register_status', 'completed')->findOrFail($id);
        $citizen->update($request->validated());
        return CitizenResource::make($citizen->citizen->load('user'))->additional([
            'status' => true,
            'message' => trans("dashboard.general.success_update")
        ]);
    }
    public function enabledPackages()
    {
        $enabledPackages = transform_array_api(CitizenPackage::PACKAGE_TYPES, 'dashboard.package_types');

        return response()->json([
            'data' => $enabledPackages,
            'status' => true,
            'message' =>  '',
        ]);
    }


    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $CitizensQuery =  Citizen::with(['user', "enabledPackage"])
            ->whereHas('user', fn ($q) => $q->where('register_status', 'completed'))
            ->customDateFromTo($request)
            ->search($request)
            ->sortBy($request)
            ->get();

        Loggable::addGlobalActivity(Citizen::class, $request->query(), ActivityLog::EXPORT, 'index');

        if (!$request->has('created_from')) {
            $createdFrom = Citizen::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        if (!$CitizensQuery->count()) {
            $file = GeneratePdf::createNewFile(
                trans('dashboard.citizen.citizens'),
                $createdFrom,'dashboard.exports.citizen',
                $CitizensQuery,0,$chunk,'citizens/pdfs/'
            );
            $file =  url(str_replace(base_path('storage/app/public/'), 'storage/', $file));
            return response()->json([
                'data'   => [
                    'file' => $file
                ],
                'status' => true,
                'message' => ''
            ]);
        }
        foreach (($CitizensQuery->chunk($chunk)) as $key => $rows) {
            $names[] = GeneratePdf::createNewFile(
                trans('dashboard.citizen.citizens'),$createdFrom,
                'dashboard.exports.citizen',
                $rows,$key,$chunk,'citizens/pdfs/'
            );
        }

        $file = GeneratePdf::mergePdfFiles($names, 'citizens/pdfs/citizens.pdf');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }

    public function exportExcel(Request $request)
    {
        $fileName = uniqid() . time();
        Excel::store(new CitizenExport($request), 'Citizens/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'Citizens/excels/' . $fileName . '.xlsx');
        Loggable::addGlobalActivity(Citizen::class, $request->query(), ActivityLog::EXPORT, 'index');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
