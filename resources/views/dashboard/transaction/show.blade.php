@extends('dashboard.layouts.master')

@section('content')
  <!-- PAGE-HEADER -->
  <div class="page-header">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.transaction.index') }}">
            {{ trans('dashboard.transaction.sub_progs.index') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">
          {{ trans('dashboard.transaction.sub_progs.show') }} </li>
      </ol>
    </nav>

  </div>
  <!-- PAGE-HEADER END -->


  <!-- Row -->
  <div class="card py-7 px-7">
    <div class="row">
      <div class="col-12 col-md-4">
        <label>{{ trans('dashboard.transaction.transaction_number') }} :</label>
        <p class="text-muted"> {!! $transaction->trans_number !!}</p>
      </div>
    </div>

  </div>
  <div class="row">
    <div class="col-12 text-end">
      <a href="{{ route('dashboard.transaction.index') }}" class="btn btn-outline-primary">
        <i class="mdi mdi-arrow-left"></i> {{ trans('dashboard.general.back') }}
      </a>
    </div>
  </div>
  <!-- End Row -->

  <!-- Row -->
  <label> {{ trans('dashboard.activity_log.history') }} </label>
  <div class="p-1">
    <table id="historyTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons historyTable">
      <thead>
      <tr>
        <th class="border-bottom-0">#</th>
        <th class="border-bottom-0">{{ trans('dashboard.general.done_by') }} </th>
        <th class="border-bottom-0">{{ trans('dashboard.activity_log.date') }} </th>
        <th class="border-bottom-0">{{ trans('dashboard.activity_log.activity') }}</th>
        <th class="border-bottom-0">{{ trans('dashboard.general.reason') }}
        </th>
      </tr>
      </thead>
    </table>
  </div>
@endsection
@include('dashboard.transaction.show_script')
