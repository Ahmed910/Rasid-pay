<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\LinkExport;
use App\Models\Link;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Dashboard\LinkResource;
use App\Http\Requests\V1\Dashboard\LinkRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
class LinkController extends Controller
{
    public function index(Request $request)
    {
        $links = Link::latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
        return LinkResource::collection($links)->additional(['status' => true, 'message' => '']);
    }

    public function update(LinkRequest $request, Link $link)
    {
        $link->update($request->validated());
        return LinkResource::make($link)
            ->additional([
                'message' => trans('dashboard.general.success_update'),
                'status' => true
            ]);
    }

    public function exportPDF(Request $request, GeneratePdf $generatePdf)
    {
        $LinksQuery = Link::latest()->get();

        if (!$request->has('created_from')) {
            $createdFrom = Link::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        Loggable::addGlobalActivity(Link::class, $request->query(), ActivityLog::EXPORT, 'index');

        $chunk = 200;
        $names = [];
        foreach (($LinksQuery->chunk($chunk)) as $key => $rows) {
            $names[] = base_path('storage/app/public/') . $generatePdf->newFile()
                    ->setHeader(trans('dashboard.link.links'),  $createdFrom)
                    ->view('dashboard.exports.link', $rows, $key, $chunk)
                    ->storeOnLocal('links/pdfs/');
        }
        $file = GeneratePdf::mergePdfFiles($names, 'links/pdfs/links.pdf');

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
        Excel::store(new LinkExport($request), 'Links/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'Links/excels/' . $fileName . '.xlsx');
        Loggable::addGlobalActivity(Link::class, $request->query(), ActivityLog::EXPORT, 'index');

        return response()->json([
            'data' => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
