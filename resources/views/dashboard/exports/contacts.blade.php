@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'صندوق الرسائل', 'count' => 5])
    <tr>
      <th>#</th>
      <th>الاسم</th>
      <th>البريد الالكتروني</th>
      <th>رقم الهاتف</th>
      <th>العنوان</th>
      <th>مصدر الرسالة</th>
      <th>حالة الرسالة</th>
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
