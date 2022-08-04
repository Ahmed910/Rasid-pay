<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Exports\ContactExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Dashboard\ContactAdminAssignRequest;
use App\Http\Requests\V1\Dashboard\ContactReplyRequest;
use App\Http\Resources\Dashboard\Contact\ContactCollection;
use App\Http\Resources\Dashboard\ContactReplyResource;
use App\Http\Resources\Dashboard\Contact\ContactResource;
use App\Models\ActivityLog;
use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->where(function ($query) {
                $query->where('admin_id', auth()->user()->id)
                    ->orWhere('assigned_to_id', auth()->user()->id);
            });
        })
            ->with('replies', 'user', 'admin', 'activity', 'assignedTo')
            ->customDateFromTo($request)
            ->search($request)
            ->sortby($request)
            ->paginate((int)($request->per_page ?? config("globals.per_page")));
        return ContactResource::collection($contacts)
            ->additional([
                'status' => true,
                'message' => ''
            ]);
    }


    public function reply(ContactReplyRequest $request, ContactReply $contactReply)
    {

        $contact = Contact::findorfail($request['contact_id']);

        if ($contact->replies()->exists()) {
            return response()->json([
                'status' => false,
                'message' => trans('dashboard.contact.replied'),
                'data' => null
            ], 422);
        }

        $contactReply->fill($request->validated() + ['added_by_id' => auth()->id()])->save();
        $contactReply->contact->update(["message_status" => Contact::REPLIED]);
        // TODO: Send to user email
        return ContactReplyResource::make($contactReply->load('contact', 'admin'))
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_add')
            ]);
    }

    public function show(Request $request, $id)
    {
        $contact = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->where(function ($query) {
                $query->where('admin_id', auth()->user()->id)
                    ->orWhere('assigned_to_id', auth()->user()->id);
            });
        })->when($request['is_reply'], function ($q) {

            $q->where('message_status', "<>", Contact::REPLIED);
        })
            ->with('replies', 'user', 'admin', 'activity', 'assignedTo')
            ->withTrashed()
            ->findOrFail($id);

        if ($contact->message_status == Contact::PENDING) {
            $contact->update([
                'read_at' =>  now(),
                "message_status" => Contact::WAITING,
                'updated_at' => now()
            ]);
        }

        $activities = [];
        if (!$request->has('with_activity') || $request->with_activity) {
            $activities  = $contact->activity()
                ->sortBy($request)
                ->paginate((int)($request->per_page ??  config("globals.per_page")));
        }

        return ContactCollection::make($activities)
            ->additional([
                'status' => true,
                'message' => trans("dashboard.general.show")
            ]);
    }

    public function assignContact(ContactAdminAssignRequest $request, Contact $contact)
    {
        $contact->update($request->validated());
        $contact->addUserActivity($contact, ActivityLog::ASSIGNED, 'index');

        return ContactResource::make($contact->load("admin"))
            ->additional([
                'status' => true,
                'message' => trans('dashboard.general.success_message_forwareded')
            ]);
    }

    public function deleteContact($id)
    {
        $contact = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->whereHas('messageType.admins', function ($query) {
                $query->where('admin_id', auth()->user()->id);
            });
        })->findorfail($id);
        $contact->delete();
        return response()->json([
            'status' => true,
            'message' => trans('dashboard.general.success_archive'),
            'data' => null
        ]);
    }

    public function deleteReply($id)
    {
        $contact = ContactReply::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->whereHas('contact.messageType.admins', function ($query) {
                $query->where('admin_id', auth()->user()->id);
            });
        })
            ->findorfail($id);
        $contact->delete();
        return response()->json([
            'status' => true,
            'message' => trans('dashboard.general.success_archive'),
            'data' => null
        ]);
    }

    public function exportPDF(Request $request, GeneratePdf $pdfGenerate)
    {
        $ContactsQuery = Contact::when(auth()->user()->user_type == 'admin', function ($q) {
            $q->where(function ($query) {
                $query->where('admin_id', auth()->user()->id)
                    ->orWhere('assigned_to_id', auth()->user()->id);
            });
        })
            ->with('replies', 'user', 'admin', 'activity', 'assignedTo')
            ->customDateFromTo($request)
            ->search($request)
            ->sortby($request)
        ->get();


        if (!$request->has('created_from')) {
            $createdFrom = Contact::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $mpdfPath = $pdfGenerate->newFile()
            ->view(
                'dashboard.exports.contacts',
                [
                    'contacts' => $ContactsQuery,
                    'date_from'   => format_date($request->created_from) ?? format_date($createdFrom),
                    'date_to'     => format_date($request->created_to) ?? format_date(now()),
                    'userId'      => auth()->user()->login_id,

                ]
            )
            ->storeOnLocal('Contacts/pdfs/');
        $file  = url('/storage/' . $mpdfPath);

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }

    public function exportExcel(Request $request)
    {
        $fileName = uniqid() . time();
        Excel::store(new ContactExport($request), 'Contacts/excels/' . $fileName . '.xlsx', 'public');
        $file = url('/storage/' . 'Contacts/excels/' . $fileName . '.xlsx');

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
