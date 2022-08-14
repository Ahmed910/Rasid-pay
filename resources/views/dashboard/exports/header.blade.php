<!-- <div style="text-align: center; margin-bottom: 1em;">
  <img src="{{ public_path('dashboardAssets/images/brand/fintech.png') }}" width="150" style="margin: auto; " alt="">
  <br>
  <h2>تقرير عن
    {{ $topic }}
  </h2>
  <p>تاريخ إنشائها من ({{ $date_from ?? '' }}) إلى ({{ $date_to ?? '' }})</p>
  <span style="margin-left: 10px; display: inline-block;"><b>رقم المستخدم:</b> {{ $userId ?? auth()->user()->login_id }}</span>
  &nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;
  <span style="margin-right: 10px; display: inline-block;"><b>تاريخ الطباعة:</b> {{ format_date(now()) }}</span>
  <br>

</div> -->


<header>
  <table>
    <thead>

      <tr style="border: none;">
        <th colspan="2" style="padding-right: 1em; padding-left: 1em; text-align: center;border: none;vertical-align: top;">
          <img src="{{ public_path('dashboardAssets/images/brand/fintech.png') }}" width="150" style="margin: auto" alt="">
        </th>
        <th colspan="{{ $count ?? 3 }}" style="border: none; text-align: left;">
          <h1>تقرير عن
            {{ $topic }}
          </h1>
          <br>
          <p>تاريخ إنشائها من ({{ $date_from ?? '' }}) إلى ({{ $date_to ?? '' }})</p>
          <br>
          <p>رقم المستخدم: {{ $userId ?? auth()->user()->login_id }}</p>
          <br>
          <p>تاريخ الطباعة: {{ format_date(now()) }}</p>
          <br>
        </th>
      </tr>

    </thead>
  </table>
</header>
