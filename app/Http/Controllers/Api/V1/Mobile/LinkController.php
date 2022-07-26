<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Http\Controllers\Controller;
use App\Models\StaticPage\StaticPage;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function show($static_page_key)
    {

        $static_page_data = \DB::table('static_pages')
           ->join('links','static_pages.id','links.static_page_id')
           ->join('static_page_translations','static_page_translations.static_page_id','static_pages.id')
           ->where('links.key',$static_page_key)
           ->select('static_pages.id','static_page_translations.name','static_page_translations.description')
           ->get()->all();

           return response()->json(['data' => $static_page_data + ['key' => $static_page_data],'status' => true,'message' =>'']);
    }
}
