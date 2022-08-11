@foreach ($banks as $bank)
<tr>
  <td>{{ $loop->iteration }}</td>
  <td>{{ $bank->name }}</td>
  <td>
    @if($bank->is_active)
    <div class="active">
      <i class="mdi mdi-check-circle-outline"></i>
      {{ trans('dashboard.bank.active_cases.1') }}
    </div>
    @else
    <div class="unactive">
      <i class="mdi mdi-cancel"></i>
      {{ trans('dashboard.bank.active_cases.0') }}
    </div>
    @endif
  </td>
</tr>
@endforeach