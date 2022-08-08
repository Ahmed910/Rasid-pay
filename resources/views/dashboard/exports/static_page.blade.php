@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>trans('dashboard.static_page.static_pages'), 'count' => 4])
    <tr>
      <th>#</th>
      <th>@lang('dashboard.static_page.name')</th>
      <th>@lang('dashboard.static_page.status')</th>
      <th>@lang('dashboard.static_page.in_app')</th>
      <th>@lang('dashboard.static_page.in_website')</th>
      <th>@lang('dashboard.static_page.link')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($static_pages as $static_page)
    <tr>
      <td>{{ $loop->iteration  }}</td>
       <td>{{ $static_page->name ?? '' }}</td>
       <td>
                @if($static_page->is_active)
                <div class="active">
                  <i class="mdi mdi-check-circle-outline"></i>
                  {{ trans('dashboard.static_page.active_cases.1') }}
                </div>
                @else
                <div class="unactive">
                  <i class="mdi mdi-cancel"></i>
                  {{ trans('dashboard.static_page.active_cases.0') }}
                </div>
                @endif
      </td>
      <td>
                @if($static_page->show_in_app)
                <div class="active">
                  <i class="mdi mdi-check-circle-outline"></i>
                  {{ trans('dashboard.static_page.in_app_cases.1') }}
                </div>
                @else
                <div class="unactive">
                  <i class="mdi mdi-cancel"></i>
                  {{ trans('dashboard.static_page.in_app_cases.0') }}
                </div>
                @endif
      </td>
      <td>
                @if($static_page->show_in_website)
                <div class="active">
                  <i class="mdi mdi-check-circle-outline"></i>
                  {{ trans('dashboard.static_page.in_website_cases.1') }}
                </div>
                @else
                <div class="unactive">
                  <i class="mdi mdi-cancel"></i>
                  {{ trans('dashboard.static_page.in_website_cases.0') }}
                </div>
                @endif
      </td>
      <td>{{ $static_page->link ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
