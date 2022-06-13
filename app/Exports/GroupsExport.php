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
        if (!$this->request->has('created_from')) {
            $createdFrom = Group::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.group', [
            'groups' => $groupsQuery,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,

        ]);
    }
}
