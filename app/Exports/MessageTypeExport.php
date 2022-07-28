<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\Locale\Locale;
use App\Models\MessageType\MessageType;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MessageTypeExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $messageTypes = MessageType::ListsTranslations('name')
            ->addSelect('created_at', 'is_active')
            ->withCount('admins')
            ->search($this->request)
            ->CustomDateFromTo($this->request)
            ->sortBy($this->request)
            ->get();

        if (!$this->request->has('created_from')) {
            $createdFrom = Locale::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        return view('dashboard.exports.message_type', [
            'message_types' => $messageTypes,
            'date_from'   => format_date($this->request->created_from) ?? format_date($createdFrom),
            'date_to'     => format_date($this->request->created_to) ?? format_date(now()),
            'userId'      => auth()->user()->login_id,
        ]);
    }
}
