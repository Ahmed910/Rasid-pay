@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>trans('dashboard.faq.faqs'), 'count' => 2])
    <tr>
      <th>#</th>
      <th>@lang('dashboard.faq.question')</th>
      <th>@lang('dashboard.faq.answer')</th>
      <th>@lang('dashboard.faq.status')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($faqs as $faq)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $faq->question }}</td>
      <td>{{ $faq->answer }}</td>
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

    </tr>
    @endforeach
  </tbody>
</table>

@endsection
