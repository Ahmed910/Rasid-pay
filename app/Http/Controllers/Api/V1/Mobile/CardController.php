<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Http\Resources\Mobile\CardResource;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        $cards = auth()->user()->cards()->latest()->get();
        return CardResource::collection($cards)->additional([
            'status' => true,
            'message' => ''
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
