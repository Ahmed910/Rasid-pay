<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\StaticPage\StaticPage;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index(Request $request)
    {
        $static_page_key = $request->query('link_key');
        $static_page_data = StaticPage::join('links', 'static_pages.id', 'links.static_page_id')
            ->join('static_page_translations', 'static_page_translations.static_page_id', 'static_pages.id')
            ->where('links.key', $static_page_key)
            ->select('static_pages.id', 'static_page_translations.name', 'static_page_translations.description')
            ->first();

        return response()->json(['data' => [
            'name' => $static_page_data->name ?? '',
            'description' => $static_page_data->description ?? ''
        ], 'status' => true, 'message' => '']);
    }
}
