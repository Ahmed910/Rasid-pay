<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CardPackageRequest;
use App\Models\CardPackage\CardPackage;
use Illuminate\Support\Facades\DB;

class CardPackageController extends Controller
{
    public function index(Request $request)
    {

        return view('dashboard.card_package.index');
    }

    public function create()
    {
        $clients = User::doesntHave('cardPackage')->where("user_type", "client")->pluck('users.fullname', 'users.id');
        return view('dashboard.card_package.create', compact('clients'));
    }

    public function store(CardPackageRequest $request)
    {
        $card_package = CardPackage::create($request->validated());
        return redirect()->route('dashboard.card_package.index')->withSuccess(__('dashboard.general.success_add'));

    }


    public function show(Request $request, CardPackage $card_package)
    {
        return view('dashboard.card_package.show', compact('card_package'));
    }
}
