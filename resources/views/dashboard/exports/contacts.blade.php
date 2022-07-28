@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'صندوق الرسائل'])
    <tr>
      <th>#</th>
      <th>fullname</th>
      <th>email</th>
      <th>phone</th>
      <th>title</th>
      <th>message_source</th>
      <th>message_status</th>
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
      <td>{{ $contact->message_source }}</td>
      <td>{{ $contact->message_status }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
