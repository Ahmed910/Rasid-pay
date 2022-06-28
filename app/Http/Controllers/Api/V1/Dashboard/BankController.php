<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\Bank\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BankBranch\BankBranch;
use App\Http\Requests\V1\Dashboard\BankRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\Banks\BankResource;
use App\Http\Resources\Dashboard\Banks\BankCollection;
use App\Http\Resources\Dashboard\Banks\BankForEditResource;

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
        $bank = Bank::withTrashed()->findOrFail($id);
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

    public function editShow(Bank $bank)
    {
        $bank->load('branches.translations', 'translations');

        return BankForEditResource::make($bank)->additional([
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

    public function bankTypes()
    {
        $data = transform_array_api(BankBranch::TYPES, 'dashboard.bank.types');

        return response()->json([
            'data' => $data,
            'status' => true,
            'message' => ' '
        ], 200);
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
}
