@extends('dashboard.layouts.master')
@include('dashboard.group.style')

@section('nav-title')
@endsection
@section('content')
    <div class="page-header">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.group.index') }}">@lang('dashboard.group.groups')</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @lang('dashboard.group.show_group')
                </li>
            </ol>
        </nav>
    </div>
    <div class="card py-7 px-7">
        <div class="row">
            <div class="col-12 col-md-3">
                <label>@lang('dashboard.group.group_name'):</label>
                <p class="text-muted">{{ $group->name ?? '' }}</p>
            </div>
            <div class="col-12 col-md-3">
                <label class="d-block" for="departmentName">@lang('dashboard.general.status'):</label>
                <p class="badge bg-{{ $group->is_active ? 'success' : 'danger' }}-opacity py-2 px-4">
                    {{ $group->is_active ? trans('dashboard.general.active') : trans('dashboard.general.inactive') }}
                </p>
            </div>
            <div class="col-12 col-md-3">
                <label>@lang('dashboard.group.admins_count'):</label>
                <p class="text-muted">{{ $group->admins_count ?? 0 }}</p>
            </div>
            <div class="col-12 col-md-3">
                <label>@lang('dashboard.general.created_by'):</label>
                <p class="text-muted">{{ $group->addedBy->fullname ?? '' }}</p>
            </div>
        </div>
    </div>
    <label>@lang('dashboard.group.group_data')</label>
    <div class="table-responsive p-1">
        <table id="groupTable" class="table table-bordered text-nowrap shadow-sm bg-body key-buttons historyTable">
            <thead>
                <tr>
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">@lang('dashboard.permission.name')</th>
                    <th class="border-bottom-0">@lang('dashboard.group.main_program')</th>
                    <th class="border-bottom-0">@lang('dashboard.group.sub_program')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupsData as $groupData)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ $groupData['name'] ?? '' }}
                        </td>
                        <td>
                            {{ $groupData['main_prog'] ?? '' }}
                        </td>
                        <td>
                            {{ $groupData['sub_prog'] ?? '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-5">
        <div class="col-12 text-end">
            <a href="{{ route('dashboard.group.edit', $group) }}" class="btn btn-primary">
                <i class="mdi mdi-square-edit-outline"></i>
                @lang('dashboard.general.edit')
            </a>
            <a href="{{ route('dashboard.group.index') }}" class="btn btn-outline-primary">
                <i class="mdi mdi-arrow-left"></i>
                @lang('dashboard.general.back')
            </a>
        </div>
    </div>
    <label>@lang('dashboard.activity_log.history')</label>
    <div class="table-responsive p-1">
        <table id="activityTable" class="table table-bordered text-nowrap shadow-sm bg-body key-buttons historyTable">
            <thead>
                <tr>
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">@lang('dashboard.general.done_by')</th>
                    <th class="border-bottom-0">@lang('dashboard.department.department_name')</th>
                    <th class="border-bottom-0">@lang('dashboard.activity_log.date')</th>
                    <th class="border-bottom-0">@lang('dashboard.activity_log.activity')</th>
                    <th class="border-bottom-0">@lang('dashboard.general.reason')</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection
@include('dashboard.group.show_script')
