<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank\Bank;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Requests\V1\Dashboard\BankRequest;
use App\Http\Resources\Dashboard\BankResource;

class BankController extends Controller
{
    public function index(Request $request)
    {
        $bank = Bank::with('translations')->latest()->paginate((int)($request->perPage ?? 15));

        return BankResource::collection($bank)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function archive(Request $request)
    {
        $banks = Bank::onlyTrashed()->latest()->paginate((int)($request->perPage ?? 15));
        return BankResource::collection($banks)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function store(BankRequest $request, Bank $bank)
    {
        $bank->fill($request->validated()+['added_by_id' => auth()->id()])->save();

        return BankResource::make($bank)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_add')
            ]);
    }


    public function show($id)
    {
        $bank = Bank::withTrashed()->findOrFail($id);

        return BankResource::make($bank)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }



    public function update(BankRequest $request, Bank $bank)
    {
        $bank->fill($request->validated())->save();

        return BankResource::make($bank)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_update')
            ]);
    }


    //soft delete (archive)
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
}
