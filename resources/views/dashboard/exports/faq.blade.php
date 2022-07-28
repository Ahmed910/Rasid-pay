@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'الأسئلة الشائعة'])
    <tr>
      <th>#</th>
      <th>is_active</th>
      <th>name</th>
      <th>name</th>
      <th>question</th>
      <th>answer</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($faqs as $faq)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $faq->is_active }}</td>
      <td>{{ $faq->name }}</td>
      <td>{{ $faq->question }}</td>
      <td>{{ $faq->answer }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
