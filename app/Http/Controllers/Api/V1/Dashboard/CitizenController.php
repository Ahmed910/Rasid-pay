<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\CitizenExport;
use App\Models\User;
use App\Models\Citizen;
use Illuminate\Http\Request;
use App\Models\CitizenPackage;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\Citizen\CitizenResource;
use App\Http\Resources\Dashboard\Citizen\CitizenCollection;
use App\Http\Requests\V1\Dashboard\UpdateCitizenStatusRequest;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;

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
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $citizen->user->activity()
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


        if (!$request->has('created_from')) {
            $createdFrom = Citizen::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        foreach (($CitizensQuery->chunk($chunk)) as $key => $rows) {
            $names[] = base_path('storage/app/public/') . $generatePdf->newFile()
                ->setHeader(trans('dashboard.citizen.citizens'), 5, $createdFrom)
                ->view('dashboard.exports.citizen', $rows, $key, $chunk)
                ->storeOnLocal('citizens/pdfs/');
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

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
