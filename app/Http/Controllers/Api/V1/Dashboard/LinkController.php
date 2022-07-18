<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\Link;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\LinkResource;
use App\Http\Requests\V1\Dashboard\LinkRequest;
use Illuminate\Http\Request;

class LinkController extends Controller
{
   public function index(Request $request)
   {
    $links = Link::latest()->paginate((int)($request->per_page ?? config("globals.per_page")));
    return LinkResource::collection($links)
    ->additional(['status' => true, 'message' => '']);

   }




   public function update(LinkRequest $request, Link $link)
   {
       $link->update($request->validated());

       return LinkResource::make($link)
       ->additional([
           'message' => '',
           'status' => true
       ]);
   }








}
