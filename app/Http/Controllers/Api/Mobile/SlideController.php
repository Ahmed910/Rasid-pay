<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Mobile\SlideResource;
use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    public function index()
    {
        $sliders = Slide::where('is_active',true)->orderBy('ordering','asc')->get();
        return SlideResource::collection($sliders)->additional(
            ['status'=>true,
            'message'=>'']);
    }
}
