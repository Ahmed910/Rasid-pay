@extends('dashboard.layouts.master')

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('dashboard.bank.index') }}">{{ trans('dashboard.bank.sub_progs.index') }}
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            {{ trans('dashboard.bank.sub_progs.show') }}
          </li>
        </ol>
      </nav>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- Row -->
    <div class="card py-7 px-7">
        <div class="row">
            <div class="col-12 col-md-3 mb-5">
                <label> {{trans("dashboard.bank.bank_name")}} </label>
                <p class="text-muted">{{$bank->bank?->name}}</p>
            </div>
            <div class="col-12 col-md-3 mb-5">
                <label>{{trans("dashboard.bank.type")}}</label>
                <p class="text-muted">{{trans('dashboard.bank.types.'.$bank->type)}}  </p>
            </div>
            <div class="col-12 col-md-3 mb-5">
                <label>{{trans("dashboard.bank.code")}}</label>
                <p class="text-muted">{{$bank->code}}</p>
            </div>
            <div class="col-12 col-md-3 mb-5">
                <label>{{trans("dashboard.bank.BranchName")}}</label>
                <p class="text-muted">{{$bank->name}}</p>
            </div>
            <div class="col-12 col-md-3 mb-5">
                <label>{{trans("dashboard.bank.location")}}</label>
                <p class="text-muted">  {{$bank->site}}</p>
            </div>
            <div class="col-12 col-md-3 mb-5">
                <label>{{trans("dashboard.bank.transaction_Value_From")}}</label>
                <p class="text-muted"> {{$bank->transfer_amount}}</p>
            </div>
            <div class="col-12 col-md-3 mb-5">
                <label>{{trans("dashboard.bank.NumberTransactions")}}</label>
                <p class="text-muted">{{$transcount["transcount"]}}</p>
            </div>
            <div class="col-12 col-md-3 mb-5">
                <label>{{trans("dashboard.general.status")}}</label>
                <p class="text-muted"><span class="badge bg-{{ $bank->is_active == 1 ? 'success' : 'danger' }}-opacity py-2 px-4">
                    {{ trans('dashboard.department.active_cases.' . $bank->is_active) }}</span></p>
            </div>
            <div class="col-12 col-md-3 mb-5">
                <label>{{trans("dashboard.bank.commercialRecord")}}</label>
                <p class="text-muted">{{$bank->commercial_record}}</p>
            </div>
            <div class="col-12 col-md-3 mb-5">
                <label>{{trans("dashboard.bank.taxNumber")}}</label>
                <p class="text-muted">{{$bank->tax_number}}</p>
            </div>
            <div class="col-12 col-md-3 mb-5">
                <label> {{trans("dashboard.bank.serviceNumber")}}</label>
                <p class="text-muted">{{$bank->service_customer}}</p>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-12 text-end">
            <a href="{{ route('dashboard.bank.edit',$bank->bank?->id) }}" class="btn btn-primary">
                <i class="mdi mdi-square-edit-outline"></i> {{ trans('dashboard.general.edit') }}
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                <i class="mdi mdi-arrow-left"></i> {{ trans('dashboard.general.back') }}
            </a>
        </div>
    </div>
    <!-- End Row -->


@endsection
@include('dashboard.bank.show_script')
