@extends('dashboard.layouts.master')
@section('title', trans('dashboard.transaction.index'))

@section('content')

  <!-- PAGE-HEADER -->
  <div class="page-header">
    <h1 class="page-title">{{ trans('dashboard.transaction.transactions') }}</h1>
  </div>
  <!-- PAGE-HEADER END -->


  <!-- FORM OPEN -->

  {!! Form::open(['method' => 'GET', 'id' => 'search-form']) !!}
    <div class="row align-items-end mb-3">
      <div class="col-12 col-md-3 mb-3">
        <label for="transactionNum">@lang('dashboard.transaction.transaction_number')</label>
        <input type="number" class="form-control" id="transactionNum" name="transactionNum" placeholder="@lang('dashboard.transaction.transaction_number')"/>
      </div>
      <div class="col-12 col-md-3 mb-3">
        <label for="transactionName">@lang('dashboard.transaction.from_user')</label>
        <input type="text" class="form-control" id="transactionName"  name="transactionName" placeholder="@lang('dashboard.transaction.from_user')"/>
      </div>
      <div class="col-12 col-md-3 mb-3">
        <label for="idNumber">@lang('dashboard.transaction.user_identity')</label>
        <input type="number" class="form-control" id="idNumber" name="idNumber" placeholder="@lang('dashboard.transaction.user_identity')"/>
      </div>
      <div class="col-12 col-md-3 mb-3">
        <label for="clientName">@lang('dashboard.transaction.to_user_client')</label>
          {!! Form::select('to_user_id', ['' => '', -1 => trans('dashboard.general.all_cases')] + $clients, request('to_user_id'), ['class' => 'form-control select2-show-search', 'data-placeholder' => trans('dashboard.transaction.choose_client_name'), 'id' => 'to_user_id']) !!}
      </div>
      <div class="col-12 col-md-3 mb-3">
        <label for="from-hijri-picker-custom"> @lang('dashboard.transaction.transaction_date_from')</label>
        <div class="input-group">
          <input onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false"
                 onDrag="return false" onDrop="return false" autocomplete=off id="from-hijri-picker-custom" type="text"
                 readonly placeholder="@lang('dashboard.general.day_month_year')" class="form-control"
                 name="created_from" value="{{ old('created_from') ?? request('created_from') }}" />
          <div class="input-group-text border-start-0">
            <label for="from-hijri-picker-custom">
              <i class="fa fa-calendar tx-16 lh-0 op-6"></i></label>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-3 mb-3">
        <label for="to-hijri-picker-custom">@lang('dashboard.transaction.transaction_date_to')</label>
        <div class="input-group">
          <input onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false"
                 onDrag="return false" onDrop="return false" autocomplete=off id="to-hijri-picker-custom" type="text"
                 readonly placeholder="@lang('dashboard.general.day_month_year')" class="form-control"
                 name="created_to" value="{{ old('created_to') ?? request('created_to') }}" />
          <div class="input-group-text border-start-0">
            <label for="to-hijri-picker-custom">
              <i class="fa fa-calendar tx-16 lh-0 op-6"></i></label>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-3 mb-3">
        <label for="transactionValueFrom">@lang('dashboard.transaction.transaction_amount_from')</label>
        <div class="input-group">
          <input id="transactionValueFrom" type="number" name="transactionValueFrom" placeholder="@lang('dashboard.transaction.enter_transaction_amount')" class="form-control"/>
          <div class="input-group-text border-start-0">
            ر.س
          </div>
        </div>
      </div>
      <div class="col-12 col-md-3 mb-3">
        <label for="transactionValueTo">@lang('dashboard.transaction.transaction_amount_to')</label>
        <div class="input-group">
          <input id="transactionValueTo" type="number" name="transactionValueTo" placeholder="@lang('dashboard.transaction.enter_transaction_amount')" class="form-control"/>
          <div class="input-group-text border-start-0">
            ر.س
          </div>
        </div>
      </div>
      <div class="col-12 col-md-3 mb-3">
        <label for="transactionType">@lang('dashboard.transaction.transaction_type')</label>

        {!! Form::select('type', ['' => '', -1 => trans('dashboard.general.all_cases')] + trans('dashboard.transaction.type_cases'), request('type'), ['class' => 'form-control select2', 'data-placeholder' => trans('dashboard.general.select_type'), 'id' => 'type']) !!}

      </div>
      <div class="col-12 col-md-3 mb-3">
        <label for="activeCard">@lang('dashboard.transaction.active_card')</label>
        {!! Form::select('card_package_id', ['' => '', -1 => trans('dashboard.general.all_cases')] + $cards, request('card_package_id'), ['class' => 'form-control select2', 'data-placeholder' => trans('dashboard.transaction.choose_card'), 'id' => 'card_package_id']) !!}
      </div>

      <div class="col-12 col-md-3 mb-3">
        <label for="transactionType">@lang('dashboard.transaction.transaction_status')</label>
        {!! Form::select('status', ['' => '', -1 => trans('dashboard.general.all_cases')] + trans('dashboard.transaction.status_cases'), request('status'), ['class' => 'form-control select2', 'data-placeholder' => trans('dashboard.general.select_status'), 'id' => 'status']) !!}

    </div>
  <div class="row">
    <div class="col-12 col-md-6 my-2">
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-tray-arrow-down"></i>
          @lang('dashboard.general.export')
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li><a class="dropdown-item" href="#">PDF</a></li>
          <li><a class="dropdown-item" href="#">Excel</a></li>
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-6 my-2 d-flex justify-content-end">

      <button class="btn btn-primary mx-2" type="submit">
        <i class="mdi mdi-magnify"></i> {{ trans('dashboard.general.search') }}
      </button>

      <button class="btn btn-outline-primary" type="reset" id="reset">
        <i class="mdi mdi-restore"></i>{{ trans('dashboard.general.show_all') }}
      </button>
    </div>
  </div>
  {!! form::close() !!}

  <!-- FORM CLOSED -->

  <!-- Row -->
  <div class="row row-sm">
    <div class="col-lg-12">
      <div class="p-1">
        <table id="transactionsTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
          <thead>
          <tr>
            <th class="border-bottom-0">#</th>
            <th class="border-bottom-0">{{ trans('dashboard.transaction.transaction_number') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.transaction.transaction_date') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.transaction.from_user') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.transaction.user_identity') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.transaction.to_user_client') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.transaction.transaction_amount') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.transaction.total_amount') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.transaction.gift_balance') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.transaction.transaction_type') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.transaction.transaction_status') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.transaction.active_card') }}</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- End Row -->


  @include('dashboard.layouts.modals.archive')
  @include('dashboard.layouts.modals.not_archive')
@endsection
@include('dashboard.transaction.script')
