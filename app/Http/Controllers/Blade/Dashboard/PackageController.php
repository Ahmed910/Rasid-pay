<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Resources\Blade\Dashboard\Package\PackageCollection;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PackageRequest;
use App\Models\Package\Package;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }

        if ($request->ajax()) {
            $citizensQuery = User::has('clientPackages')->where("user_type", "client")
                ->search($request);
            $citizenCount = $citizensQuery->count();
            $clients = $citizensQuery->skip($request->start)
                ->take(($request->length == -1) ? $citizenCount : $request->length)
                ->sortBy($request)
                ->with("clientPackages")
                ->get();
            return PackageCollection::make($clients)
                ->additional(['total_count' => $citizenCount]);
        }
        $clients = User::has('clientPackages')->where("user_type", "client")->pluck('users.fullname', 'users.id');
        return view('dashboard.package.index', compact('clients'));
    }

    public function create()
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'package')) ? session(['perviousPage' => 'package']) : session(['perviousPage' => 'home']);
        $clients = User::doesntHave('clientPackages')->where("user_type", "client")->pluck('users.fullname', 'users.id')->toArray();
        return view('dashboard.package.create', compact('clients', 'previousUrl'));
    }

    public function store(PackageRequest $request, Package $package)
    {
        if (!request()->ajax()) {
            $package->fill($request->validated())->save();
            $client_name = $package->load(['client:id,fullname'])->client->fullname;
            return redirect()->route('dashboard.package.index')->withSuccess(__('dashboard.package.discount_success_add', ['client' => $client_name]));
        }
    }

    public function edit(Package $package)
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'package')) ? session(['perviousPage' => 'package']) : session(['perviousPage' => 'home']);
        $client = $package->load(['client:id,fullname'])->client;
        return view('dashboard.package.edit', compact('package', 'client'));
    }

    public function update(PackageRequest $request, Package $package)
    {
        if (!request()->ajax()) {
            $package->fill($request->validated() + ['updated_at' => now()])->save();
            $client = $package->load(['client:id,fullname'])->client;
            return redirect()->route('dashboard.package.index')->withSuccess(__('dashboard.package.discount_success_update', ['client' => $client->fullname]));
        }
    }
}
