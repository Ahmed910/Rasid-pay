@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'الصفحات الثابتة'])
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
      <td>{{ $static_page->is_active ?? '' }}</td>
      <td>{{ $static_page->show_in_app ?? '' }}</td>
      <td>{{ $static_page->show_in_website ?? '' }}</td>
      <td>{{ $static_page->link ?? '' }}</td>
      <td>{{ $static_page->name ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
