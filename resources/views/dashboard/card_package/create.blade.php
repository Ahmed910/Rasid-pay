@extends('dashboard.layouts.master')
@section('title', trans('dashboard.client.sub_progs.create'))

@section('content')

  <!-- PAGE-HEADER -->
  <div class="page-header">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ route('dashboard.card_package.index') }}">نسب خصم البطاقات
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          إضافة
        </li>
      </ol>
    </nav>
  </div>
  <!-- PAGE-HEADER END -->
  <form action="{{ route('dashboard.card_package.store') }}" id="formId" method="POST">
    @csrf
    <div class="card px-7 py-7">
      <div class="row">
        <div class="col-12 col-md-6 mb-5">
          <label for="client_id">اسم العميل</label><span class="requiredFields">*</span>
          <select class="form-control select2-show-search" id="client_id" name="client_id">
            <option selected disabled value="">إختر العميل</option>
            @foreach ($clients as $key => $clientName)
              <option value="{{ $key }}"> {!! $clientName !!}</option>
            @endforeach
          </select>
          <span class="text-danger" id="client_idError" hidden></span>
        </div>

        <div class="col-12 col-md-6 mb-5">
          <label for="discountRate">نسبة خصم البطاقة الأساسية</label><span class="requiredFields">*</span>
          <div class="input-group">
            <input id="discountRate" type="number" placeholder="أدخل نسبة الخصم  " class="form-control"
                   name="basic_discount"/>
            <div class="input-group-text border-start-0">
              %
            </div>
          </div>
          <span class="text-danger" id="basic_discountError" hidden></span>

        </div>
        <div class="col-12 col-md-6 mb-5">
          <label for="discountRate">نسبة خصم البطاقة الذهبية</label><span class="requiredFields">*</span>
          <div class="input-group">
            <input id="discountRate" type="number" placeholder="أدخل نسبة الخصم  " class="form-control"
                   name="golden_discount"/>
            <div class="input-group-text border-start-0">
              %
            </div>
          </div>
          <span class="text-danger" id="golden_discountError" hidden></span>

        </div>
        <div class="col-12 col-md-6 mb-5">
          <label for="discountRate">نسبة خصم البطاقة البلاتينية</label><span class="requiredFields">*</span>
          <div class="input-group">
            <input id="discountRate" type="number" placeholder="أدخل نسبة الخصم  " class="form-control"
                   name="platinum_discount"/>
            <div class="input-group-text border-start-0">
              %
            </div>
          </div>
          <span class="text-danger" id="platinum_discountError" hidden></span>

        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-12 mb-5 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal"
                {{-- data-bs-target="#successModal" --}}
                type="submit" id="saveButton">
          <i class="mdi mdi-page-next-outline"></i> حفظ
        </button>
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary"
           {{-- data-bs-toggle="modal" --}}
           data-bs-target="#backModal">
          <i class="mdi mdi-arrow-left"></i> عودة
        </a>
      </div>
    </div>
  </form>




  @include('dashboard.layouts.modals.confirm')
  @include('dashboard.layouts.modals.back')
  @include('dashboard.layouts.modals.alert')
  {{-- @include('dashboard.card_package.script') --}}

@section('scripts')
  <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
  <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/fileupload.js"></script>
  <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/file-upload.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
  <script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>

  <script>
    (function () {
      'use strict';
      let validate = false;
      let saveButton = true;

      let erroe = false;
      $('#saveButton').on('click', function (e) {
        e.preventDefault();
        if (erroe) {
          $('span[id*="Error"]').attr('hidden', true);
          $('*input,select').removeClass('is-invalid');
          erroe = false;
        }


        let form = $('#formId')[0];
        let data = new FormData(form);

        //     alert($('#formId').attr('action')) ;
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          url: $('#formId').attr('action'),
          type: "POST",
          data: data,
          beforeSend: toggleSaveButton(),
          processData: false,
          contentType: false,
          cache: false,
          success: function () {
            $('#successModal').modal('show');
            toggleSaveButton();
          },
          error: function (data) {
            toggleSaveButton();

            $.each(data.responseJSON.errors, function (name, message) {
              erroe = true;
              let inputName = name;
              let inputError = name + 'Error';

              if (inputName.includes('.')) {
                let convertArray = inputName.split('.');
                inputName = convertArray[0] + '[' + convertArray[1] + ']'
              }

              $('input[name="' + inputName + '"]').addClass('is-invalid');
              $('select[name="' + inputName + '"]').addClass('is-invalid');
              $('span[id="' + inputError + '"]').attr('hidden', false);
              $('span[id="' + inputError + '"]').html(`<small>${message}</small>`);
            });
          }
        });
      });

      function toggleSaveButton() {
        if (saveButton) {
          saveButton = false;
          $("#saveButton").html('<i class="spinner-border spinner-border-sm"></i>' + "{{ trans('dashboard.general.save')}}");
          $('#saveButton').attr('disabled', true);
        } else {
          saveButton = true;
          $("#saveButton").html('<i class="mdi mdi-content-save-outline"></i>' + "{{ trans('dashboard.general.save')}}");
          $('#saveButton').attr('disabled', false);
        }
      }

    })();
  </script>

@endsection
@endsection

