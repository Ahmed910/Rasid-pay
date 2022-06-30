<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Mobile\CardRequest;
use App\Models\Card;
use App\Http\Resources\Api\V1\Mobile\CardResource;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $cards = auth()->user()->cards()->latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
        $message = !$cards->count() ? trans('mobile.card.without_cards') : '';
        return CardResource::collection($cards)->additional([
            'status' => true,
            'message' => $message
        ]);
    }

    public function update(CardRequest $request, $id)
    {
        $card = auth()->user()->cards()->findOrFail($id);
        $card->update(['card_name' => $request->card_name]);
        return CardResource::make($card)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_update'),
            ]);
    }

    public function destroy($id)
    {
        $card = auth()->user()->cards()->findOrFail($id);
        $card->delete();
        return CardResource::make($card)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_delete'),
            ]);
    }
}
