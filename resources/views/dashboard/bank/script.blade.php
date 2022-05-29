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
    $(function() {
        $("#transaction").DataTable({
        sDom: "t<'domOption'lpi>",
            pageLength: 10,
            lengthMenu: [
            [1, 5, 10, 20, -1],
            [1, 5, 10, 20, "الكل"],
            ],

            language: {
            lengthMenu: "عرض _MENU_",
            zeroRecords: "لا يوجد بيانات",
            info: "عرض _PAGE_ من _PAGES_ عنصر",
            infoEmpty: "لا يوجد نتائج بحث متاحة",
            paginate: {
            previous: '<i class="mdi mdi-chevron-right"></i>',
            next: '<i class="mdi mdi-chevron-left"></i>',
            },
            },
            });
            /******* Calendar *******/
            $("#from-hijri-picker-custom, #to-hijri-picker-custom, #from-hijri-unactive-picker-custom ,#to-hijri-unactive-picker-custom")
                .hijriDatePicker({
                    hijri: {{ auth()->user()->is_date_hijri ? 'true' : 'false' }},
                    showSwitcher: false,
                    format: "YYYY-MM-DD",
                    hijriFormat: "iYYYY-iMM-iDD",
                    hijriDayViewHeaderFormat: "iMMMM iYYYY",
                    dayViewHeaderFormat: "MMMM YYYY",
                    minDate: '1900-01-01',
                    maxDate: '2100-01-01',
                    showClear:true,
                    isRTL: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}",
                    ignoreReadonly: true,
                });
                var table = $("#activitylogtable").DataTable({
                sDom: "t<'domOption'lpi>",
                serverSide: true,
                ajax: {
                    url: "{{ route('dashboard.activity_log.index') }}?" + $.param(
                        @json(request()->query()))
                },
                columns: [{
                  data: function (data, type, full, meta) {
                    return parseInt(meta.row) + parseInt(data.start_from) + 1;
                  },
                  name: 'id',
                  class: 'activity_log_index'
                    },
                    {
                        data: "user.fullname",
                        name : "employee"
                    },

                    {
                        data: function(data) {
                          if(data.user.department !== null){
                            return data.user.department.name;
                          }else{
                            return  "{{ trans('dashboard.department.without_parent') }}";
                              }
                        },
                        name: 'department'
                    },

                   {

                    data:function(data) {
                            return data.auditable_type ? data.auditable_type :
                                " ";
                        },
                    name : "main_program"

                   },
                   {
                    data:"type",
                   name : "subprogram"


                    },
                    {
                        data: "created_at",
                        name: "created_at"

                    },
                    {
                        data: "ip",
                        name: "ip"
                    },

                    {
                        data: function(data) {
                          @include('dashboard.layouts.globals.datatable.activity_log_actions')
                        },
                        name:"type"
                    },

                    {
                        class: "text-center",
                        data: function(data) {
                            return `<a
                  href="${data.show_route}"
                  class="azureIcon"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="${"@lang('dashboard.general.show')"}"
                  ><i class="mdi mdi-eye-outline"></i
                ></a>`

                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                createdRow: function(row, data) {
                    $('[data-toggle="popoverIMG"]', row).popover({
                        placement: "right",
                        trigger: "hover",
                        html: true,
                    });
                },
                pageLength: 10,
                lengthMenu: [
                    [1, 5, 10, 15, 20],
                    [1, 5, 10, 15, 20]
                ],

                "language": {
                  @include('dashboard.layouts.globals.datatable.datatable_translation')
                },
              "drawCallback": function (settings, json) {
                // table sorting
                var activityLogTableSorting = document.getElementsByClassName('activity_log_index');
                for (var i = 0; i < activityLogTableSorting.length; i++) {
                  activityLogTableSorting[i].innerText = activityLogTableSorting[i].innerText.replace(activityLogTableSorting[i].innerText, activityLogTableSorting[i].innerText.toArabicUni());
                }
                //pagination
                var activityLogTablePagination = document.getElementsByClassName('page-link');
                for (var i = 1; i < activityLogTablePagination.length - 1; i++) {
                  activityLogTablePagination[i].innerText = activityLogTablePagination[i].innerText.replace(activityLogTablePagination[i].innerText, activityLogTablePagination[i].innerText.toArabicUni());
                }
                // info
                var activityLogTableInfo = document.getElementById('activitylogtable_info').innerText;
                document.getElementById('activitylogtable_info').innerText = activityLogTableInfo.replace(activityLogTableInfo, activityLogTableInfo.toArabicUni());
              }
            });

            $('#activityName').on('select2:select', function (e) {

          table.draw();
      });
      $("#mainDepartment").on('select2:select',function (e) {
        table.draw();

      });
      $('#mainProgram').on('select2:select', function(e) {
                table.draw();
            });

      $('#branchProgram').on('select2:select', function(e) {
                table.draw();
            });
      $('#search-form').on('reset', function (e) {
        e.preventDefault();
        $('#activityName').val(null).trigger('change');
        $('#mainDepartment').val(null).trigger('change');
        $('#mainProgram').val(null);
        $('#branchProgram').val(null);
        table.draw();
      });

      $("#search-form").submit(function (e) {
        e.preventDefault();
        table.draw();
      });

            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });
                //get subprogs from activity_logs script
      $("#mainProgram").change(function(e) {
                  e.preventDefault();
                  let mainprog_id = $("#mainProgram").val();
                  $('#branchProgram').empty();
                  $("#branchProgram").append('<option value=""> {{ trans('dashboard.activity_log.select_subprogram') }} </option>')
                  if (mainprog_id != '') {


                      //send ajax
                      $.ajax({
                          url: '{{ url('dashboard/activitylog/sub-programs') }}' + '/' + mainprog_id,
                          type: 'get',
                          success: function(data) {
                              if (data) {
                                  $.each(data.data, function(index, subprogram) {
                                      $("#branchProgram").append('<option value="' + subprogram.name +
                                          '">' + subprogram.name + '</option>')
                                  });
                              }
                          }
                      });
                  }

              });
 //get employees from Department
 $("#mainDepartment").change(function(e) {
                  e.preventDefault();
                  let maindep_id = $("#mainDepartment").val();
                  $('#employee').empty();
                  $("#employee").append('<option value=""> {{ trans('dashboard.activity_log.select_employee') }} </option>')
                  if (maindep_id != '') {


                      //send ajax
                      $.ajax({
                          url: '/dashboard/activitylog/all-employees/' + maindep_id,
                          type: 'get',
                          success: function(data) {
                              if (data) {
                                  $.each(data.data, function(index, user_id) {
                                      $("#employee").append('<option value="' + user_id.id +
                                          '">' + user_id.fullname + '</option>')
                                  });

                              }
                          }
                      });
                  }

              });


        });

    // add bank branch function
    $(function() {
    jQuery.mark = {
        addNewBranch: function (options) {
        var defaults = {
            selector: '#addBranchBtn'
        };
        if (typeof options == 'string') defaults.selector = options;
        var options = jQuery.extend(defaults, options);
        return jQuery(options.selector).each(function () {
            var obj = jQuery(this);
            var geddit = $('.createBankBranch:first');
            var gedditUp = geddit.parent();
            obj.click(function(e){
            geddit.clone(true,true).appendTo('#add-branch-form');
            e.preventDefault();
            });
        })
        },
        deleteBranch: function (options) {
        var defaults = {
            selector: '.deleteBranch'
        };
        if (typeof options == 'string') defaults.selector = options;
        var options = jQuery.extend(defaults, options);
        return jQuery(options.selector).each(function () {
            var obj = jQuery(this);
            obj.on("click", function(e){
            jQuery(this).parent().remove();
            e.preventDefault();
            });
        })
        }
    }
    });

    jQuery(function(){
    jQuery.mark.addNewBranch();
    jQuery.mark.deleteBranch();
    });
    // end add bank branch function

