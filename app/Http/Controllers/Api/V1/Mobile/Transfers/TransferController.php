<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Transfers\TransferTypeRequest;
use App\Http\Resources\Mobile\TransferResource;
use App\Models\Transfer;


class TransferController extends Controller
{
    public function index(TransferTypeRequest $request)
    {

        $transfers = Transfer::when($request->transfer_type, function ($query) use ($request) {
            switch ($request->transfer_type) {
                case 'outgoing_transfers':
                    $query->with('from_user')->where('from_user_id', auth()->id());
                    break;
                default:
                    $query->with('to_user')->where('to_user_id', auth()->id());
            }
        })->paginate((int)($request->per_page ?? config("globals.per_page")));

        return TransferResource::collection($transfers)->additional(
            [
                'message' => '',
                'status' => true
            ]
        );
    }
}
