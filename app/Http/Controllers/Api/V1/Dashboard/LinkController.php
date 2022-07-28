<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\LinkExport;
use App\Models\Link;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\LinkResource;
use App\Http\Requests\V1\Dashboard\LinkRequest;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;

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

    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $LinksQuery =  Link::latest()->get();


        if (!$request->has('created_from')) {
            $createdFrom = Link::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.link',
                [
                    'Links' => $LinksQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('Links/pdfs/');
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
        Excel::store(new LinkExport($request), 'Links/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'Links/excels/' . $fileName . '.xlsx');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
