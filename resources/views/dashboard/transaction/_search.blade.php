<!-- FORM OPEN -->

{!! Form::open(['method' => 'GET', 'id' => 'search-form']) !!}
<div class="row align-items-end mb-3">
  <div class="col-12 col-md-3 mb-3">
    <label for="transactionNum">@lang('dashboard.transaction.transaction_number')</label>
    <input type="number" class="form-control stop-copy-paste" id="transactionNum" name="transaction_number"  oninput = 'javascript: if
      (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);' min ='0',
      maxlength = '10' onkeypress = 'return /[0-9]/i.test(event.key)' onDrag="return false" onDrop="return false" placeholder="@lang('dashboard.transaction.enter_transaction_number')"/>
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="transactionName">@lang('dashboard.transaction.to_user_client')</label>
    <input type="text" class="form-control input-regex stop-copy-paste" id="transactionName"  oninput = 'javascript: if
      (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);' min ='1',
      maxlength = '100'onDrag="return false" onDrop="return false"  name="citizen" placeholder="@lang('dashboard.transaction.enter_from_user')"/>
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
    <label for="transactionType">@lang('dashboard.transaction.transaction_type')</label>

    {!! Form::select('type', ['' => '', -1 => trans('dashboard.general.all_cases')] + trans('dashboard.transaction.type_cases'), request('type'), ['class' => 'form-control select2', 'data-placeholder' => trans('dashboard.general.select_type'), 'id' => 'type']) !!}

  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="activeCard">@lang('dashboard.transaction.active_card')</label>
    {!! Form::select('enabled_package[]', [-1 => trans('dashboard.general.all_cases')] + $packages, request('enabled_package'), ['class' => 'form-control select2', 'data-placeholder' => trans('dashboard.transaction.choose_card'), 'id' => 'enabled_package', 'multiple' => 'multiple']) !!}
  </div>

  <div class="col-12 col-md-3 mb-3">
    <label for="transactionType">@lang('dashboard.transaction.transaction_status')</label>
    {!! Form::select('status[]', [-1 => trans('dashboard.general.all_cases')] + trans('dashboard.transaction.status_cases'), request('status'), ['class' => 'form-control select2', 'data-placeholder' => trans('dashboard.general.select_status'), 'id' => 'status', 'multiple' => 'multiple']) !!}

  </div>
  <div class="row">
    <div class="col-12 col-md-6 my-2">
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle exportBtn" type="button" id="dropdownMenuButton1"
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

      <button class="btn btn-primary me-2" type="submit">
        <i class="mdi mdi-magnify"></i> {{ trans('dashboard.general.search') }}
      </button>

      <button class="btn btn-outline-primary" type="reset" id="reset">
        <i class="mdi mdi-restore"></i>{{ trans('dashboard.general.show_all') }}
      </button>
    </div>
  </div>
{!! form::close() !!}

<!-- FORM CLOSED -->
