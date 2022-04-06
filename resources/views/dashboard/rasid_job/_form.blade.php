<div class="card py-7 px-7">
  <div class="row">

      <div class="col-12 col-md-{{ isset($rasidJob) ? 4 : 6 }} mb-5">
          {!! Form::label('jobName', trans('dashboard.rasid_job.job_name')) !!}
          <p class="requiredFields">*</p>
          @foreach ($locales as $locale)
              {!! Form::text("{$locale}[name]", isset($rasidJob) ? $rasidJob->name : null, ['class' => 'form-control input-regex stop-copy-paste' . ($errors->has("${locale}.name") ? ' is-invalid' : null), 'id' => 'jobName', 'placeholder' => trans('dashboard.general.enter_name'), 'minlength' => '2', 'maxlength' => '100']) !!}

              <span class="text-danger" id="{{ $locale }}.nameError" hidden></span>
          @endforeach
      </div>

      <div class="col-12 col-md-{{ isset($rasidJob) ? 4 : 6 }} mb-5">
          {!! Form::label('department', trans('dashboard.department.department')) !!}
          <p class="requiredFields">*</p>

          {!! Form::select('department_id', $departments, null, ['class' => 'form-control select2-show-search' . ($errors->has('department_id') ? ' is-invalid' : null), 'dir' => 'rtl', 'placeholder' => trans('dashboard.rasid_job.select_department'), 'id' => 'department']) !!}

          <span class="text-danger" id="department_idError"></span>

      </div>

      @if (isset($rasidJob))
          <div class="col-12 col-md-4 mb-5">
              {!! Form::label('status', trans('dashboard.general.status')) !!}
              <p class="requiredFields">*</p>

              {!! Form::select('is_active', trans('dashboard.rasid_job.active_cases'), null, ['class' => 'form-control select2' . ($errors->has('is_active') ? ' is-invalid' : null), 'id' => 'status', 'placeholder' => trans('dashboard.general.select_status')]) !!}

              <span class="text-danger" id="is_activeError"></span>


          </div>

          <div class="col-12 col-md-3 mb-5">
              {!! Form::label('jobType', trans('dashboard.general.type')) !!}
              {!! Form::text('is_vacant', trans('dashboard.general.job_type_cases')[$rasidJob->is_vacant], ['class' => 'form-control', 'disabled']) !!}
          </div>
      @endif


      @if (isset($rasidJob) && isset($rasidJob->employee))
          <div class="col-12 col-md-3 mb-5">
              {!! Form::label('employeName', trans('dashboard.rasid_job.employee_name')) !!}
              {!! Form::text('employeeName', $rasidJob->employee->user->fullname, ['class' => 'form-control', 'id' => 'employeName', 'disabled']) !!}
          </div>
      @endif


      <div class="col-12 col-md-{{ isset($rasidJob) && isset($rasidJob->employee) ? 9 : 12 }}">
          {!! Form::label('jobDesc', trans('dashboard.rasid_job.rasid_job_description'), ['class' => 'mb-3']) !!}
          @foreach ($locales as $locale)
              {!! Form::textarea("{$locale}[description]", isset($rasidJob) ? $rasidJob->description : null, ['class' => 'form-control input-regex stop-copy-paste' . ($errors->has("{$locale}[description]") ? ' is-invalid' : null), 'id' => 'jobDesc', 'rows' => '5', 'placeholder' => trans('dashboard.general.enter_description'), 'maxlength' => '300', 'onpaste' => 'return false;', 'oncopy' => 'return false;', 'ondrop' => 'return false;']) !!}

              <span class="text-danger" id="{{ $locale }}.descriptionError"></span>
          @endforeach
      </div>

  </div>
</div>

<div class="row">
  <div class="col-12 mb-5 text-end">
      {!! Form::button('<i class="mdi mdi-content-save-outline"></i>' . $btn_submit, ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'saveButton']) !!}
      {!! Form::button('<i class="mdi mdi-arrow-left"></i>' . trans('dashboard.general.back'), ['type' => 'button', 'class' => 'btn btn-outline-primary', 'id' => 'showBack']) !!}

  </div>
</div>


@include('dashboard.layouts.modals.confirm')
@include('dashboard.layouts.modals.back')
@include('dashboard.layouts.modals.alert')

@section('scripts')
  <!-- SELECT2 JS -->
  <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
  <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>

  <script>
      (function() {
          'use strict';
          let validate = false;
          let saveButton = true;

          $('#saveButton').on('click', function(e) {
              e.preventDefault();

              $('span[id*="Error"]').attr('hidden', true);
              $('*input,select').removeClass('is-invalid');

              let form = $('#formId')[0];
              let data = new FormData(form);

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
                  success: function() {
                      $('#successModal').modal('show');
                      toggleSaveButton();
                  },
                  error: function(data) {
                      toggleSaveButton();

                      $.each(data.responseJSON.errors, function(name, message) {
                          let inputName = name;
                          let inputError = name + 'Error';

                          if (inputName.includes('.')) {
                              let convertArray = inputName.split('.');
                              inputName = convertArray[0] + '[' + convertArray[1] + ']'
                          }
                          $('input[name="' + inputName + '"]').addClass('is-invalid');
                          $('select[name="' + inputName + '"]').addClass('is-invalid');
                          $('span[id="' + inputError + '"]').attr('hidden', false);
                          $('span[id="' + inputError + '"]').text(message);
                      });
                  }
              });
          });

          function toggleSaveButton() {
              if (saveButton) {
                  saveButton = false;
                  $("#saveButton").html('<i class="spinner-border spinner-border-sm"></i>' + '{{$btn_submit}}');
                  $('#saveButton').attr('disabled', true);
              } else {
                  saveButton = true;
                  $("#saveButton").html('<i class="mdi mdi-content-save-outline"></i>' + '{{$btn_submit}}');
                  $('#saveButton').attr('disabled', false);
              }
          }


          // window.addEventListener(
          //     "load",
          //     function() {
          //         // Fetch all the forms we want to apply custom Bootstrap validation styles to
          //         var forms = document.getElementsByClassName("needs-validation");
          //         // Loop over them and prevent submission
          //         var validation = Array.prototype.filter.call(
          //             forms,
          //             function(form) {
          //                 form.addEventListener(
          //                     "submit",
          //                     function(event) {
          //                         form.classList.add("was-validated");
          //                         event.preventDefault();
          //                         if (form.checkValidity() === false) {
          //                             event.stopPropagation();
          //                         } else {
          //                             $('#successModal').modal('show');
          //                         }
          //                     },
          //                     false
          //                 );
          //             }
          //         );
          //     },
          //     false
          // );

          $("#showBack").click(function() {
              // $('#formId input').each(function() {
              //     if ($(this).attr('name') !== '_token' && ($(this).val() != '' || $(this).attr(
              //             'checked')))
              //         validate = true;
              // });
              if (validate) {
                  $('#backModal').modal('show');
                  return false;
              } else {
                  history.back()
              }
          });

          $("input,select").change(function() {
              validate = true;
          });

      })();
  </script>
@endsection
