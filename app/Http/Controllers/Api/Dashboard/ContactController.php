<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\ContactExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ContactAdminAssignRequest;
use App\Http\Requests\Dashboard\ContactReplyRequest;
use App\Http\Resources\Api\Dashboard\Contact\ContactCollection;
use App\Http\Resources\Api\Dashboard\ContactReplyResource;
use App\Http\Resources\Api\Dashboard\Contact\ContactResource;
use App\Models\ActivityLog;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\MessageType\MessageType;
use Illuminate\Http\Request;
use App\Services\GeneratePdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Loggable;
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
            ->sortBy($request)
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
        // TODO: check the specified way to send your reply['phone','email','both'] // rasid_support_msgsinbox_reply key
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
        if ((!$request->has('with_activity') || $request->with_activity) && $request->routeIs('*.show')) {
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
        if ($contact->assigned_to_id  == auth()->id()) {
            return response()->json(['data'   => null, 'message' => trans('dashboard.contact.validation.u_cant_assign_this_message'), 'status' => false], 422);
        }
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
        })->findorfail($id);

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

        Loggable::addGlobalActivity(
            Contact::class,
            array_merge(
                $request->query(),
                ['message_types' => MessageType::find($request->message_types)?->pluck('name')?->join(', ')]
            ),
            ActivityLog::EXPORT,
            'index'
        );

        if (!$request->has('created_from')) {
            $createdFrom = Contact::selectRaw('MIN(created_at) as min_created_at')->value('min_created_at');
        }

        $chunk = 200;
        $names = [];
        if (!$ContactsQuery->count()) {
            $file = GeneratePdf::createNewFile(
                trans('dashboard.contact.contact_messages'),
                $createdFrom,'dashboard.exports.contacts',
                $ContactsQuery,0,$chunk,'contacts/pdfs/'
            );
            $file =  url(str_replace(base_path('storage/app/public/'), 'storage/', $file));
            return response()->json([
                'data'   => [
                    'file' => $file
                ],
                'status' => true,
                'message' => ''
            ]);
        }
        foreach (($ContactsQuery->chunk($chunk)) as $key => $rows) {
            $names[] = GeneratePdf::createNewFile(
                trans('dashboard.contact.contact_messages'),$createdFrom,
                'dashboard.exports.contacts',
                $rows,$key,$chunk,'contacts/pdfs/'
            );
        }

        $file = GeneratePdf::mergePdfFiles($names, 'contacts/pdfs/contacts.pdf');

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

        Loggable::addGlobalActivity(
            Contact::class,
            array_merge(
                $request->query(),
                ['message_types' => MessageType::find($request->message_types)?->pluck('name')?->join(', ')]
            ),
            ActivityLog::EXPORT,
            'index'
        );

        return response()->json([
            'data'   => [
                'file' => $file
            ],
            'status' => true,
            'message' => ''
        ]);
    }
}
