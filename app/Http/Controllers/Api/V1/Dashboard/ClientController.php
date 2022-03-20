<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\AttachmentRequest;
use App\Http\Requests\V1\Dashboard\BankAccountRequest;
use App\Http\Requests\V1\Dashboard\ClientRequest;
use App\Http\Requests\V1\Dashboard\ManagerRequest;
use App\Http\Requests\V1\Dashboard\ReasonRequest;
use App\Http\Resources\Dashboard\ClientResource;
use App\Models\Attachment;
use App\Models\BankAccount;
use App\Models\Client;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index(Request $request)
    {
        $client = Client::CustomDateFromTo($request)->with("user.attachments")->search($request)->sortby($request)
            ->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));

        return ClientResource::collection($client)->additional([
            'status' => true,
            'message' => ""
        ]);
    }


    public function create()
    {
        //
    }


    public function store(ClientRequest      $request, AttachmentRequest $attachmentRequest,
                          BankAccountRequest $bankAccountRequest, ManagerRequest $managerRequest, Client $client, BankAccount $bankAccount, Manager $manager)
    {
        $except = ["tax_number", "commercial_number", "activity_type", "daily_expect_trans", "register_type", "client_type", "nationality", "address", "marital_status"];
        $userData = $request->safe()->except($except) + ["user_type" => "client", 'added_by_id' => auth()->id()];
        $clientData = $request->safe()->only($except);

        $user = user::create($userData);
        $bankAccount->fill($bankAccountRequest->validated())->user()->associate($user)->save();

        $client->fill($clientData)->user()->associate($user)->save();
        $manager->fill($managerRequest->validated())->save();
        $manager->clients()->save($client);

        if ($attachmentRequest->has("files"))

            Attachment::storeImage($attachmentRequest, $user);


        $client->load(['user', 'user.attachments', 'manager']);

        return ClientResource::make($client)->additional([
            'status' => true, 'message' => trans("dashboard.general.success_add")
        ]);
    }

    public function show($id)
    {
        $client = Client::where('user_id', $id)->firstOrFail();
        $client->load(['user', 'user.attachments', 'manager', 'user.bankAccount']);

        return ClientResource::make($client)->additional(['status' => true, 'message' => ""]);
    }

    public function edit($id)
    {
        //
    }


    public function update($id, ClientRequest $request, AttachmentRequest $attachmentRequest, BankAccountRequest $bankAccountRequest,
                           ManagerRequest $managerRequest)
    {
        $client = Client::where('user_id', $id)->firstOrFail();
        $except = ["tax_number", "commercial_number", "activity_type", "daily_expect_trans", "register_type", "client_type", "nationality", "address", "marital_status"];
        $client->user()->update($request->safe()->except($except));
        $client->update($request->safe()->only($except));
        $client->user->bankAccount->update($bankAccountRequest->validated());
        $client->manager()->update($managerRequest->validated());
        $client->load(['user', 'user.attachments', 'manager']);
        return ClientResource::make($client)->additional([
            'status' => true, 'message' => trans("dashboard.general.success_update")
        ]);
    }

    public function forceDestroy(ReasonRequest $request, $id)
    {
        $user = User::onlyTrashed()->findorfail($id);
        $user->forceDelete();

        return ClientResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_delete'),
            ]);
    }


    public function destroy(ReasonRequest $request, User $user)
    {

        $user->delete();

        return ClientResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_archive'),
            ]);
    }


    public function restore(ReasonRequest $request, $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return ClientResource::make($user)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_restore'),
            ]);
    }
}
