<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Resources\Blade\Dashboard\Citizen\CitizenResource;
use App\Models\Citizen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Blade\Dashboard\Citizen\CitizenCollection;

class CitizenController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->order[0]['column'])) {
            $request['sort'] = ['column' => $request['columns'][$request['order'][0]['column']]['name'], 'dir' => $request['order'][0]['dir']];
        }
        $sortcol = isset($request->sort["column"]) ? $request->sort["column"] : null;
        if (isset($request->sort["column"]) && in_array($request->sort["column"], Citizen::user_searchable_Columns)) $sortcol = "user." . $request->sort["column"];
        if (isset($request->sort["column"]) && key_exists($request->sort["column"], Citizen::ENABLEDCARD_SORTABLE_COLUMS)) $sortcol = Citizen::ENABLEDCARD_SORTABLE_COLUMS[$sortcol];
        if ($request->ajax()) {
            $citizensQuery = Citizen::with(["user.citizenCards", 'enabledCard.cardPackage.translation'])->search($request);
            $citizenCount = $citizensQuery->count();

            $citizens = $citizensQuery->skip($request->start)
                ->take(($request->length == -1) ? $citizenCount : $request->length)
                ->get()->sortBy($sortcol, SORT_REGULAR, $request->sort["dir"] == "desc");


            return CitizenCollection::make($citizens)
                ->additional(['total_count' => $citizenCount]);
        }


        return view('dashboard.citizen.index');
    }

    public function update(Request $request, $id)
    {
        $citizen = Citizen::findOrFail($id);
        $validated = $request->validate([
            "phone" => ["nullable", "numeric", "digits_between:7,20"],
        ]);
        $citizen->user()->update(["phone" => $request->phone]);

        return redirect()->route('dashboard.citizen.index')->withSuccess(__('dashboard.general.success_update'));
    }
    public function updatePhone($id, Request $request)
    {
        $this->validate($request, ["country_code" => "required|in:" . countries_list()
            , "phone" => ["required", "not_regex:/^{$request->country_code}/", "numeric", "digits_between:7,20", "required_with:country_code"]]);

        $citizen = Citizen::where('user_id', $id)->firstOrFail();
        $citizen->user->update($request->all() + ['updated_at' => now()]);

        return CitizenResource::make($citizen)->additional(['status' => true, 'message' => trans("dashboard.general.success_update")]);
    }
}
