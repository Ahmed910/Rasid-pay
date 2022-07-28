<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\BankExoprt;
use App\Exports\BankExport;
use App\Models\Bank\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\BankRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\Banks\BankResource;
use App\Http\Resources\Dashboard\Banks\BankCollection;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;

class BankController extends Controller
{
    public function index(Request $request)
    {
        $banks = Bank::with('translations')
                    ->search($request)
                    ->sortBy($request)
                    ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return BankResource::collection($banks)
        ->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function store(BankRequest $request, Bank $bank)
    {
        $data = $request->validated();
        $bank->fill($data + ['added_by_id' => auth()->id()])->save();

        return BankResource::make($bank)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_add')
            ]);
    }


    public function show(Request $request, $id)
    {
        $bank = Bank::withTrashed()->with('translations')->findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $bank->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return BankCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function update(BankRequest $request, Bank $bank)
    {
        $data  = $request->validated();
        $bank->fill($data + ['updated_at' => now()])->save();

        return BankResource::make($bank)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_update')
            ]);
    }

    public function destroy(ReasonRequest $request, Bank $bank)
    {
        $bank->delete();

        return BankResource::make($bank)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_archive')
            ]);
    }


    public function restore(ReasonRequest $request, $id)
    {
        $bank = Bank::onlyTrashed()->findOrFail($id);
        $bank->restore();

        return BankResource::make($bank)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.restore')
            ]);
    }

    public function forceDelete(ReasonRequest $request, $id)
    {
        $Bank = Bank::onlyTrashed()->findOrFail($id);
        $Bank->forceDelete();

        return BankResource::make($Bank)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_delete')
            ]);
    }

    public function archive(Request $request)
    {
        $banks = Bank::onlyTrashed()->latest()
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return BankResource::collection($banks)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }
    #endregion Delete
      public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $banksQuery = Bank::search($request)
        ->CustomDateFromTo($request)
        ->ListsTranslations('name')
        ->sortBy($request)
        ->addSelect('banks.created_at', 'banks.is_active')
        ->get();


        if (!$request->has('created_from')) {
            $createdFrom = Bank::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.bank',
                [
                    'banks' => $banksQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('banks/pdfs/');
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
        Excel::store(new BankExport($request), 'banks/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'banks/excels/' . $fileName . '.xlsx');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
