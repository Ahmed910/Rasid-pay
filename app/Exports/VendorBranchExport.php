<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\VendorBranches\VendorBranch;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VendorBranchExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $vendorbranches =  VendorBranch::query()
        ->ListsTranslations('name')
        ->search($this->request)
        ->sortBy($this->request)
        ->addSelect('vendor_branches.*')
        ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = VendorBranch::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.vendor_branch', [
            'vendors' => $vendorbranches,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
