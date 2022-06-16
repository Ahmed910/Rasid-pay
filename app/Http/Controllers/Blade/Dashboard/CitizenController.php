<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Models\Citizen;
use App\Models\Package\Package;
use App\Models\User;
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
            $citizensQuery = Citizen::with(["user.citizenPackages", 'enabledPackage'])->search($request);
            $citizenCount = $citizensQuery->count();

            $citizens = $citizensQuery->skip($request->start)
                ->take(($request->length == -1) ? $citizenCount : $request->length)
                ->sortBy($request)
                ->get();

            return CitizenCollection::make($citizens)
                ->additional(['total_count' => $citizenCount]);
        }

        $packages = Package::get();
        return view('dashboard.citizen.index',compact('packages'));
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
        $messages = [
        "phone.required"=>trans("dashboard.citizens.phone_required"),
        "full_phone.unique"=>trans("dashboard.citizens.phone_unique")
           ] ;

        $request->merge(["full_phone" => $request->country_code . $request->phone]);
        $fileds =   $this->validate($request, [
            "country_code" => "required|in:" . countries_list(),
            "phone" => ["required","starts_with:5", "not_regex:/^{$request->country_code}/", "numeric", "digits_between:7,20", "required_with:country_code"],
            "full_phone" => ["unique:users,phone," . @$id],

        ],$messages);
        $citizen = User::where('user_type', "citizen")->with(["citizenTransactions"=>function($q){$q->where("trans_status","pending");}])->findOrFail($id);
        if(count($citizen->citizenTransactions))
            return redirect()->route('dashboard.citizen.index')->withErrors(__('dashboard.citizen.update_phone_has-transations'));
        $citizen->update($fileds + ['updated_at' => now()]);

        return redirect()->route('dashboard.citizen.index')->withSuccess(__('dashboard.general.success_update'));
    }
}
