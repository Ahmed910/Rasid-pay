@extends('dashboard.exports.layout')

@section('content')
@include('dashboard.exports.header',['topic'=>trans('dashboard.contact.contact_messages'), 'count' => 5])

<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>@lang('dashboard.contact.user_name')</th>
      <th>@lang('dashboard.contact.email')</th>
      <th>@lang('dashboard.contact.phone')</th>
      <th>@lang('dashboard.contact.title')</th>
      <th>@lang('dashboard.contact.from_app_or_web')</th>
      <th>@lang('dashboard.contact.status')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($contacts as $contact)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $contact->fullname }}</td>
      <td>{{ $contact->email }}</td>
      <td>{{ $contact->phone }}</td>
      <td>{{ $contact->title }}</td>
      <td>{{ trans('dashboard.contact.message_sources.'.$contact->message_source) }}</td>
      <td>{{ trans('dashboard.contact.message_status.'.$contact->message_status) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
