<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Mobile\FaqResource;
use App\Models\Faq\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $faqs = Faq::withTranslation()->where('is_active',true)
        ->orderBy('order','asc')->paginate((int)($request->per_page ?? config("globals.per_page")));
        return FaqResource::collection($faqs)->additional([
            'status' => true,
            'message' => ''
        ]);
    }
}
