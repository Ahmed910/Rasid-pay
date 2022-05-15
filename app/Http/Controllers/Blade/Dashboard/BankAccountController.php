<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blade\Dashboard\Client\ClientCollection;
use App\Models\Bank\Bank;
use App\Models\Client;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                $q->whereIn("account_status", ["pending", "refused"]);
            })->search($request);
            $clientCount = $clientsQuery->count();

            $clients = $clientsQuery->skip($request->start)
                ->take(($request->length == -1) ? $clientCount : $request->length)
                ->get()->
                sortBy($sortcol, SORT_REGULAR, $request->sort["dir"] == "desc");
            return ClientCollection::make($clients)
                ->additional(['total_count' => $clientCount]);
        }
        $banks = Bank::with("translations")->ListsTranslations("name")
            ->pluck('name', 'id')->toArray();;
        $client_types = Client::CLIENT_TYPES;
        return view('dashboard.client.account_orders'
            , compact("banks", "client_types"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
