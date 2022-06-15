<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\BeneficiaryRequest;
use App\Http\Resources\Mobile\BeneficiaryResource;
use App\Models\Beneficiary;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{

    public function index(Request $request)
    {
        $beneficiaries = Beneficiary::where('user_id',auth()->id())->search($request)->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

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
            'message' => ''
        ]);
    }

    public function show($id)
    {
        $beneficiary = auth()->user()->benficiaryTransfers()->with('country','user','recieveOption')->findOrFail($id);
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
}
