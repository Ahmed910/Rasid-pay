<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\SlideResource;
use App\Models\Slide;

class SlideController extends Controller
{
    //

    public function index()
    {
        $sliders = Slide::where('is_active',true)->orderBy('ordering','asc')->get();
        return SlideResource::collection($sliders)->additional(
            ['status'=>true,
            'message'=>'']);
    }


}
