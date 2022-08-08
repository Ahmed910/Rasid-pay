@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'الصفحات الثابتة', 'count' => 4])
    <tr>
      <th>#</th>
      <th>الحالة</th>
      <th>عرض في app</th>
      <th>عرض في website</th>
      <th>الرابط</th>
      <th>الاسم</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($static_pages as $static_page)
    <tr>
      <td>{{ $loop->iteration  }}</td>
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
      <td>{{ (bool) $static_page->show_in_app ?? '' }}</td>
      <td>{{ (bool) $static_page->show_in_website ?? '' }}</td>
      <td>{{ $static_page->link ?? '' }}</td>
      <td>{{ $static_page->name ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
