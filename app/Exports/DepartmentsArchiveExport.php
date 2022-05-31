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
            ->get();

        return view('dashboard.exports.archive.department', [
            'departments_archive' => $departments_archiveQuery
        ]);
    }
}
