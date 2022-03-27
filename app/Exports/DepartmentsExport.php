<?php

namespace App\Exports;

use App\Models\Department\Department;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
// use Illuminate\Support\Collection;

class DepartmentsExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $departmentsQuery = Department::search($this->request)
            ->CustomDateFromTo($this->request)
            ->with('parent.translations')
            ->ListsTranslations('name')
            ->addSelect('departments.created_at', 'departments.is_active', 'departments.parent_id', 'departments.added_by_id')->get();

        return view('dashboard.department.export', [
            'departments' => $departmentsQuery
        ]);
    }
}
