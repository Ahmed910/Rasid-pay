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
      <td>
        @if($faq->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.faq.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.faq.active_cases.0') }}
        </div>
        @endif
      </td>
      <td>{{ $faq->question }}</td>
      <td>{{ $faq->answer }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
