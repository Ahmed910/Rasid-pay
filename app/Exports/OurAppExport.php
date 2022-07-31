<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\Locale\Locale;
use App\Models\OurApp\OurApp;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OurAppExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $messageTypes =  OurApp::search($this->request)
        ->ListsTranslations('name')
        ->customDateFromTo($this->request)
        ->addSelect(
            'our_apps.*'
        )
        ->sortBy($this->request)
        ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = OurApp::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.our_app', [
            'our_apps' => $messageTypes,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
