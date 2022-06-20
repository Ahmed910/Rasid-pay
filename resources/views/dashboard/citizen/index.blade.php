@extends('dashboard.layouts.master')
@section('title', trans('dashboard.citizen.citizens'))

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
  <h1 class="page-title"> {{ trans('dashboard.citizens.citizens_record') }} </h1>
</div>

{!! Form::open(['method' => 'GET', 'id' => 'citizen-search']) !!}
<div class="row align-items-end mb-3">
  <div class="col-12 col-md-3 mb-3">
    <label for="citizenName">{{ trans('dashboard.citizens.name') }} </label>
    <input type="text" class="form-control input-regex stop-copy-paste" id="citizenName" maxlength="100" ondragstart="return false;" ondrop="return false;"
      placeholder="{{ trans('dashboard.citizens.enter_name') }} " />
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="idNumber">{{ trans('dashboard.citizens.identity_number') }} </label>
    <input type="number" class="form-control" id="idNumber" maxlength="10" ondragstart="return false;" ondrop="return false;"
           oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
           placeholder="{{ trans('dashboard.citizens.enter_identity_number') }} " />
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="phone">{{ trans('dashboard.citizens.phone') }} </label>
    <div class="input-group">
      <input id="phone" type="number"
        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
        pattern="^[1-9]\d*$" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" maxlength="9"
        class="form-control stop-copy-paste" placeholder="{{ trans('dashboard.citizens.enter_phone') }} "
        class="form-control" />
      <div class="input-group-text border-start-0">
        966+
      </div>
    </div>
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="enabledpackage">{{ trans('dashboard.citizens.enabled_package') }} </label>
    <select class="form-control select2" id="enabledpackage"  data-placeholder="{{ trans('dashboard.citizens.choose_card') }}">
      <option selected disabled hidden  value="">{{ trans('dashboard.citizens.choose_card') }} </option>
      <option value="-1">{{ trans('dashboard.general.all_cases') }} </option>
      @foreach($packages as $id => $package)
        <option value="{{ $package->id }}"> {{ $package->name }} </option>
      @endforeach
    </select>
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="from-end-at">{{ trans('dashboard.citizens.card_end_at_from') }} </label>
    <div class="input-group">
      <input id="from-end-at" onselectstart="return false" onpaste="return false" onCopy="return false"
        onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off type="text" readonly
        placeholder="{{ trans('dashboard.general.day_month_year') }}" class="form-control" name="end_at_from" />
      <div class="input-group-text border-start-0">
        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="to-end-at">{{ trans('dashboard.citizens.card_end_at_to') }} </label>
    <div class="input-group">
      <input id="to-end-at" onselectstart="return false" onpaste="return false" onCopy="return false"
        onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off type="text" readonly
        placeholder="{{ trans('dashboard.general.day_month_year') }}" class="form-control" name="end_at_to" />
      <div class="input-group-text border-start-0">
        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="from-created-at">{{ trans('dashboard.citizens.created_at_from') }} </label>
    <div class="input-group">
      <input id="from-created-at" onselectstart="return false" onpaste="return false" onCopy="return false"
        onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off type="text" readonly
        placeholder="{{ trans('dashboard.general.day_month_year') }}" class="form-control" name="created_from" />
      <div class="input-group-text border-start-0">
        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-3 mb-3">
    <label for="to-created-at">{{ trans('dashboard.citizens.created_at_to') }} </label>
    <div class="input-group">
      <input id="to-created-at" onselectstart="return false" onpaste="return false" onCopy="return false"
        onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off type="text" readonly
        placeholder="{{ trans('dashboard.general.day_month_year') }}" class="form-control" name="created_to" />
      <div class="input-group-text border-start-0">
        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12 col-md-6 my-2">
    <div class="dropdown">
      <button class="btn btn-outline-primary dropdown-toggle exportBtn" type="button" id="dropdownMenuButton1"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="mdi mdi-tray-arrow-down"></i>
        {{ trans('dashboard.general.export') }}
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

<!-- Row -->
<div class="row row-sm">
  <div class="col-lg-12">
    <div class="p-1">
        <table id="citizenTable" class="table table-bordered text-nowrap shadow-sm bg-body key-buttons">
          <thead>
            <tr>
              <th class="border-bottom-0">#</th>
              <th class="border-bottom-0">{{ trans('dashboard.citizens.name') }} </th>
              <th class="border-bottom-0">{{ trans('dashboard.citizens.identity_number') }} </th>
              <th class="border-bottom-0">{{ trans('dashboard.citizens.phone') }} </th>
              <th class="border-bottom-0">{{ trans('dashboard.citizens.enabled_package') }} </th>
              <th class="border-bottom-0">{{ trans('dashboard.citizens.card_end_at') }} </th>
              <th class="border-bottom-0">{{ trans('dashboard.citizens.created_at') }} </th>
              <th class="border-bottom-0 text-center">{{ trans('dashboard.general.actions') }}</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_phone">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
        <form method="post" action="" class="needs-validation" id="update-phone" novalidate>
          @csrf
          @method('PUT')
          <div class="modal-body text-center p-0">
            <lottie-player autoplay loop mode="normal" src="{{ asset('dashboardAssets/images/lottie/alert.json') }}"
              style="width: 55%; display: block; margin: 0 auto 1em">
            </lottie-player>
            <p>{{ trans('dashboard.citizens.edit_phone') }}</p>
            <div class="mt-3 input-group">
              <input type="number" name="phone" class="form-control" id = "phone_value"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                pattern="^[0-9]\d*$" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" maxlength="10"
                class="form-control stop-copy-paste" placeholder="{{ trans('dashboard.citizens.new_phone') }}" value="" >
              <div class="input-group-text border-start-0">
                966+
              </div>
            </div>
            <span id="phone_error"></span>
          </div>
          <div class="modal-footer justify-content-end mt-5 p-0">
            <button type="submit" class="btn btn-primary mx-3" id="btn-submit">{{ trans('dashboard.general.save') }}</button>
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
              {{ trans('dashboard.general.back') }}
            </button>
          </div>
        </form>

    </div>
  </div>
</div>
<!-- End Row -->
@include('dashboard.layouts.modals.alert')
@endsection

@include('dashboard.citizen.script')
