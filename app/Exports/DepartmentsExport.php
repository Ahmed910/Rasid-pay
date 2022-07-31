<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use App\Models\Department\Department;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DepartmentsExport implements FromView, ShouldAutoSize, WithEvents
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

        $departmentsQuery = Department::search($this->request)
            ->CustomDateFromTo($this->request)
            ->with('parent.translations')
            ->sortBy($this->request)
            ->ListsTranslations('name')
            ->addSelect('departments.created_at', 'departments.is_active', 'departments.parent_id', 'departments.added_by_id')->get();
            if (!$this->request->has('created_from')) {
                $createdFrom = Department::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
            }
        return view('dashboard.exports.department', [
            'departments' => $departmentsQuery,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
