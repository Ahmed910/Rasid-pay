<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AdminsExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {

        $adminsQuery = User::CustomDateFromTo($this->request)->search($this->request)->where('user_type', 'admin')->has("employee")->get();


        return view('dashboard.exports.admin', [
            'admins' => $adminsQuery
        ]);
    }
}
