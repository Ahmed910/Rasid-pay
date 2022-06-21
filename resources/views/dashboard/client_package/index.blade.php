@extends('dashboard.layouts.master')
@section('title', trans('dashboard.package.cards_discount_records'))

@section('content')


<!-- PAGE-HEADER -->
<div class="page-header">
  <h1 class="page-title">@lang('dashboard.package.cards_discount_records')</h1>
  <a href="{{ route('dashboard.client_package.create') }}" class="btn btn-primary">
    <i class="mdi mdi-plus-circle-outline"></i>@lang('dashboard.package.add')
  </a>
</div>
<!-- PAGE-HEADER END -->


<!-- FORM OPEN -->
<form method="get" action=""  id="search-form">
  <div class="row align-items-end mb-3">
    <div class="col-12 col-md-12 mb-3">
      <label for="clientName">@lang('dashboard.package.client_name')</label>
      {!! Form::select('client_id', ['' => '', -1 => trans('dashboard.general.all_cases')] +
     $clients->toArray(), request('client_id'), ['class' => 'form-control select2',
      'data-placeholder' => trans('dashboard.package.select_client_name'), 'id' => 'client_id']) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-6 my-2">
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle exportBtn" type="button" id="dropdownMenuButton1"
          data-bs-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-tray-arrow-down"></i> @lang('dashboard.general.export')
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li><a class="dropdown-item"
            href="{{ url(app()->getLocale().'/dashboard/client_package/exportPDF')  }}"
            target="_blank">PDF</a></li>
    <li><a class="dropdown-item"
            href="{{ url(app()->getLocale().'/dashboard/client_package/export') }}"
            target="_blank">Excel</a></li>
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-6 my-2 d-flex justify-content-end">
      <button class="btn btn-primary me-2" type="submit">
        <i class="mdi mdi-magnify"></i> @lang('dashboard.general.search')
      </button>
      <button class="btn btn-outline-primary" type="reset" id="reset">
      <i class="mdi mdi-restore"></i>{{ trans('dashboard.general.show_all') }}
    </button>
    </div>
  </div>
</form>
<!-- FORM CLOSED -->

<!-- Row -->
<div class="row row-sm">
  <div class="col-lg-12">
    <div class="p-1">
        <table id="package-table"
          class="table table-bordered text-nowrap shadow-sm bg-body key-buttons historyTable">
          <thead>
            <tr>
              <th class="border-bottom-0">#</th>
              <th class="border-bottom-0">@lang('dashboard.package.client_name')</th>
              <th class="border-bottom-0">@lang('dashboard.package.basic_card')</th>
              <th class="border-bottom-0">@lang('dashboard.package.golden_card')</th>
              <th class="border-bottom-0">@lang('dashboard.package.platinum_card')</th>
              <th class="border-bottom-0">@lang('dashboard.general.actions')</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    </div>
  </div>
</div>
<!-- End Row -->

@include('dashboard.layouts.modals.alert')

@endsection
@include('dashboard.client_package.script')
