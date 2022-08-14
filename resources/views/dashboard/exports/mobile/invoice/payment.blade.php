
<section class="main-pd-wrapper">


    <img src="{{ public_path($transaction->qr_path) }}" alt="" width="150">
    <p style="font-weight: bold; color: #3f68ba; margin-top: 15px; font-size: 18px;">
      @lang('mobile.invoice.successfully_payment')
    </p>
  <table style="width: 100%;">
    <thead>
      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.invoice_number')
        </th>
        <th>{{$transaction->transactionable?->invoice_number}}</th>
      </tr>
      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.reference_number')
        </th>
        <th>{{ $transaction->trans_number ?? '' }}</th>
      </tr>

      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.transaction_date')
        </th>
        <th>{{ $transaction->created_at_date ?? '' }}</th>
      </tr>

      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.transaction_name')
        </th>
        <th>{{ trans("dashboard.transaction.type_cases.{$transaction->trans_type}") ?? '' }}</th>
      </tr>
      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.transaction_value')
        </th>
        <th>{{ $transaction->amount ?? '' }} ر.س</th>
      </tr>
      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.total')
        </th>
        <th>{{ ($transaction->amount + $transaction->transactionable?->transfer_fees) ?? 0 }} ر.س</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</section>
