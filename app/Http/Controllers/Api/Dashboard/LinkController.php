<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\LinkExport;
use App\Models\Link;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Dashboard\LinkResource;
use App\Http\Requests\Dashboard\LinkRequest;
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
        if (!$LinksQuery->count()) {
            $file = GeneratePdf::createNewFile(
                trans('dashboard.link.links'),
                $createdFrom,'dashboard.exports.link',
                $LinksQuery,0,$chunk,'links/pdfs/'
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
        foreach (($LinksQuery->chunk($chunk)) as $key => $rows) {
            $names[] = GeneratePdf::createNewFile(
                trans('dashboard.link.links'),$createdFrom,
                'dashboard.exports.link',
                $rows,$key,$chunk,'links/pdfs/'
            );
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
