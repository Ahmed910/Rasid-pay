<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Resources\Blade\Dashboard\CardPackage\CardPackageCollection;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CardPackageRequest;
use App\Models\CardPackage\CardPackage;

class CardPackageController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }

        if ($request->ajax()) {
            $citizensQuery = User::has('cardPackage')->where("user_type", "client")
                ->search($request);
            $citizenCount = $citizensQuery->count();
            $clients = $citizensQuery->skip($request->start)
                ->take(($request->length == -1) ? $citizenCount : $request->length)
                ->sortBy($request)
                ->with("cardPackage")
                ->get();
            return CardPackageCollection::make($clients)
                ->additional(['total_count' => $citizenCount]);
        }
        $clients = User::has('cardPackage')->where("user_type", "client")->pluck('users.fullname', 'users.id');
        return view('dashboard.card_package.index', compact('clients'));
    }

    public function create()
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'card_package')) ? session(['perviousPage' => 'card_package']) : session(['perviousPage' => 'home']);
        $clients = User::doesntHave('cardPackage')->where("user_type", "client")->pluck('users.fullname', 'users.id');
        return view('dashboard.card_package.create', compact('clients'));
    }

    public function store(CardPackageRequest $request)
    {
        if (!request()->ajax()) {
            CardPackage::create($request->validated());
            return redirect()->route('dashboard.card_package.index')->withSuccess(__('dashboard.general.success_add'));
        }

    }


    public function show(Request $request, CardPackage $card_package)
    {
        return view('dashboard.card_package.show', compact('card_package'));
    }

    public function edit(Request $request, CardPackage $card_package)
    {
        return view('dashboard.card_package.show', compact('card_package'));
    }
}
