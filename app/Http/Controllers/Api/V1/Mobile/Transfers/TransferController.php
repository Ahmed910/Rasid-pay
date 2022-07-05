<?php

namespace App\Http\Controllers\Api\V1\Mobile\Transfers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\Transfers\TransferTypeRequest;
use App\Http\Resources\Api\V1\Mobile\TransferResource;
use App\Models\Transfer;


class TransferController extends Controller
{
    public function index(TransferTypeRequest $request)
    {
        $transfers = Transfer::when($request->transfer_type, function ($query) use ($request) {
            switch ($request->transfer_type) {
                case 'outgoing_transfers':
                    $query->with('fromUser')->where('from_user_id', auth()->id());
                    break;
                default:
                    $query->with('toUser')->where('to_user_id', auth()->id());
            }
        })->paginate((int)($request->per_page ?? config("globals.per_page")));

        return TransferResource::collection($transfers)->additional(
            [
                'message' => '',
                'status' => true
            ]
        );
    }

    public function destroy($id)
    {
        $trasfer = Transfer::find($id)->delete();

        return TransferResource::make($trasfer)
            ->additional([
                'status' => true,
                'message' => __('dashboard.general.success_delete')
            ]);
    }
}
