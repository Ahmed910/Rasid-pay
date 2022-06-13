<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Http\Resources\Mobile\CardResource;

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
        return CardResource::make($card)
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_archive'),
            ]);
    }
}
