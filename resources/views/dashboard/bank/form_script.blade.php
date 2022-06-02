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
{!! Form::text("branches[` + myid + `][name]" , null, ['class' => 'form-control' . ($errors->has("name") ? ' is-invalid' : null), 'id' => 'bankBranchName', 'placeholder' => trans('dashboard.bank.Enter_Bank_branch_name')]) !!}

          <div class="invalid-feedback">اسم الفرع مطلوب.</div>
      </div>

      <div class="col-12 col-md-4 mb-5">
{!! Form::label('bankType', trans('dashboard.bank.type')) !!}
          <span class="requiredFields">*</span>

{!! Form::select("branches[` + myid + `][type]", [''=>'']+trans('dashboard.bank.types'), null, ['class' => 'form-control select2' . ($errors->has('type') ? ' is-invalid' : null), 'id' => 'bankType', 'data-placeholder' => trans('dashboard.general.select_type')]) !!}
          <div class="invalid-feedback">النوع مطلوب.</div>

      </div>
      <div class="col-12 col-md-4 mb-5">
{!! Form::label('bankCode',trans('dashboard.bank.code')) !!}
          <span class="requiredFields">*</span>
{!! Form::text("branches[` + myid + `][code]", null, ['class' => 'form-control' . ($errors->has("code") ? ' is-invalid' : null), 'id' => 'bankCode', 'placeholder' => trans('dashboard.bank.Enter_bank_code')]) !!}

          <div class="invalid-feedback">الكود مطلوب.</div>
      </div>


      <div class="col-12 col-md-4 mb-5">
{!! Form::label('bankLocation',trans('dashboard.bank.location')) !!}
          <span class="requiredFields">*</span>
{!! Form::text("branches[` + myid + `][site]", null, ['class' => 'form-control' . ($errors->has("site") ? ' is-invalid' : null), 'id' => 'bankLocation', 'placeholder' => trans('dashboard.bank.Enter_bank_location')]) !!}

          <div class="invalid-feedback">الموقع مطلوب.</div>
      </div>


      <div class="col-12 col-md-4 mb-5">
{!! Form::label('transactionValueFrom',trans('dashboard.bank.transaction_Value_From')) !!}
          <span class="requiredFields">*</span>
          <div class="input-group">
{!! Form::number("branches[` + myid + `][transfer_amount]", null, ['class' => 'form-control' . ($errors->has("transfer_amount") ? ' is-invalid' : null), 'id' => 'transactionValueFrom', 'placeholder' => trans('dashboard.bank.Enter_transfer_amount')]) !!}
          <div class="input-group-text border-start-0">
           ر.س
       </div>
          </div>
             <div class="invalid-feedback">قيمة التحويل  مطلوب.</div>
         </div>



         <div class="col-12 col-md-4 mb-5">
{!! Form::label('commercialRecord',trans('dashboard.bank.commercialRecord')) !!}

          {!! Form::text("branches[` + myid + `][commercial_record]", null, ['class' => 'form-control' . ($errors->has("commercial_record") ? ' is-invalid' : null), 'id' => 'commercialRecord', 'placeholder' => trans('dashboard.bank.Enter_commercial_Record')]) !!}

          <div class="invalid-feedback">السجل التجاري مطلوب.</div>
      </div>




      <div class="col-12 col-md-4 mb-5">
{!! Form::label('taxNumber',trans('dashboard.bank.taxNumber')) !!}

          {!! Form::text("branches[` + myid + `][tax_number]", null, ['class' => 'form-control' . ($errors->has("tax_number") ? ' is-invalid' : null), 'id' => 'taxNumber', 'placeholder' => trans('dashboard.bank.Enter_tax_Number')]) !!}

          <div class="invalid-feedback">السجل التجاري مطلوب.</div>
      </div>

      <div class="col-12 col-md-4 mb-5">
{!! Form::label('serviceNumber',trans('dashboard.bank.serviceNumber')) !!}

          {!! Form::text("branches[` + myid + `][service_customer]", null, ['class' => 'form-control' . ($errors->has("service_customer") ? ' is-invalid' : null), 'id' => 'serviceNumber', 'placeholder' => trans('dashboard.bank.Enter_service_Number')]) !!}

          <div class="invalid-feedback">خدمة العملاء مطلوب.</div>
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
