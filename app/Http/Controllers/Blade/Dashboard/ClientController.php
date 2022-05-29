<?php

namespace App\Http\Controllers\Blade\Dashboard;

use Illuminate\Http\Request;
use App\Models\{Bank\Bank, User, Client};
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\ClientRequest;
use App\Http\Resources\Blade\Dashboard\Client\ClientCollection;
use App\Http\Resources\Blade\Dashboard\Activitylog\ActivityLogCollection;

class ClientController extends Controller
{


    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }
        $sortcol = isset($request->sort["column"]) ? $request->sort["column"] : null;
        if (isset($request->sort["column"]) && in_array($request->sort["column"], Client::user_searchable_Columns)) $sortcol = "user." . $request->sort["column"];
        else if (isset($request->sort["column"]) && array_key_exists($request->sort["column"], Client::bank_sort_Columns)) $sortcol = Client::bank_sort_Columns[$request->sort["column"]];
        else if (isset($request->sort["column"]) && array_key_exists($request->sort["column"], Client::bank_acc_sort_Columns)) $sortcol = Client::bank_acc_sort_Columns[$sortcol];

        if ($request->ajax()) {
            $clientsQuery = Client::whereHas("user.bankAccount", function ($q) {
                $q->whereIn("account_status", ["pending", "accepted", "reviewed"]);
            })->search($request);

            $clientCount = $clientsQuery->count();

            $clients = $clientsQuery->skip($request->start)
                ->take(($request->length == -1) ? $clientCount : $request->length)->sortBy($request)
                ->get();
            //                ->sortBy($sortcol, SORT_REGULAR, $request->sort["dir"] == "desc");
            return ClientCollection::make($clients)
                ->additional(['total_count' => $clientCount]);
        }
        $banks = Bank::with("translations")->ListsTranslations("name")
            ->pluck('name', 'id')->toArray();;
        $client_types = Client::CLIENT_TYPES;
        return view(
            'dashboard.client.index',
            compact("banks", "client_types")
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $previousUrl = url()->previous();
        (strpos($previousUrl, 'client')) ? session(['perviousPage' => 'client']) : session(['perviousPage' => 'home']);
        return view('dashboard.client.create',compact('previousUrl'));
    }

    public function accountOrders()
    {
        return view('dashboard.client.account_orders');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request, User $client)
    {
        $client->fill($request->validated())->save();

        return redirect()->route('dashboard.client.index')->withSuccess(__('dashboard.general.success_add'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $client = User::withTrashed()->where('user_type', 'client')->findOrFail($id);


        $sortingColumns = [
            'id',
            'user_name',
            'department_name',
            'created_at',
            'action_type',
            'reason'
        ];
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $sortingColumns[$request->order[0]['column']], 'dir' => $request->order[0]['dir']];
        }

        $activitiesQuery = $client->activity()
            ->sortBy($request);

        if ($request->ajax()) {
            $activityCount = $activitiesQuery->count();
            $activities = $activitiesQuery->skip($request->start)
                ->take(($request->length == -1) ? $activityCount : $request->length)
                ->get();

            return ActivityLogCollection::make($activities)
                ->additional(['total_count' => $activityCount]);
        }
        return view('dashboard.client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('dashboard.client.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, User $client)
    {
        $client->fill($request->validated() + ['updated_at' => now()])->save();

        return redirect()->route('dashboard.client.index')->withSuccess(__('dashboard.general.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
    }
}
