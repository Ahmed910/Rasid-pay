<?php

namespace App\Exports;

use App\Models\Group\Group;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GroupsExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {

        $groupsQuery = Group::with('groups', 'permissions')
        ->withTranslation()
        ->withCount('admins as user_count')
        ->search($this->request)
        ->get();

        return view('dashboard.exports.group', [
            'groups' => $groupsQuery
        ]);
    }
}
