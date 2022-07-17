<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Models\Link;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\LinkResource;
use App\Http\Requests\V1\Dashboard\LinkRequest;

class LinkController extends Controller
{
   public function index()
   {
    return LinkResource::collection(Link::latest()->get())->additional(['status' => true, 'message' => '']);

   }

   public function show(Link $link)
   {
       return LinkResource::make($link)
       ->additional([
           'message' => '',
           'status' => true
       ]);
   } 
   
   public function store(LinkRequest $request)
   {
       $links = Link::create($request->validated());

       return LinkResource::make($links)
       ->additional([
           'message' => '',
           'status' => true
       ]);
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
