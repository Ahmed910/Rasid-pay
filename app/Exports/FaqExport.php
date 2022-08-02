<?php

namespace App\Exports;

use App\Models\Bank\Bank;
use App\Models\Faq\Faq;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FaqExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $banksQuery = Faq::search($this->request)
            ->ListsTranslations('question')
            ->customDateFromTo($this->request)
            ->addSelect('faqs.created_at', 'faqs.is_active', 'faqs.order', 'faqs.added_by_id')
            ->sortBy($this->request)
            ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = Faq::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.faq', [
            'faqs' => $banksQuery,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
