@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>@lang('dashboard.contact.user_name')</th>
      <th>@lang('dashboard.contact.phone')</th>
      <th>@lang('dashboard.contact.message_type')</th>
      <th>@lang('dashboard.contact.email')</th>
      <th>@lang('dashboard.contact.employee_names')</th>
      <th>@lang('dashboard.contact.from_app_or_web')</th>
      <th>@lang('dashboard.contact.status')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $contact)
    <tr>
      <td>{{ isset($key) ? $loop->iteration + ($key * $chunk) : $loop->iteration }}</td>
      <td>{{ $contact->fullname }}</td>
      <td>{{ $contact->phone }}</td>
      <td>{{ $contact->messageType?->name }}</td>
      <td>{{ $contact->email }}</td>
      <td>{{ $contact->assignedTo?->fullname?? $contact->admin?->fullname?? ''}}</td>
      <td>{{ trans('dashboard.contact.message_sources.'.$contact->message_source) }}</td>
      <td>{{ trans('dashboard.contact.message_status.'.$contact->message_status) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
