@extends('dashboard.exports.layout')

@section('content')

<table id="departmentTable" class="table">
  <thead>
    @include('dashboard.exports.header',['topic'=>'المعاملات' ,'count' => 6])
    <tr>
      <th>#</th>
      <th>رقم المعاملة</th>
      <th>تاريخ الانشاء</th>
      <th>الاسم</th>
      <th>النوع</th>
      <th>الحالة</th>
      <th>الاجمالي</th>
      <th>البطاقة المفعلة</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($transactions as $transaction)
    <tr>
      <td>{{ $loop->iteration }}</td>
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
