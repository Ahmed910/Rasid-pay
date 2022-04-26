<?php

namespace App\Http\Controllers\Blade\Dashboard;

use Illuminate\Http\Request;
use App\Models\{User, Client};
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

        if ($request->ajax()) {

            $clientsQuery = User::CustomDateFromTo($request)->search($request)->with(['client'])->where('user_type', 'client')
                ->sortBy($request);

            $clientCount = $clientsQuery->count();

            $clients = $clientsQuery->skip($request->start)
                ->take(($request->length == -1) ? $clientCount : $request->length)
                ->get();


            return ClientCollection::make($clients)
                ->additional(['total_count' => $clientCount]);
        }


        return view('dashboard.client.index');
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
        return view('dashboard.client.create');
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
