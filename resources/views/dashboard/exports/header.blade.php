<tr>
  <th colspan="2" style="padding-right: 1em; padding-left: 1em; text-align: center">
    <img src="{{ public_path('dashboardAssets/images/brand/fintech.png') }}" width="150" style="margin: auto" alt="">
  </th>
  <th colspan="3">
    <h3>تقرير عن {{ $topic }}
    </h3>
    <br>
    <p>تاريخ إنشائها من ({{ $date_from ?? '' }}) إلى ({{ $date_to ?? '' }})</p>
    <br>
    <p>رقم المستخدم: {{ $userId ?? auth()->user()->login_id }}</p>
    <br>
    <p>تاريخ الطباعة: {{ format_date(now()) }}</p>
    <br>
  </th>
</tr>
