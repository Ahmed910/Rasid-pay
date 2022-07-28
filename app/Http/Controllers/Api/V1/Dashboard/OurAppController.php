<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\OurAppExport;
use App\Models\OurApp\OurApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\OurAppRequest;
use App\Http\Resources\Dashboard\OurApp\OurAppCollection;
use App\Http\Resources\Dashboard\OurApp\OurAppResource;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
class OurAppController extends Controller
{
    public function index(Request $request)
    {
        $ourApps = OurApp::search($request)
            ->ListsTranslations('name')
            ->CustomDateFromTo($request)
            ->addSelect(
                'our_apps.*'
            )
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));


        return OurAppResource::collection($ourApps)->additional([
            'status' => true,
            'message' => ''
        ]);
    }


    public function show(Request $request, $id)
    {
        $ourApp  = OurApp::findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $ourApp->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return OurAppCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);
    }


    public function store(OurAppRequest $request)
    {
        $app = OurApp::create($request->validated());

        return OurAppResource::make($app)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_add'),
        ]);
    }


    public function update(OurAppRequest $request,  $our_app)
    {
        $ourApp = OurApp::findOrFail($our_app);
        $ourApp->update($request->validated() + ['updated_at' => now()]);

        return OurAppResource::make($ourApp)->additional([
            'status' => true,
            'message' => trans('dashboard.general.success_update'),
        ]);
    }

    public function destroy($id)
    {
        $ourApp = OurApp::findOrFail($id);
        $ourApp->delete();

        return OurAppResource::make($ourApp)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_delete")
            ]);
    }

    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $OurAppsQuery = OurApp::search($request)
        ->ListsTranslations('name')
        ->CustomDateFromTo($request)
        ->addSelect(
            'our_apps.*'
        )
        ->sortBy($request)
        ->get();


        if (!$request->has('created_from')) {
            $createdFrom = OurApp::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.our_app',
                [
                    'ourApps' => $OurAppsQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('ourApps/pdfs/');
        $file  = url('/storage/' . $mpdfPath);

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
        Excel::store(new OurAppExport($request), 'ourApps/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'ourApps/excels/' . $fileName . '.xlsx');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
