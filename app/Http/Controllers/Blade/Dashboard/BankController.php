<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blade\Dashboard\Bank\BankBranchCollection;
use App\Models\Department\Department;
use App\Http\Requests\V1\Dashboard\BankRequest;
use App\Models\Bank\Bank;
use App\Models\BankBranch\BankBranch;
use App\Models\Employee;
use App\Models\RasidJob\RasidJob;
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

    public function store(BankRequest $request, Bank $bank)
    {
        $BankInfo = Bank::create($request->only('name') + ['added_by_id' => auth()->id()]);
        $BankInfo->branches()->createMany($request->branches);

        return redirect()->route('dashboard.bank.index')->withSuccess(__('dashboard.general.success_add'));


    }


    public function show(Request $request)
    {
        return view('dashboard.bank.show');
    }

}
