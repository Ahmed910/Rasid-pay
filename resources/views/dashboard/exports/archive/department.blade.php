@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
    <thead>
        @include('dashboard.exports.header',['topic'=>'أرشيف الأقسام'])

        <tr>
            <th>#</th>
            <th>
                @lang('dashboard.department.department')</th>
            <th>
                @lang('dashboard.department.main_department')</th>
            <th>
                @lang('dashboard.department.archived_at')</th>
            <th>
                @lang('dashboard.general.status')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($departments_archive as $department)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $department->name }}</td>
            <td>{{ @$department->parent->name ?? trans('dashboard.department.without_parent') }}</td>
            <td>{{ $department->deleted_at }}</td>
            <td>
                {{ $department->is_active ? trans('dashboard.general.active') : trans('dashboard.general.inactive') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
