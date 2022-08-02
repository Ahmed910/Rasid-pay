<?php

namespace App\Exports;

use App\Models\Citizen;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CitizenExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $citizensQuery = Citizen::with(['user', "enabledPackage"])
            ->whereHas('user', fn ($q) => $q->where('register_status', 'completed'))
            ->customDateFromTo($this->request)
            ->search($this->request)
            ->sortBy($this->request)
            ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = Citizen::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.citizen', [
            'citizens' => $citizensQuery,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
