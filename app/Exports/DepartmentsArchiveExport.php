<?php

namespace App\Exports;

use App\Models\Department\Department;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DepartmentsArchiveExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {

        $departments_archiveQuery = Department::onlyTrashed()
            ->search($this->request)
            ->CustomDateFromTo($this->request)
            ->searchDeletedAtFromTo($this->request)
            ->with('parent.translations')
            ->ListsTranslations('name')
            ->addSelect('departments.deleted_at', 'departments.parent_id')
            ->sortBy($this->request)
            ->get();

            if (!$this->request->has('created_from')) {
                $createdFrom = Department::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
            }

        return view('dashboard.exports.archive.department', [
            'departments_archive' => $departments_archiveQuery,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
