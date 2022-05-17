<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CardPackage\CardPackage;
use Illuminate\Http\Request;

class CardPackageController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.card_package.index');
    }

    public function create(Request $request)
    {
        return view('dashboard.card_package.create');
    }
    public function show(Request $request, CardPackage $card_package)
    {
        return view('dashboard.card_package.show',compact('card_package'));
    }
}
