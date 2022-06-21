@extends('dashboard.layouts.master')
@section('title', trans('dashboard.client.sub_progs.index'))

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
  <h1 class="page-title">{{ trans('dashboard.client.sub_progs.index') }}</h1>
  <a href="{!! route('dashboard.client.create') !!}" class="btn btn-primary">
    <i class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.client.sub_progs.create') }}
  </a>
</div>
<!-- PAGE-HEADER END -->
<!-- FORM OPEN -->
{!! Form::open(['method' => 'GET', 'id' => 'client-search']) !!}
<div class="row align-items-end mb-3">
  <div class="col-12 col-md-3 mb-3">
    <label for="clientName">{{trans("dashboard.client.name")}}</label>
    <input type="text" class=" form-control input-regex stop-copy-paste" id="clientName" placeholder="{{trans("
      dashboard.client.name")}}" name="fullname" />
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="clientType">{{trans("dashboard.client.type")}}</label>
    {!! Form::select('client_type', ['' => "", -1 => trans('dashboard.general.all_cases') ]+$client_types,
    request('client_type'), ['class' => 'form-control select2-show-search', 'data-placeholder' =>
    trans('dashboard.client.select_client'), 'id' => 'client_type']) !!}
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="transactionFrom"> {{trans("dashboard.client.commercial_number")}}</label>
    <input type="number" class="form-control input-regex stop-copy-paste" id="commercial_number" placeholder="{{trans("
      dashboard.client.commercial_number")}}" name="commercial_number" />
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="transactionTo"> {{trans("dashboard.client.tax_number")}}</label>
    <input type="number" class="form-control input-regex stop-copy-paste" id="tax_number" placeholder="{{trans("
      dashboard.client.tax_number")}}" name="tax_number" />
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="transactionFrom">{{trans("dashboard.client.transactions_done_from")}} </label>
    <input type="number" class="form-control" id="transactionFrom" placeholder="0" />
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="transactionTo">{{trans("dashboard.client.transactions_done_to")}}</label>
    <input type="number" class="form-control" id="transactionTo" placeholder="" />
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="bankName"> {{trans("dashboard.client.bank_name")}} </label>
    <select class="form-control select2-show-search" id="bank_id">
      <option selected disabled value=""> {{trans("dashboard.bank.select_bank")}}</option>
      <option value=-1>{{trans('dashboard.general.all_cases')}}</option>
      @foreach($banks as $key=>$bank)
      <option value="{{$key}}">{{$bank}}</option>
      @endforeach
    </select>
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="bankStatus"> {{trans("dashboard.client.account_status")}} </label>
    <select class="form-control select2-show-search" id="account_status">
      <option selected value=""> {{trans("dashboard.general.select_status")}} </option>
      <option value=-1>{{trans('dashboard.general.all_cases')}}</option>
      <option value="accepted">تم تاكيد الحساب البنكى</option>
      <option value="pending">لم يتم تأكيد الحسب البنكي</option>
      <option value="reviewed">تم مراجعة الحساب البنكي</option>
    </select>
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="from-hijri-picker-custom"> {{trans("dashboard.client.transactions_done_from_date")}}</label>
    <div class="input-group">
      <input id="from-hijri-picker-custom" type="text" placeholder="يوم/شهر/سنة" class="form-control" />
      <div class="input-group-text border-start-0">
        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="to-hijri-picker-custom">{{trans("dashboard.client.transactions_done_to_date")}}</label>
    <div class="input-group">
      <input id="to-hijri-picker-custom" type="text" placeholder="يوم/شهر/سنة" class="form-control" />
      <div class="input-group-text border-start-0">
        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 col-md-6">
    <div class="dropdown">
      <button class="btn btn-outline-primary dropdown-toggle exportBtn" type="button" id="dropdownMenuButton1"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="mdi mdi-tray-arrow-down"></i> تصدير
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item" href="#">PDF</a></li>
        <li><a class="dropdown-item" href="#">Excel</a></li>
      </ul>
    </div>
  </div>
  <div class="col-12 col-md-6 d-flex justify-content-end">
    <button class="btn btn-primary me-2" type="submit">
      <i class="mdi mdi-magnify"></i> بحث
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
      <table id="clientTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
        <thead>
          <tr>
            <th class="border-bottom-0">#</th>
            <th class="border-bottom-0">{{ trans('dashboard.client.name') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.client.type') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.client.commercial_number') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.client.tax_number') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.client.transactions_done') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.client.bank_name') }}</th>
            <th class="border-bottom-0">{{ trans('dashboard.client.account_status') }}</th>
            <th class="border-bottom-0 text-center">{{ trans('dashboard.general.actions') }}</th>
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
@include('dashboard.client.script')
