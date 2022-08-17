<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\OurAppExport;
use App\Models\OurApp\OurApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\OurAppRequest;
use App\Http\Resources\Dashboard\OurApp\OurAppCollection;
use App\Http\Resources\Dashboard\OurApp\OurAppResource;
use App\Models\ActivityLog;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
class OurAppController extends Controller
{
    public function index(Request $request)
    {
        $ourApps = OurApp::search($request)
            ->ListsTranslations('name')
            ->customDateFromTo($request)
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

    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $OurAppsQuery = OurApp::search($request)
        ->ListsTranslations('name')
        ->customDateFromTo($request)
        ->addSelect(
            'our_apps.*'
        )
        ->sortBy($request)
        ->get();

        Loggable::addGlobalActivity(OurApp::class, $request->query(), ActivityLog::EXPORT, 'index');
        if (!$request->has('created_from')) {
            $createdFrom = OurApp::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        foreach (($OurAppsQuery->chunk($chunk)) as $key => $rows) {
            $names[] = base_path('storage/app/public/') . $generatePdf->newFile()
                    ->setHeader(trans('dashboard.our_app.our_apps'),  $createdFrom)
                    ->view('dashboard.exports.our_app', $rows, $key, $chunk)
                    ->storeOnLocal('our_apps/pdfs/');
        }
        $file = GeneratePdf::mergePdfFiles($names, 'our_apps/pdfs/our_apps.pdf');

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
        Loggable::addGlobalActivity(OurApp::class, $request->query(), ActivityLog::EXPORT, 'index');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
