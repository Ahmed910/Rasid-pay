
<div style="text-align: center;">
  <img src="{{ public_path('dashboardAssets/images/brand/fintech.png') }}" width="150" style="margin: auto; display: block;" alt="">
  <br>
  <h2>تقرير عن
    {{ $topic }}
  </h2>
  <p>تاريخ إنشائها من ({{ $date_from ?? '' }}) إلى ({{ $date_to ?? '' }})</p>
  <span style="margin-left: 2em;">رقم المستخدم: {{ $userId ?? auth()->user()->login_id }}</span>
  <span>تاريخ الطباعة: {{ format_date(now()) }}</span>
<br>

</div>
<!--
<tr style="border: none;">
  <th colspan="2" style="padding-right: 1em; padding-left: 1em; text-align: center;border: none;">
    <img src="{{ public_path('dashboardAssets/images/brand/fintech.png') }}" width="150" style="margin: auto" alt="">
  </th>
  <th colspan="{{ $count ?? 3 }}" style="border: none;">
    <h3 class="text-center" style="margin: 0 auto; position: relative; right: 50%; transform: translateX(-50%)">تقرير عن
      {{ $topic }}
    </h3>
    <br>
    <p>تاريخ إنشائها من ({{ $date_from ?? '' }}) إلى ({{ $date_to ?? '' }})</p>
    <br>
    <p>رقم المستخدم: {{ $userId ?? auth()->user()->login_id }}</p>
    <br>
    <p>تاريخ الطباعة: {{ format_date(now()) }}</p>
    <br>
  </th>
</tr> -->
