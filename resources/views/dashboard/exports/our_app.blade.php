@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'تطبيقاتنا', 'count' => 3])
    <tr>
      <th>#</th>
      <th>الحالة</th>
      <th>رابط الاندرويد</th>
      <th>رابط الios</th>
      <th>name</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($ourApps as $our_app)
    <tr>
      <td>{{ $loop->iteration  }}</td>
      <td>
                @if($our_app->is_active)
                <div class="active">
                  <i class="mdi mdi-check-circle-outline"></i>
                  {{ trans('dashboard.our_app.active_cases.1') }}
                </div>
                @else
                <div class="unactive">
                  <i class="mdi mdi-cancel"></i>
                  {{ trans('dashboard.our_app.active_cases.0') }}
                </div>
                @endif
      </td>
      <td>{{ $our_app->android_link ?? '' }}</td>
      <td>{{ $our_app->ios_link ?? '' }}</td>
      <td>{{ $our_app->name ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
