<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Department\Department;
use App\Http\Requests\V1\Dashboard\BankRequest;
use App\Models\Bank\Bank;
use App\Models\BankBranch\BankBranch ;
use App\Models\Employee;
use App\Models\RasidJob\RasidJob;
use App\Models\User;
use Illuminate\Http\Request;


class BankController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.bank.index');
    }

    public function create(){

        $previousUrl = url()->previous();
            (strpos($previousUrl, 'bank')) ? session(['perviousPage' => 'bank']) : session(['perviousPage' => 'home']);

            $locales = config('translatable.locales');
            $types =BankBranch::TYPES;

            return view('dashboard.Bank.create',compact('locales','types','previousUrl'));

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
