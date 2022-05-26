@extends('dashboard.layouts.master')
@section('title', trans('dashboard.transaction.index'))

@section('content')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ trans('dashboard.transaction.transactions') }}</h1>
    </div>
    <!-- PAGE-HEADER END -->


    @include('dashboard.transaction._search')

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="p-1">
                <table id="transactionsTable" class="table table-bordered text-nowrap shadow-sm bg-body key-buttons">
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
