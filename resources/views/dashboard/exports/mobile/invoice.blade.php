<html>

<head>
  <meta charset="utf-8" />
  <title>@lang('mobile.invoice.invoice')</title>
  <link rel="stylesheet" href="{{ asset('dashboardAssets/css/invoice.css') }}">
  <style>
    table,
    th,
    td {
      border: 1px solid #ececec;
      border-collapse: collapse;
      padding: 0.5em;
      text-align: right;
    }

    .main-pd-wrapper {
      text-align: center;
      background-color: #fff;
      border-radius: 10px;
      padding: 20px;
      margin: 20px;
    }
  </style>
</head>

<body dir="rtl">

  @if($transaction_type=='payment')
  @include('dashboard.exports.mobile.invoice.payment')
  @elseif($transaction_type=='charge')
  @include('dashboard.exports.mobile.invoice.charge')
  @else
  @include('dashboard.exports.mobile.invoice.transfer')
  @endif

</body>

</html>
