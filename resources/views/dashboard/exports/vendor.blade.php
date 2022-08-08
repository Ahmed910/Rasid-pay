@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'العملاء', 'count' => 5])
    <tr>
      <th>#</th>
      <th>عدد الفروع</th>
      <th>اسم الفرع</th>
      <th>نوع الفرع</th>
      <th>السجل التجاري</th>
      <th>الرقم الضريبي</th>
      <th>الحالة</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($vendors as $vendor)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $vendor->branches_count ?? '' }}</td>
      <td>{{ $vendor->name ?? '' }}</td>
      <td>{{ $vendor->type ?? '' }}</td>
      <td>{{ $vendor->commercial_record ?? '' }}</td>
      <td>{{ $vendor->tax_number ?? '' }}</td>
       <td>
        @if($vendor->is_active)
        <div class="active">
          <i class="mdi mdi-check-circle-outline"></i>
          {{ trans('dashboard.vendor.active_cases.1') }}
        </div>
        @else
        <div class="unactive">
          <i class="mdi mdi-cancel"></i>
          {{ trans('dashboard.vendor.active_cases.0') }}
        </div>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
