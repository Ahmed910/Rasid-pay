<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank\Bank;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Requests\V1\Dashboard\BankRequest;
use App\Http\Resources\Dashboard\BankResource;
use App\Models\BankBranch\BankBranch;

class BankController extends Controller
{
    public function index(Request $request)
    {
        $bank = Bank::with('translations')->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

        return BankResource::collection($bank)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function archive(Request $request)
    {
        $banks = Bank::onlyTrashed()->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
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
        $bank->branches()->createMany($data['banks']);

        return BankResource::make($bank)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_add')
            ]);
    }


    public function show($id)
    {
        $bank = Bank::withTrashed()->findOrFail($id)->load('translations');

        return BankResource::make($bank)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }



    public function update(BankRequest $request, Bank $bank)
    {
        $data  = $request->validated();
        $bank->fill($data + ['updated_at' => now()])->save();

        foreach ($data['banks'] as $key => $values) {
            BankBranch::updateOrCreate(
                ['id' => $data['banks'][$key]['id']],
                $values + ['bank_id' => $bank->id]
            );
        }

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
