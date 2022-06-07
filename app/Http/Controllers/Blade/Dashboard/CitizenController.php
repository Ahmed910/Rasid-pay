<?php

namespace App\Http\Controllers\Blade\Dashboard;

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

        if ($request->ajax()) {
            $citizensQuery = Citizen::with(["user.citizenPackages", 'enabledCard.cardPackage'])->search($request);
            $citizenCount = $citizensQuery->count();

            $citizens = $citizensQuery->skip($request->start)
                ->take(($request->length == -1) ? $citizenCount : $request->length)
                ->sortBy($request)
                ->get();

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
        $request->merge(["full_phone" => $request->country_code . $request->phone]);
        $fileds =   $this->validate($request, [
            "country_code" => "required|in:" . countries_list(),
            "phone" => ["required", "not_regex:/^{$request->country_code}/", "numeric", "digits_between:7,20", "required_with:country_code"],
            "full_phone" => ["unique:users,phone," . @$id],

        ]);
        $citizen = Citizen::where('user_id', $id)->firstOrFail();
        $citizen->user->update($fileds + ['updated_at' => now()]);

        return redirect()->route('dashboard.citizen.index')->withSuccess(__('dashboard.general.success_update'));
    }
}
