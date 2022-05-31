<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blade\Dashboard\Bank\BankBranchCollection;
use App\Http\Requests\Dashboard\BankBladeRequest;
use App\Models\Bank\Bank;
use App\Models\BankBranch\BankBranch;
use App\Models\User;
use Illuminate\Http\Request;


class BankController extends Controller
{
    public function index(Request $request)
    {

        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }
        if ($request->ajax()) {
            $bankBranches = BankBranch::with('bank.translations')
                ->with(['bank' => fn($q) => $q->withCount('transactions')])
                ->search($request);
            $bankBranchesCount = $bankBranches->count();

            $bankBranches = $bankBranches->skip($request->start)
                ->take(($request->length == -1) ? $bankBranchesCount : $request->length)->sortBy($request)
                ->get();
            return BankBranchCollection::make($bankBranches)
                ->additional(['total_count' => $bankBranchesCount]);
        }

        $types = collect(transform_array_api(BankBranch::TYPES, 'dashboard.bank.types'))->toArray();
        return view('dashboard.bank.index', compact("types"));
    }

    public function create()
    {

        $previousUrl = url()->previous();
        (strpos($previousUrl, 'bank')) ? session(['perviousPage' => 'bank']) : session(['perviousPage' => 'home']);

        $locales = config('translatable.locales');
        $types = BankBranch::TYPES;

        return view('dashboard.bank.create', compact('locales', 'types', 'previousUrl'));

    }

    public function store(BankBladeRequest $request, Bank $bank)
    {
        $BankInfo = Bank::create($request->only('name') + ['added_by_id' => auth()->id()]);
        $BankInfo->branches()->createMany($request->branches);

        return redirect()->route('dashboard.bank.index')->withSuccess(__('dashboard.general.success_add'));


    }


    public function show(Request $request)
    {
        return view('dashboard.bank.show');
    }

    public function edit($id)
    {

        $previousUrl = url()->previous();
        (strpos($previousUrl, 'bank')) ? session(['perviousPage' => 'bank']) : session(['perviousPage' => 'home']);

        $bank = Bank::withTrashed()->findOrFail($id);

        $locales = config('translatable.locales');
        $branches = $bank->branches()->get()->toArray();


        return view('dashboard.bank.edit', compact('locales', 'bank', 'branches'));
    }

    public function update(BankBladeRequest $request, Bank $bank)
    {


        $data = $request->validated();

        $bank->fill($data + ['updated_at' => now()])->save();

        $branchesIds = $bank->branches()->pluck('id')->toArray();
        // dd($branchesIds);
        $newBranchesIds = collect($data['branches'])->pluck('id')->toArray();

        foreach ($branchesIds as $id) {
            if (!in_array($id, $newBranchesIds)) {
                BankBranch::find($id)->delete();
            }
        }

        foreach ($data['branches'] as $key => $values) {
            BankBranch::updateOrCreate(
                ['id' => $data['branches'][$key]['id'] ?? ''],
                $values + ['bank_id' => $bank->id]
            );
        }

        return redirect()->route('dashboard.bank.index')->withSuccess(__('dashboard.general.success_update'));
    }


}
