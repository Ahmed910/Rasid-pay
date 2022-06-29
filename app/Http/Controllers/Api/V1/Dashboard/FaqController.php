<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\Faq\Faq;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\FaqRequest;
use App\Http\Resources\Dashboard\Faq\FaqResource;
use App\Http\Resources\Dashboard\Faq\FaqCollection;
use Illuminate\Http\Request;

class  FaqController extends Controller
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

    public function store(FaqRequest $request)
    {
        $faq = Faq::create($request->validated());

        return FaqResource::make($faq->refresh())->additional(['status' => true,'message' => trans('dashboard.general.success_add')]);
    }


    public function update(FaqRequest $request,Faq $faq)
    {
        $faq->update($request->validated());
        return FaqResource::make($faq->refresh())->additional(['status' => true,'message' => trans('dashboard.general.success_update')]);
    }




    public function show(Request $request , $id)
    {
        $faq  = Faq::withTrashed()->findOrFail($id);
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
