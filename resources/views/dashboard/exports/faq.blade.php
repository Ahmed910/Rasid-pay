@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'الأسئلة الشائعة'])
    <tr>
      <th>#</th>
      <th>الحالة</th>
      <th>السؤال</th>
      <th>الإجابة</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($faqs as $faq)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ (bool)$faq->is_active }}</td>
      <td>{{ $faq->question }}</td>
      <td>{{ $faq->answer }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection