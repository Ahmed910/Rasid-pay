@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'الصفحات الثابتة'])
    <tr>
      <th>#</th>
      <th>is_active</th>
      <th>show_in_app</th>
      <th>show_in_website</th>
      <th>link</th>
      <th>name</th>
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
