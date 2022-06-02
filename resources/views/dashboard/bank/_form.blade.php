
<div class="col-12 {{ isset($bank) ? 4 : 6 }} mb-5">
  {!! Form::label('bankName', trans('dashboard.bank.bank_name')) !!}
  <span class="requiredFields">*</span>

  @foreach ($locales as $locale)
  {!! Form::text("{$locale}[name]", isset($bank) ? $bank->name : null, ['class' => 'form-control' . ($errors->has("${locale}.name") ? ' border-danger' : null), 'id' => 'bankName', 'placeholder' => trans('dashboard.bank.Enter_Bank_name')]) !!}

    <span class="text-danger" id="{{ $locale }}.nameError" hidden></span>
            @endforeach
    <div class="invalid-feedback">اسم البنك مطلوب.</div>
</div>
<div class="repeater" >

@foreach ($branches ?? [[]] as $key=>$branch )

        <fieldset class="card createBankBranch px-4 py-4 "  id="bankbranch">
            <a
                role="button"
                href="javascript:void(0)"
                class="deleteBranch text-end "
                ><i class="mdi mdi-delete  " ></i></a>
        <div class="row">
            <div class="col-12 col-md-4 mb-5">
              {!! Form::label('bankBranchName',trans('dashboard.bank.BranchName')) !!}
             <span class="requiredFields">*</span>
             @foreach ($locales as $locale)

             {!! Form::text("branches[$key][$locale][name]",  null, ['class' => 'form-control' . ($errors->has("branches.$key.${locale}.name") ? ' border-danger' : null), 'id' => 'bankBranchName', 'placeholder' => trans('dashboard.bank.Enter_Bank_branch_name')]) !!}

             <span class="text-danger" id="branches.{{ $key }}.{{ $locale }}.nameError" hidden></span>
             @endforeach
                <div class="invalid-feedback">اسم الفرع مطلوب.</div>
            </div>

            <div class="col-12 col-md-4 mb-5">
              {!! Form::label('bankType', trans('dashboard.bank.type')) !!}
              <span class="requiredFields">*</span>


              {!! Form::select("branches[$key][type]",[''=>'']+trans('dashboard.bank.types'),null,['class' => 'form-control select2' . ($errors->has("branches.$key.name") ? ' border-danger' : null), 'id' => 'bankType', 'data-placeholder' => trans('dashboard.general.select_type')]) !!}
              <span class="text-danger" id="branches.{{ $key }}.typeError" hidden></span>
              <div class="invalid-feedback">النوع مطلوب.</div>

          </div>
          <div class="col-12 col-md-4 mb-5">
            {!! Form::label('bankCode',trans('dashboard.bank.code')) !!}
           <span class="requiredFields">*</span>
           {!! Form::text("branches[$key][code]", null, ['class' => 'form-control' . ($errors->has("branches.$key.code") ? ' border-danger' : null), 'id' => 'bankCode', 'placeholder' => trans('dashboard.bank.Enter_bank_code')]) !!}
           <span class="text-danger" id="branches.{{$key}}.codeError" hidden></span>
              <div class="invalid-feedback">الكود مطلوب.</div>
          </div>


          <div class="col-12 col-md-4 mb-5">
            {!! Form::label('bankLocation',trans('dashboard.bank.location')) !!}
           <span class="requiredFields">*</span>
           {!! Form::text("branches[$key][site]", null, ['class' => 'form-control' . ($errors->has("branches.$key.site") ? ' border-danger' : null), 'id' => 'bankLocation', 'placeholder' => trans('dashboard.bank.Enter_bank_location')]) !!}
           <span class="text-danger" id="branches.{{$key}}.siteError" hidden></span>
              <div class="invalid-feedback">الموقع مطلوب.</div>
          </div>


          <div class="col-12 col-md-4 mb-5">
            {!! Form::label('transactionValueFrom',trans('dashboard.bank.transaction_Value_From')) !!}
           <span class="requiredFields">*</span>
           <div class="input-group">
           {!! Form::number("branches[$key][transfer_amount]", null, ['class' => 'form-control' . ($errors->has("branches.$key.transfer_amount") ? ' border-danger' : null), 'id' => 'transactionValueFrom', 'placeholder' => trans('dashboard.bank.Enter_transfer_amount')]) !!}
           <span class="text-danger" id="branches.{{ $key }}.transfer_amountError" hidden></span>
           <div class="input-group-text border-start-0">
            ر.س
        </div>
           </div>
              <div class="invalid-feedback">قيمة تكلفة التحويل مطلوب.</div>
          </div>



          <div class="col-12 col-md-4 mb-5">
            {!! Form::label('commercialRecord',trans('dashboard.bank.commercialRecord')) !!}

           {!! Form::text("branches[$key][commercial_record]", null, ['class' => 'form-control' . ($errors->has("branches.$key.commercial_record") ? ' border-danger' : null), 'id' => 'commercialRecord', 'placeholder' => trans('dashboard.bank.Enter_commercial_Record')]) !!}
           <span class="text-danger" id="branches.{{ $key }}.commercial_record" hidden></span>

              <div class="invalid-feedback">السجل التجاري مطلوب.</div>
          </div>




          <div class="col-12 col-md-4 mb-5">
            {!! Form::label('taxNumber',trans('dashboard.bank.taxNumber')) !!}

           {!! Form::text("branches[$key][tax_number]", null, ['class' => 'form-control' . ($errors->has("branches.$key.tax_number") ? ' border-danger' : null), 'id' => 'taxNumber', 'placeholder' => trans('dashboard.bank.Enter_tax_Number')]) !!}
           <span class="text-danger" id="branches.{{ $key }}.tax_number" hidden></span>
              <div class="invalid-feedback">السجل التجاري مطلوب.</div>
          </div>

          <div class="col-12 col-md-4 mb-5">
            {!! Form::label('serviceNumber',trans('dashboard.bank.serviceNumber')) !!}

           {!! Form::text("branches[$key][service_customer]", null, ['class' => 'form-control' . ($errors->has("branches.$key.service_customer") ? ' border-danger' : null), 'id' => 'serviceNumber', 'placeholder' => trans('dashboard.bank.Enter_service_Number')]) !!}
           <span class="text-danger" id="branches.{{ $key }}.service_customer" hidden></span>
              <div class="invalid-feedback">خدمة العملاء مطلوب.</div>
          </div>



      </fieldset>
      @endforeach
</div>

<div class="card py-7 px-7 h-300">
  <div class="row">
      <div class="col-12 col-md-6 text-end ">
          <a href="javascript:void(0)" class="btn btn-outline-primary mt-9 "    id="addBranchBtn">
              <i class="mdi mdi-plus-circle-outline"></i> إضافة فرع جديد
          </a>


      </div>
  </div>
</div>








<div class="row">
  <div class="col-12 mb-5 text-end">
      {!! Form::button('<i class="mdi mdi-content-save-outline"></i>' . trans('dashboard.general.save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'saveButton']) !!}
      {!! Form::button('<i class="mdi mdi-arrow-left"></i>' . trans('dashboard.general.back'), ['type' => 'button', 'class' => 'btn btn-outline-primary', 'id' => 'showBack']) !!}

  </div>
</div>



@include('dashboard.bank.script')


