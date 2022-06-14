<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Exports\ClientPackageExport;
use App\Http\Resources\Blade\Dashboard\Package\PackageCollection;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ClientPackageRequest;
use App\Models\Package\Package;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;

class ClientPackageController extends Controller
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
        return view('dashboard.client_package.index', compact('clients'));
    }

    public function create()
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'package')) ? session(['perviousPage' => 'package']) : session(['perviousPage' => 'home']);

        $clients = User::doesntHave('clientPackages')->where(['user_type'=>'client','is_active'=>1])->pluck('users.fullname', 'users.id')->toArray();
        $packages = Package::select('id')->listsTranslations('name')->get();
        return view('dashboard.client_package.create', compact('clients', 'previousUrl','packages'));
    }

    public function store(ClientPackageRequest $request)
    {
        if (!request()->ajax()) {
            $client = User::where('user_type','client')->findOrFail($request->client_id);
            $client->clientPackages()->sync($request->discounts);
            return redirect()->back()->withSuccess(__('dashboard.package.discount_success_add', ['client' => $client->fullname]));
        }
    }

    public function edit($client_id)
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'package')) ? session(['perviousPage' => 'package']) : session(['perviousPage' => 'home']);
        $client = User::with('clientPackages')->where('user_type','client')->findOrFail($client_id);
        $packages = Package::select('id')->listsTranslations('name')->get();
        return view('dashboard.client_package.edit', compact('client', 'previousUrl','packages'));
    }

    public function update(ClientPackageRequest $request, $client_id)
    {
        if (!request()->ajax()) {
            $client = User::where('user_type','client')->findOrFail($client_id);
            $client->clientPackages()->sync($request->discounts);
            return redirect()->route('dashboard.client_package.index')->withSuccess(__('dashboard.package.discount_success_update', ['client' => $client->fullname]));
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new ClientPackageExport($request), 'clientPackages.xlsx');
    }

    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $packages = User::has('clientPackages')->where("user_type", "client")
        ->search($request)
        ->sortBy($request)
        ->with("clientPackages")
        ->get();


        if (!$request->has('created_from')) {
            $createdFrom = User::has('clientPackages')->selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }


        $mpdf = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.client_package',
                [
                    'packages' => $packages,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->export();

        return $mpdf;
    }
}
