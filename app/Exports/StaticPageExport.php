<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\StaticPage\StaticPage;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StaticPageExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $staticPages =  StaticPage::search($this->request)
        ->ListsTranslations('name')
        ->CustomDateFromTo($this->request)
        ->with('translations')
        ->addSelect('static_pages.created_at', 'static_pages.is_active')
        ->sortBy($this->request)
        ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = StaticPage::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.static_page', [
            'static_pages' => $staticPages,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
