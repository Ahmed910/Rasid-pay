<?php

namespace App\Exports;

use App\Models\Department\Department;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DepartmentsArchiveExport implements FromView, ShouldAutoSize, WithEvents
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

        $departments_archiveQuery = Department::onlyTrashed()
            ->search($this->request)
            ->customDateFromTo($this->request)
            ->customDateFromTo($this->request, 'deleted_at', 'deleted_from', 'deleted_to')
            ->with('parent.translations')
            ->ListsTranslations('name')
            ->addSelect('departments.created_at', 'departments.deleted_at', 'departments.is_active', 'departments.parent_id', 'departments.added_by_id')
            ->sortBy($this->request)
            ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = Department::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.archive.department', [
            'rows' => $departments_archiveQuery,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
