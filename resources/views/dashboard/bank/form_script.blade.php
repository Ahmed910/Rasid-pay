@section('datatable_script')
  <script src="{{ asset('dashboardAssets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
@endsection
@section('scripts')
  <script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>
  <script src="{{ asset('dashboardAssets') }}/plugins/bootstrap-hijri-datepicker/js/bootstrap-hijri-datetimepicker.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>


  </script>
  {{-- Ajax DataTable --}}
  <script>


    $(document).ready(function () {

      var counter = 0
        , myid = 1;
      counter = 1;
      $(document).on("click", '#addBranchBtn', function () {
        counter++;
        myid++;
        $('.repeater').append([
          `  <fieldset class="card createBankBranch px-4 py-4 "  id="bankbranch">
            <a
                role="button"
                class="deleteBranch text-end"
                ><i class="mdi mdi-delete"></i></a>
        <div class="row">
            <div class="col-12 col-md-4 mb-5">
              {!! Form::label('bankBranchName',trans('dashboard.bank.BranchName')) !!}
          <span class="requiredFields">*</span>
{!! Form::text("branches[` + myid + `][$locale][name]" , $branches['name'] ?? null, ['class' => 'form-control input-regex stop-copy-paste' . ($errors->has("branches.$key.${locale}.name") ? ' border-danger' : null), 'id' => 'bankBranchName', 'placeholder' => trans('dashboard.bank.Enter_Bank_branch_name')]) !!}
<span class="text-danger" id="branches.`+myid+`.nameError" hidden></span>
      </div>

      <div class="col-12 col-md-4 mb-5">
{!! Form::label('bankType', trans('dashboard.bank.type')) !!}
          <span class="requiredFields">*</span>

{!! Form::select("branches[` + myid + `][type]", [''=>'']+trans('dashboard.bank.types'), null, ['class' => 'form-control select2' . ($errors->has('type') ? ' is-invalid' : null), 'id' => 'bankType', 'data-placeholder' => trans('dashboard.general.select_type')]) !!}
<span class="text-danger" id="branches.`+myid+`.typeError" hidden></span>
      </div>
      <div class="col-12 col-md-4 mb-5">
{!! Form::label('bankCode',trans('dashboard.bank.code')) !!}
          <span class="requiredFields">*</span>
{!! Form::text("branches[` + myid + `][code]", null, ['class' => 'form-control input-regex stop-copy-paste' . ($errors->has("code") ? ' is-invalid' : null), 'id' => 'bankCode', 'placeholder' => trans('dashboard.bank.Enter_bank_code')]) !!}

<span class="text-danger" id="branches.`+myid+`.codeError" hidden></span>
      </div>


      <div class="col-12 col-md-4 mb-5">
{!! Form::label('bankLocation',trans('dashboard.bank.location')) !!}
          <span class="requiredFields">*</span>
{!! Form::text("branches[` + myid + `][site]", null, ['class' => 'form-control input-regex stop-copy-paste' . ($errors->has("site") ? ' is-invalid' : null), 'id' => 'bankLocation', 'placeholder' => trans('dashboard.bank.Enter_bank_location')]) !!}

<span class="text-danger" id="branches.`+myid+`.siteError" hidden></span>

      </div>


      <div class="col-12 col-md-4 mb-5">
{!! Form::label('transactionValueFrom',trans('dashboard.bank.transaction_Value_From')) !!}
          <span class="requiredFields">*</span>
          <div class="input-group">
{!! Form::number("branches[` + myid + `][transfer_amount]", null, ['class' => 'form-control  stop-copy-paste' . ($errors->has("transfer_amount") ? ' is-invalid' : null), 'id' => 'transactionValueFrom', 'placeholder' => trans('dashboard.bank.Enter_transfer_amount')]) !!}
          <div class="input-group-text border-start-0">
           ر.س
       </div>
          </div>
          <span class="text-danger" id="branches.`+myid+`.transfer_amountError" hidden></span>         </div>



         <div class="col-12 col-md-4 mb-5">
{!! Form::label('commercialRecord',trans('dashboard.bank.commercialRecord')) !!}

          {!! Form::text("branches[` + myid + `][commercial_record]", null, ['class' => 'form-control input-regex stop-copy-paste' . ($errors->has("commercial_record") ? ' is-invalid' : null), 'id' => 'commercialRecord', 'placeholder' => trans('dashboard.bank.Enter_commercial_Record')]) !!}

          <span class="text-danger" id="branches.`+myid+`.commercial_recordError" hidden></span>
      </div>




      <div class="col-12 col-md-4 mb-5">
{!! Form::label('taxNumber',trans('dashboard.bank.taxNumber')) !!}

          {!! Form::text("branches[` + myid + `][tax_number]", null, ['class' => 'form-control input-regex stop-copy-paste' . ($errors->has("tax_number") ? ' is-invalid' : null), 'id' => 'taxNumber', 'placeholder' => trans('dashboard.bank.Enter_tax_Number')]) !!}

          <span class="text-danger" id="branches.`+myid+`.tax_numberError" hidden></span>      </div>

      <div class="col-12 col-md-4 mb-5">
{!! Form::label('serviceNumber',trans('dashboard.bank.serviceNumber')) !!}

          {!! Form::text("branches[` + myid + `][service_customer]", null, ['class' => 'form-control input-regex stop-copy-paste' . ($errors->has("service_customer") ? ' is-invalid' : null), 'id' => 'serviceNumber', 'placeholder' => trans('dashboard.bank.Enter_service_Number')]) !!}

          <span class="text-danger" id="branches.`+myid+`.service_customerError" hidden></span>
      </div>



  </fieldset>`
        ].join(''));
        $('#addBranchBtn').show();

        $('.dod').children().last().find('.minus').show();

        if (counter > 1) {
          $(".kkk").find('.minus').show();
        }
        $(document).on("click", '.deleteBranch', function () {

          $(this).closest('.createBankBranch').hide();

        });

      });


    });

  </script>
@endsection
