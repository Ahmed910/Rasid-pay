@extends('dashboard.exports.layout')

@section('content')
    <table id="departmentTable" class="table">
        <thead>
            @include('dashboard.exports.header', ['topic' => trans('dashboard.citizen.citizens'), 'count' => 5])
            <tr>
                <th>#</th>
                <th>@lang('dashboard.citizen.name')</th>
                <th>@lang('dashboard.citizen.identity_number')</th>
                <th>@lang('dashboard.citizen.status')</th>
                <th>@lang('dashboard.citizen.enabled_package')</th>
                <th>@lang('dashboard.citizen.start_time')</th>
                <th>@lang('dashboard.citizen.end_time')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citizens as $citizen)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $citizen?->user?->fullname }}</td>
                    <td>{{ $citizen?->user?->identity_number }}</td>

                    @php
                        $ban_status = match ($citizen?->user?->ban_status) { 'active' => trans('dashboard.admin.active_cases.active'),  'permanent' => trans('dashboard.admin.active_cases.permanent'),  'temporary' => trans('dashboard.admin.active_cases.temporary'),  'exceeded_attempts' => trans('dashboard.admin.active_cases.exceeded_attempts') };
                    @endphp

                    <td>
                        @if ($citizen?->user?->ban_status == 'active')
                            <div class="active">
                                <i class="mdi mdi-check-circle-outline"></i>
                                {{ $ban_status }}
                            </div>
                        @else
                            <div class="unactive">
                                <i class="mdi mdi-cancel"></i>
                                {{ $ban_status }}
                            </div>
                        @endif
                    </td>
                    <td>{{ trans('dashboard.package_types.' . $citizen?->enabledPackage?->package_type) }}</td>
                    <td>{{ $citizen?->enabledPackage?->start_at_dashboard }}</td>
                    <td>{{ $citizen?->enabledPackage?->end_at_dashboard }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
