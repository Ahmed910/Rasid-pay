<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\BeneficiaryRequest;
use App\Http\Resources\Api\V1\Mobile\BeneficiaryResource;
use App\Http\Resources\Dashboard\OnlyResource;
use App\Models\Beneficiary;
use App\Models\RecieveOption\RecieveOption;
use App\Models\TransferRelation\TransferRelation;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{

    public function index(Request $request)
    {
        $beneficiaries = Beneficiary::where(['user_id' => auth()->id(),'is_saved' => true])->search($request)->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
        return BeneficiaryResource::collection($beneficiaries)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function store(BeneficiaryRequest $request)
    {
        $beneficiary = auth()->user()->benficiaryTransfers()->create($request->validated());

        return BeneficiaryResource::make($beneficiary)->additional([
            'status' => true,
            'message' => __('dashboard.general.success_add')
        ]);
    }

    public function show($id)
    {
        $beneficiary = auth()->user()->benficiaryTransfers()->with('country', 'user', 'recieveOption')->findOrFail($id);
        return BeneficiaryResource::make($beneficiary)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function destroy($id)
    {
        $beneficiary = auth()->user()->benficiaryTransfers()->findOrFail($id);

        $beneficiary->delete();
        return BeneficiaryResource::make($beneficiary)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_delete')
            ]);
    }

    public function getReceiveOptions()
    {
        $recieveOptions = RecieveOption::select('id')->ListsTranslations('name')->get();

        return OnlyResource::make($recieveOptions)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }

    public function getTransferRelation()
    {
        $transferRelationships = TransferRelation::select('id')->ListsTranslations('name')->get();

        return OnlyResource::make($transferRelationships)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }
}
