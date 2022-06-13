@extends('dashboard.layouts.master')

@section('title', trans('dashboard.admin.sub_progs.show'))

@section('content')

  <!-- PAGE-HEADER -->
  <div class="page-header">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin.index') }}">
            @lang('dashboard.admin.sub_progs.index')</a></li>
        <li class="breadcrumb-item active" aria-current="page">
          @lang('dashboard.admin.sub_progs.show') </li>
      </ol>
    </nav>

  </div>
  <!-- PAGE-HEADER END -->
  <!-- Row -->
  <div class="card py-7 px-7">
    <div class="row mb-5">
      <div class="col-12 col-md-3">
        <label>{{ trans('dashboard.admin.admin') }} :</label>
        <p class="text-muted">{{ $admin->fullname }}</p>
      </div>
      <div class="col-12 col-md-3">
        <label> {{ trans('dashboard.admin.login_id') }}:</label>
        <p class="text-muted">{{ $admin->login_id }}</p>
      </div>
      <div class="col-12 col-md-3">
        <label> {{ trans('dashboard.rasid_job.job_name') }}:</label>
        <p class="text-muted">{{ $admin->employee?->job?->name }}</p>
      </div>
      <div class="col-12 col-md-3">
        <label> {{ trans('dashboard.general.phone') }}:</label>
        <p class="text-muted">{{ $admin->phone }}</p>
      </div>
      <div class="col-12 col-md-3">
        <label> {{ trans('dashboard.general.email') }}:</label>
        <p class="text-muted">{{ $admin->email }}</p>
      </div>
      <div class="col-12 col-md-3">
        <label>@lang('dashboard.department.department') :</label>
        <p class="text-muted">

          {!! $admin->department->name ?? trans('dashboard.department.without_parent') !!}</p>
      </div>
      <div class="col-12 col-md-3">
        <label class="d-block" for="departmentName">@lang('dashboard.general.status') :</label>
        @if ($admin->ban_status == 'active')
          <p class="badge bg-success-opacity py-2 px-4">@lang('dashboard.admin.active_cases.'.$admin->ban_status)</p>
        @else
          <p class="badge bg-danger-opacity py-2 px-4">@lang('dashboard.admin.active_cases.'.$admin->ban_status)
            @if($admin?->ban_from)
              <i class="mdi mdi-calendar" data-bs-toggle="popoverRoles" tabindex="1"
                 data-bs-placement="right" data-bs-html="true"
                 title="<span class='tooltipRole'>{{ trans('dashboard.datatable.from')." : ".$admin?->ban_from }}
                   <br><br> {{trans('dashboard.datatable.to')." : ". $admin?->ban_to }}
                   </span>">
              </i>
            @endif
          </p>
        @endif

      </div>
      <div class="col-12 col-md-9 permissions">
        <label class="d-block" for="departmentName"> {{ trans('dashboard.group.chosen_groups') }}:</label>
        @foreach ($admin->groups as $group)
          <span class="badge bg-primary-opacity d-inline-flex align-items-center py-2 px-4">
                        {{ $group->name }}
            @if ($group->permissions()->exists())
              @foreach ($group->permissions as $permission)
                <i class="mdi mdi-clipboard-list" data-bs-toggle="popoverRoles" tabindex="1"
                   data-bs-placement="right" data-bs-html="true"
                   title="<span class='tooltipRole'> {{ $permission->name ?? '' }}</span>"></i
                                    @endforeach
                                >
                @endif
                    </span>
        @endforeach
      </div>
      <div class="col-12 col-md-3 d-flex align-items-end">

        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                 {{ $admin->is_login_code ? 'checked' : '' }} disabled/>
          <label class="form-check-label" for="flexCheckDefault">
            {{ trans('dashboard.general.Send VerificationCode') }}
          </label>
        </div>
      </div>
    </div>

  </div>
  <div class="row">
    <div class="col-12 text-end">
      <a href="{{ route('dashboard.admin.edit', $admin) }}" class="btn btn-primary">
        <i class="mdi mdi-square-edit-outline"></i>{{ trans('dashboard.general.edit') }}
      </a>
      <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
        <i class="mdi mdi-arrow-left"></i>{{ trans('dashboard.general.back') }}
      </a>
    </div>
  </div>
  <!-- End Row -->
  <label>{{ trans('dashboard.activity_log.history') }} </label>
  <div class="p-1">
    <table id="historyTableadmin" class="table table-bordered text-wrap shadow-sm bg-body key-buttons historyTable">
      <thead>
      <tr>
        <th class="border-bottom-0">#</th>
        <th class="border-bottom-0"> {{ trans('dashboard.general.done_by') }}</th>
        <th class="border-bottom-0">{{ trans('dashboard.department.department_name') }} </th>
        <th class="border-bottom-0">{{ trans('dashboard.activity_log.date') }} </th>
        <th class="border-bottom-0">{{ trans('dashboard.activity_log.activity') }}</th>
        {{-- <th class="border-bottom-0">{{ trans('dashboard.general.reason') }}</th> --}}
      </tr>
      </thead>
    </table>
  </div>
  <!-- Row -->
@endsection
@include('dashboard.admin.show_script')
