@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>@lang('dashboard.transaction.transaction_number')</th>
     <th>@lang('dashboard.transaction.transaction_date')</th>
      <th>@lang('dashboard.transaction.to_user_client')</th>
      <th>@lang('dashboard.transaction.transaction_type')</th>
      <th>@lang('dashboard.transaction.transaction_status')</th>
      <th>@lang('dashboard.transaction.total')</th>
      <th>@lang('dashboard.transaction.enabled_package')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $transaction)
    <tr>
      <td>{{ isset($key) ? $loop->iteration + ($key * $chunk) : $loop->iteration }}</td>
      <td>{{ $transaction->trans_number }}</td>
      <td>{{ $transaction->created_at_date_time }}</td>
      <td>{{ $transaction->fromUser?->fullname }}</td>
      <td>{{ $transaction->trans_type ? trans("dashboard.transaction.type_cases.{$transaction->trans_type}") : "" }}</td>
      <td>{{ $transaction->trans_status ? trans("dashboard.transaction.status_cases.{$transaction->trans_status}") : "" }}</td>
      <td>{{ (string)($transaction->amount + $transaction->fee_amount) }}</td>
      <td>{{ trans('dashboard.package_types.'.$transaction->fromUser?->citizen?->enabledPackage?->package_type)  ?? trans('dashboard.citizens.without') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
