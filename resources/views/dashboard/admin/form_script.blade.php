<script>
  //get users from department script
     function getJobs(department_id) {

          $('#rasid_job_id').empty();
          $('#rasid_job_id').append(new Option('', '', true, true)).trigger('change');
          if (department_id != '') {
              //send ajax
              $.ajax({
                  url: '{{ url('/dashboard/rasid_job/all-jobs') }}' + '/' + department_id,
                  type: 'get',
                  beforeSend: function () {
                      $('#new_admin').html(`<span class="spinner-border text-light" style="width: 1rem; height: 1rem;" role="status"></span>`);
                  },
                  success: function(data) {
                      if (data.view) {
                          $('#rasid_job_id').remove();
                          $('#new_admin').html(data.view);
                      }
                  }
              });
          }
      }

        function addPermissions(selected) {
          let group_options = '';
          let permission_options = '';
          $.each(selected, (index, item) => {
              if (item.getAttribute('data-name') == 'groups') {
                  group_options += `<option value="${item.value}" selected class="group_select"></option>`;
              }
              if (item.getAttribute('data-name') == 'permissions') {
                  permission_options +=
                      `<option value="${item.value}" selected class="permission_select"></option>`;
              }
          });
          $('#permission_list').html(permission_options);
          $('#group_list').html(group_options);
        }

        $(document).ready(function() {
            $(".multipleSelect").select2({
                closeOnSelect: false
            });
            $(".multipleSelect").select2({
                closeOnSelect: false,
                templateResult: formatState
            });

            $('.multipleSelect').on("select2:select", function(e) {
                var data = e.params.data.text;
                if (data == 'إختر الكل'){
                    $(".multipleSelect > option").prop("selected", "selected");
                    $(".multipleSelect").trigger("change");
                    $(".custom-checkbox input").prop("checked", "checked");
                    $("label[for='selectAll']").parent().hide();
                    $("label[for='unselectAll']").parent().show();
                }
                else if (data == 'إلغاء تحديد الكل'){
                    $(".multipleSelect > option").prop("selected", "");
                    $(".multipleSelect").trigger("change");
                    $(".custom-checkbox input").prop("checked", "");
                    $("label[for='unselectAll']").parent().hide();
                    $("label[for='selectAll']").parent().show();
                }
            });
        });

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                `<label for="${state.id}" class="d-flex justify-content-between align-items-center m-0">
                  <div class="">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="${state.id}" />
                      <label class="custom-control-label m-0" for="${state.id}">${state.text}</label>
                    </div>
                   </div>

                    <div class="tooltip-container">
                        <i class="mdi mdi-clipboard-list"></i>
                        <div class="tooltip-content">
                            <ul>
                                <li class="tooltipRole">المجموعة الاولي</li>
                                <li class="tooltipRole">المجموعة الثانية</li>
                            </ul>
                        </div>
                    </div>

                   </label>`
            );
            return $state;
        };


      $(function() {
        let permissions = @isset($admin)  @json($admin->permission_list) @else [] @endisset;
        let groups = @isset($admin)  @json($admin->group_list) @else [] @endisset;

          groups.forEach((item, i) => {
              $('#group_list').append(
                  `<option value="${item}" selected class="group_select"></option>`);
          });
          permissions.forEach((item, i) => {
              $('#permission_list').append(
                  `<option value="${item}" selected class="permission_select"></option>`);
          });

          var minDate = new Date();
          $("#from-hijri-unactive-picker-custom ,#to-hijri-unactive-picker-custom")
              .hijriDatePicker({
                  hijri: {{ auth()->user()->is_date_hijri ? 'true' : 'false' }},
                  showSwitcher: false,
                  format: "YYYY-MM-DD",
                  hijriFormat: "iYYYY-iMM-iDD",
                  hijriDayViewHeaderFormat: "iMMMM iYYYY",
                  dayViewHeaderFormat: "MMMM YYYY",
                  ignoreReadonly: true,
                  minDate:  minDate.setDate(minDate.getDate() - 1 ),
                  maxDate: '2100-01-01',
              });


          //change password checkbox
          $("#changePassword").change(function() {
              if (this.checked) {
                  $(".changePass").attr('hidden', false);
              } else {
                  $(".changePass").attr('hidden', true);
              }
          });

          // temporary status appear date

          $("#status").change(function() {
              if (this.value == 'temporary') {
                  $(".temporary").show();
              } else {
                  $(".temporary").hide();
                  $('#from-hijri-unactive-picker-custom').val('');
                  $('#to-hijri-unactive-picker-custom').val('');
              }
          }).change();

          $("#show_hide_password a").on("click", function(event) {
                  event.preventDefault();
                  if ($("#show_hide_password input").attr("type") == "text") {
                      $("#show_hide_password input").attr("type", "password");
                      $("#show_hide_password i").addClass("mdi-eye-off-outline");
                      $("#show_hide_password i").removeClass("mdi-eye-outline");
                  } else if (
                      $("#show_hide_password input").attr("type") == "password"
                  ) {
                      $("#show_hide_password input").attr("type", "text");
                      $("#show_hide_password i").removeClass("mdi-eye-off-outline");
                      $("#show_hide_password i").addClass("mdi-eye-outline");
                  }
              });
              $("#show_hide_confirm_password a").on("click", function(event) {
                  event.preventDefault();
                  if ($("#show_hide_confirm_password input").attr("type") == "text") {
                      $("#show_hide_confirm_password input").attr("type", "password");
                      $("#show_hide_confirm_password i").addClass("mdi-eye-off-outline");
                      $("#show_hide_confirm_password i").removeClass("mdi-eye-outline");
                  } else if (
                      $("#show_hide_confirm_password input").attr("type") == "password"
                  ) {
                      $("#show_hide_confirm_password input").attr("type", "text");
                      $("#show_hide_confirm_password i").removeClass("mdi-eye-off-outline");
                      $("#show_hide_confirm_password i").addClass("mdi-eye-outline");
                  }
              });
              $('#userId').on('keypress', function(event) {
                  var key = event.charCode ? event.charCode : event.keyCode;
                  $("#userId").innerHTML = key;
                  if (key == 46) {
                      event.preventDefault();
                      return false;
                  }
              });
      });
</script>
