<html>

<head>
  <meta charset="utf-8" />
  <title>@lang('mobile.invoice.invoice')</title>
  <link rel="stylesheet" href="{{ public_path('dashboardAssets/css/invoice.css') }}">
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
