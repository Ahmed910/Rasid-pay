<section class="main-pd-wrapper">


    <img src="{{ public_path($transaction->qr_path) }}" alt="" width="150">
    <p style="font-weight: bold; color: #3f68ba; margin-top: 15px; font-size: 18px;">
      @lang('mobile.invoice.successfully_Transfered')
    </p>
  <table style="width: 100%;">
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
    @if ($transaction->trans_type == 'global_transfer')
      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.mtcn_number')
        </th>
        <th>{{ $transaction?->transactionable?->bankTransfer?->mtcn_number ?? '' }}</th>
      </tr>
    @endif
    <tr>
      <th style="color:#3f68ba;">
        @lang('mobile.invoice.reference_number')
      </th>
      <th>{{ $transaction->trans_number ?? '' }}</th>
    </tr>
    <tr>
      <th style="color:#3f68ba;">
        @lang('mobile.invoice.transfer_amount')
      </th>
      @if($transaction->trans_type == 'global_transfer')
        <th>{{ number_format($transaction->amount * $transaction->transactionable?->bankTransfer?->exchange_rate,2,'.','') }}
          USD
        </th>
      @else
        <th>{{ number_format($transaction->amount,2,'.','') }} ر.س</th>
      @endif
    </tr>
    @if ($transaction->trans_type == 'global_transfer' ||$transaction->trans_type == 'local_transfer')
    <tr>
      <th style="color:#3f68ba;">
        @lang('mobile.invoice.fee_amount')
      </th>
      <th>{{ number_format($transaction->fee_amount,2,'.','') ?? 0 }} ر.س</th>
    </tr>
    @endif

    @if ($transaction->trans_type == 'global_transfer')
      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.exchange_rate')
        </th>
        <th>{{ $transaction->transactionable?->bankTransfer?->exchange_rate }} ر.س</th>
      </tr>
    @endif

    <tr>
      <th style="color:#3f68ba;">
        @lang('mobile.invoice.from_account')
      </th>
      <th>{{ $transaction?->fromUser?->fullname ?? '' }}</th>
    </tr>
    <tr>
      <th style="color:#3f68ba;">
        @lang('mobile.invoice.total')
      </th>
      <th>{{ number_format(($transaction->amount + $transaction->fee_amount),2,'.','') ?? 0 }} ر.س</th>
    </tr>
    @if(in_array($transaction->trans_type,['local_transfer','global_transfer']))
      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.beneficiary_name')
        </th>
        @if($transaction?->toUser)
          <th> {{ $transaction?->toUser?->fullname ?? '' }}</th>
        @else
          <th> {{ $transaction?->transactionable?->beneficiary?->name ?? '' }}</th>
        @endif
      </tr>
      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.benefeciary_address')
        </th>
        <th> {{ $transaction?->transactionable?->beneficiary?->country?->name ?? '' }}</th>
      </tr>
    @endif

    @if ($transaction->trans_type == 'wallet_transfer')

      <tr>
        <th style="color:#3f68ba;">
          @lang('mobile.invoice.'.$transaction->transactionable?->wallet_transfer_method)
        </th>
        <th> {{ $wallet_transfer_method[$transaction->transactionable?->wallet_transfer_method] }}</th>
      </tr>
    @endif
    <tr>
      <th style="color:#3f68ba;">
        @lang('mobile.invoice.transfer_purpose')
      </th>
      <th> {{ $transaction?->transactionable?->transferPurpose?->name ?? '' }}</th>
    </tr>
    </thead>
    <tbody></tbody>
  </table>
</section>
