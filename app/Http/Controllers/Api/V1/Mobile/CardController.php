<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Http\Resources\Mobile\CardResource;

class CardController extends Controller
{
    public function index()
    {

        $cards = Card::get();
        return CardResource::collection($cards)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function destroy(Card $card)
    {
        $card->delete();
        return CardResource::make($card)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_archive'),
            ]);
    }

    public function restore($id)
    {
        $card = Card::onlyTrashed()->findOrFail($id);
        $card->restore();

        return CardResource::make($card)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_restore'),
            ]);
    }


    public function forceDelete($id)
    {
        $card = Card::onlyTrashed()->findorfail($id);
        $card->forceDelete();

        return CardResource::make($card)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_delete'),
            ]);
    }


}
