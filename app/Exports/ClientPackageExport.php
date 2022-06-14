<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class ClientPackageExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
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
            'packages' => $packages,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
