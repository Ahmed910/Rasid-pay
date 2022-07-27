
<section class="main-pd-wrapper" style="width: 450px; margin: auto">
  <div style="
                text-align: center;
                margin: auto;
                line-height: 1.5;
                font-size: 14px;
                color: #4a4a4a;
              ">

    <img src="{{ public_path($transaction->qr_path) }}" alt="" width="150">
    <p style="font-weight: bold; color: blue; margin-top: 15px; font-size: 18px;">
      @lang('mobile.invoice.successfully_payment')
    </p>
  </div>
  <table style="width: 100%; table-layout: fixed;margin-top:30px;">
    <thead>
      <tr>
        <th style="width: 220px;color:blue;">
          @lang('mobile.invoice.invoice_number')
        </th>
        <th>#{{$transaction->payment?->invoice_number}}</th>
      </tr>
      <tr>
        <th style="width: 220px;color:blue;">
          @lang('mobile.invoice.reference_number')
        </th>
        <th>#{{ $transaction->trans_number ?? '' }}</th>
      </tr>

      <tr>
        <th style="width: 220px;color:blue;">
          @lang('mobile.invoice.transaction_date')
        </th>
        <th>{{ $transaction->created_at ?? '' }}</th>
      </tr>

      <tr>
        <th style="width: 220px;color:blue;">
          @lang('mobile.invoice.transaction_type')
        </th>
        <th>{{ trans("dashboard.transaction.type_cases.{$transaction->trans_type}") ?? '' }}</th>
      </tr>
      <tr>
        <th style="width: 220px;color:blue;">
          @lang('mobile.invoice.transfer_amount')
        </th>
        <th>{{ $transaction->amount ?? '' }} ر.س</th>
      </tr>
      <tr>
        <th style="width: 220px;color:blue;">
          @lang('mobile.invoice.total')
        </th>
        <th>{{ ($transaction->amount + $transaction->transactionable?->transfer_fees) ?? 0 }} ر.س</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</section>