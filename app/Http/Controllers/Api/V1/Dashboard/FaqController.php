<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\Faq\Faq;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\Faq\FaqResource;

class  FaqController extends Controller
{

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
