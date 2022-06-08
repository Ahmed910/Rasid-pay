<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Resources\Blade\Dashboard\CardPackage\CardPackageCollection;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CardPackageRequest;
use App\Models\Package\CardPackage;

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
        $clients = User::doesntHave('cardPackage')->where("user_type", "client")->pluck('users.fullname', 'users.id')->toArray();
        return view('dashboard.card_package.create', compact('clients', 'previousUrl'));
    }

    public function store(CardPackageRequest $request, CardPackage $card_package)
    {
        if (!request()->ajax()) {
            $card_package->fill($request->validated())->save();
            $client_name = $card_package->load(['client:id,fullname'])->client->fullname;
            return redirect()->route('dashboard.card_package.index')->withSuccess(__('dashboard.card_package.discount_success_add', ['client' => $client_name]));
        }
    }

    public function edit(CardPackage $card_package)
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'card_package')) ? session(['perviousPage' => 'card_package']) : session(['perviousPage' => 'home']);
        $client = $card_package->load(['client:id,fullname'])->client;
        return view('dashboard.card_package.edit', compact('card_package', 'client'));
    }

    public function update(CardPackageRequest $request, CardPackage $card_package)
    {
        if (!request()->ajax()) {
            $card_package->fill($request->validated() + ['updated_at' => now()])->save();
            $client = $card_package->load(['client:id,fullname'])->client;
            return redirect()->route('dashboard.card_package.index')->withSuccess(__('dashboard.card_package.discount_success_update', ['client' => $client->fullname]));
        }
    }
}