</script>

{{-- <script>
    $(document).ready(function () {
       $("select")
         .change(function () {
           $(this)
             .find("option:selected")
             .each(function () {
               var optionValue = $(this).attr("value");
               if (optionValue) {
                 $(".hold")
                   .not("." + optionValue)
                   .hide();
                 $("." + optionValue).show();
               } else {
                 $(".hold").hide();
               }
             });
         })
         .change();
     });


</script> --}}


<script>


 $(document).ready(function() {

  var counter = 0
            , myid = 1;
        counter = 1;
        $(document).on("click", '#addBranchBtn', function() {
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
             {!! Form::text("banks[` + myid + `][name]" , null, ['class' => 'form-control' . ($errors->has("name") ? ' is-invalid' : null), 'id' => 'bankBranchName', 'placeholder' => trans('dashboard.bank.Enter_Bank_branch_name')]) !!}

                <div class="invalid-feedback">اسم الفرع مطلوب.</div>
            </div>

            <div class="col-12 col-md-4 mb-5">
              {!! Form::label('bankType', trans('dashboard.bank.type')) !!}
              <span class="requiredFields">*</span>

              {!! Form::select("banks[` + myid + `][types]", [''=>'']+trans('dashboard.bank.types'), null, ['class' => 'form-control select2' . ($errors->has('type') ? ' is-invalid' : null), 'id' => 'bankType', 'data-placeholder' => trans('dashboard.general.select_type')]) !!}
              <div class="invalid-feedback">النوع مطلوب.</div>

          </div>
          <div class="col-12 col-md-4 mb-5">
            {!! Form::label('bankCode',trans('dashboard.bank.code')) !!}
           <span class="requiredFields">*</span>
           {!! Form::text("banks[` + myid + `][code]", null, ['class' => 'form-control' . ($errors->has("code") ? ' is-invalid' : null), 'id' => 'bankCode', 'placeholder' => trans('dashboard.bank.Enter_bank_code')]) !!}

              <div class="invalid-feedback">الكود مطلوب.</div>
          </div>


          <div class="col-12 col-md-4 mb-5">
            {!! Form::label('bankLocation',trans('dashboard.bank.location')) !!}
           <span class="requiredFields">*</span>
           {!! Form::text("banks[` + myid + `][site]", null, ['class' => 'form-control' . ($errors->has("site") ? ' is-invalid' : null), 'id' => 'bankLocation', 'placeholder' => trans('dashboard.bank.Enter_bank_location')]) !!}

              <div class="invalid-feedback">الموقع مطلوب.</div>
          </div>


          <div class="col-12 col-md-4 mb-5">
            {!! Form::label('transactionValueFrom',trans('dashboard.bank.transaction_Value_From')) !!}
           <span class="requiredFields">*</span>
           <div class="input-group">
           {!! Form::number("banks[` + myid + `][transfer_amount]", null, ['class' => 'form-control' . ($errors->has("transfer_amount") ? ' is-invalid' : null), 'id' => 'transactionValueFrom', 'placeholder' => trans('dashboard.bank.Enter_transfer_amount')]) !!}
           <div class="input-group-text border-start-0">
            ر.س
        </div>
           </div>
              <div class="invalid-feedback">قيمة التحويل  مطلوب.</div>
          </div>



          <div class="col-12 col-md-4 mb-5">
            {!! Form::label('commercialRecord',trans('dashboard.bank.commercialRecord')) !!}

           {!! Form::text("banks[` + myid + `][commercial_record]", null, ['class' => 'form-control' . ($errors->has("commercial_record") ? ' is-invalid' : null), 'id' => 'commercialRecord', 'placeholder' => trans('dashboard.bank.Enter_commercial_Record')]) !!}

              <div class="invalid-feedback">السجل التجاري مطلوب.</div>
          </div>




          <div class="col-12 col-md-4 mb-5">
            {!! Form::label('taxNumber',trans('dashboard.bank.taxNumber')) !!}

           {!! Form::text("banks[` + myid + `][tax_number]", null, ['class' => 'form-control' . ($errors->has("tax_number") ? ' is-invalid' : null), 'id' => 'taxNumber', 'placeholder' => trans('dashboard.bank.Enter_tax_Number')]) !!}

              <div class="invalid-feedback">السجل التجاري مطلوب.</div>
          </div>

          <div class="col-12 col-md-4 mb-5">
            {!! Form::label('serviceNumber',trans('dashboard.bank.serviceNumber')) !!}

           {!! Form::text("banks[` + myid + `][service_customer]", null, ['class' => 'form-control' . ($errors->has("service_customer") ? ' is-invalid' : null), 'id' => 'serviceNumber', 'placeholder' => trans('dashboard.bank.Enter_service_Number')]) !!}

              <div class="invalid-feedback">خدمة العملاء مطلوب.</div>
          </div>



      </fieldset>`
            ].join(''));
            $('#addBranchBtn').show();

            $('.dod').children().last().find('.minus').show();

            if (counter > 1) {
                $(".kkk").find('.minus').show();
            }
            $(document).on("click", '.deleteBranch', function() {

             $(this).closest('.createBankBranch').hide();

             });

        });



      });

</script>


<script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
<script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
@endsection
