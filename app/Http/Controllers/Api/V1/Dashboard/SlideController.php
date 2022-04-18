<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\SlideRequest;
use App\Http\Resources\Api\V1\Dashboard\SlideResource;
use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller
{

    public function index()
    {
        $sliders = Slide::active()->orderBy('ordering','asc')->paginate(config('globals.per_page'));
        return SlideResource::collection($sliders)->additional(['status'=>true,'message'=>'']);
    }

    public function store(SlideRequest $request, Slide $slide)
    {
        $slide->fill($request->validated() + ['added_by_id' => auth()->id()])->save();

        $slide->load(['images','addedBy']);
        return SlideResource::make($slide)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_add")
            ]);
    }

    public function update(SlideRequest $request, Slide $slide)
    {
        $slide->fill($request->validated() + ['updated_at' => now()])->save();

        $slide->load(['images','addedBy']);

        return SlideResource::make($slide)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_update")
            ]);;
    }

    public function destroy(Slide $slide)
    {


        $slide->delete();

        return SlideResource::make($slide)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.success_archive")
            ]);
    }
}
