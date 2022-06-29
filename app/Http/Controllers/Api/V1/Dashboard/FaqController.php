<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\Faq\FaqCollection;
use App\Http\Resources\Dashboard\Faq\FaqResource;
use App\Models\Faq\Faq;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $faq = Faq::search($request)
            ->ListsTranslations('question')
            ->CustomDateFromTo($request)
            ->addSelect('faqs.created_at', 'faqs.is_active','faqs.order','faqs.added_by_id')
            ->sortBy($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));

        return FaqResource::collection($faq)->additional([
            'status'=>true,
            'message'=>''
        ]);

    }


    public function show(Request $request , $id)
    {
        $faq  = Faq::findOrFail($id);
        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $faq->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return FaqCollection::make($activities)->additional([
            'status' => true,
            'message' => ''
        ]);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return FaqResource::make($faq)
            ->additional([
                'status' => true,
                'message' =>  __('dashboard.general.success_delete')
            ]);
    }


}
