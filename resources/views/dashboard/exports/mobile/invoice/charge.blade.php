
<section class="main-pd-wrapper">


    <img src="{{ public_path($transaction->qr_path) }}" alt="" width="150">
    <p style="font-weight: bold; color: #3f68ba; margin-top: 15px; font-size: 18px;">
      @lang('mobile.invoice.successfully_charged')
    </p>
  <table style="width: 100%">
    <thead>
      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.transaction_type')
        </th>
        <th>{{ trans("dashboard.transaction.type_cases.{$transaction->trans_type}") ?? '' }}</th>
      </tr>
      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.transaction_date')
        </th>
        <th>{{ $transaction->created_at_date ?? '' }}</th>
      </tr>

      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.reference_number')
        </th>
        <th>{{ $transaction->trans_number ?? '' }}</th>
      </tr>
      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.charge_amount')
        </th>
        <th>{{ $transaction->amount ?? '' }}ر.س </th>
      </tr>
      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.phone')
        </th>
        <th>{{ $transaction?->fromUser?->phone ?? '' }} </th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</section>
