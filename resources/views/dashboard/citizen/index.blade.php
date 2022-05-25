@extends('dashboard.layouts.master')
@section('title', trans('dashboard.citizen.index'))

@section('content')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title"> {{ trans('dashboard.citizens.citizens') }} </h1>
    </div>
    <!-- PAGE-HEADER END -->


    <!-- FORM OPEN -->
    {!! Form::open(['method' => 'GET', 'id' => 'citizen-search']) !!}
    <div class="row align-items-end mb-3">
        <div class="col-12 col-md-3 mb-3">
            <label for="citizenName">{{ trans('dashboard.citizens.name') }} </label>
            <input type="text" class="form-control" id="citizenName"
                placeholder="{{ trans('dashboard.citizens.name') }} " />
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="idNumber">{{ trans('dashboard.citizens.identity_number') }} </label>
            <input type="number" class="form-control" id="idNumber"
                placeholder="{{ trans('dashboard.citizens.identity_number') }} " />
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="phone">{{ trans('dashboard.citizens.phone') }} </label>
            <div class="input-group">
                <input id="phone" type="number" placeholder="{{ trans('dashboard.citizens.enter_phone') }} "
                    class="form-control" />
                <div class="input-group-text border-start-0">
                    +966
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="enabledcard">{{ trans('dashboard.citizens.enabled_card') }} </label>
            <select class="form-control select2" id="enabledcard">
                <option selected disabled value="">{{ trans('dashboard.citizens.choose_card') }} </option>
                <option value="">{{ trans('dashboard.general.all_cases') }} </option>
                    <option value="basic"> {{ trans('dashboard.citizens.card_type.basic') }} </option>
                    <option value="golden"> {{ trans('dashboard.citizens.card_type.golden') }} </option>
                    <option value="platinum"> {{ trans('dashboard.citizens.card_type.platinum') }} </option>
            </select>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="from-end-at">{{ trans('dashboard.citizens.card_end_at_from') }} </label>
            <div class="input-group">
                <input id="from-end-at" type="text" placeholder="{{ trans('dashboard.general.day_month_year') }}"
                    class="form-control" name="end_at_from" />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="to-end-at">{{ trans('dashboard.citizens.card_end_at_to') }} </label>
            <div class="input-group">
                <input id="to-end-at" type="text" placeholder="{{ trans('dashboard.general.day_month_year') }}"
                    class="form-control" name="end_at_to" />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="from-created-at">{{ trans('dashboard.citizens.created_at_from') }} </label>
            <div class="input-group">
                <input id="from-created-at" type="text" placeholder="{{ trans('dashboard.general.day_month_year') }}"
                    class="form-control" name="created_from" />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="to-created-at">{{ trans('dashboard.citizens.created_at_to') }} </label>
            <div class="input-group">
                <input id="to-created-at" type="text" placeholder="{{ trans('dashboard.general.day_month_year') }}"
                    class="form-control" name="created_to" />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-12 col-md-6 my-2">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
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
        <div class="col-12 col-md-6 d-flex justify-content-end">
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
                <table id="citizenTable" class="table table-bordered text-nowrap shadow-sm bg-body key-buttons">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">{{ trans('dashboard.citizens.name') }} </th>
                            <th class="border-bottom-0">{{ trans('dashboard.citizens.identity_number') }} </th>
                            <th class="border-bottom-0">{{ trans('dashboard.citizens.phone') }} </th>
                            <th class="border-bottom-0">{{ trans('dashboard.citizens.enabled_card') }} </th>
                            <th class="border-bottom-0">{{ trans('dashboard.citizens.card_end_at') }} </th>
                            <th class="border-bottom-0">{{ trans('dashboard.citizens.created_at') }} </th>
                            <th class="border-bottom-0 text-center" {{ trans('dashboard.citizens.actions') }} </th>
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
                <form method="post" action="#" class="needs-validation" id="item" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="modal-body text-center p-0">
                        <lottie-player autoplay loop mode="normal"
                            src="{{ asset('dashboardAssets/images/lottie/alert.json') }}"
                            style="width: 55%; display: block; margin: 0 auto 1em">
                        </lottie-player>
                        <p>{{ trans('dashboard.citizens.edit_phone') }}</p>
                        <div class="mt-3 input-group">
                            <input type="number" name="phone" class="form-control"
                                placeholder="{{ trans('dashboard.citizens.new_phone') }}">
                            <div class="input-group-text border-start-0">
                                966+ <input type="hidden" value="966" name="country_code">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end mt-5 p-0">
                        <button type="submit" class="btn btn-primary mx-3">{{ trans('dashboard.general.save') }}</button>
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
