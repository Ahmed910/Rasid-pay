<?php

namespace App\Exports;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ContactExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $contactsQuery = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->where(function ($query) {
                $query->where('admin_id', auth()->user()->id)
                    ->orWhere('assigned_to_id', auth()->user()->id);
            });
        })
            ->with('replies', 'user', 'admin', 'activity', 'assignedTo')
            ->CustomDateFromTo($this->request)
            ->search($this->request)
            ->sortby($this->request)
            ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = Contact::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.contacts', [
            'contacts' => $contactsQuery,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
