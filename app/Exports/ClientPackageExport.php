<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\View\View;

class ClientPackageExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(app()->getLocale() == 'ar' ? true : false);
            },
        ];
    }
    public function view(): View
    {
        if (isset($this->request->order[0]['column'])) {
            $this->request['sort'] = ['column' => $this->request['columns'][$this->request['order'][0]['column']]['name'], 'dir' => $this->request['order'][0]['dir']];
        }
        $packages = User::has('clientPackages')->where("user_type", "client")
            ->search($this->request)
            ->sortBy($this->request)
            ->with("clientPackages")
            ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = User::has('clientPackages')->selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }


        return view('dashboard.exports.client_package', [
            'rows' => $packages,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
