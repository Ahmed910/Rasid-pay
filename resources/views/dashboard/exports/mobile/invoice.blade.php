<html>

<head>
  <meta charset="utf-8" />
  <title>@lang('mobile.invoice.invoice')</title>
  <link rel="stylesheet" href="{{ asset('dashboardAssets/css/invoice.css') }}">
</head>

<body dir="rtl">

  @if($transaction_type=='payment')
  @include('dashboard.exports.mobile.payment')
  @elseif($transaction_type=='charge')
  @include('dashboard.exports.mobile.charge')
  @else
  @include('dashboard.exports.mobile.transfer')
  @endif

</body>

</html>
