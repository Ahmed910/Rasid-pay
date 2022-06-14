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
          $('[name="permission_list[]"]').html(permission_options);
          $('[name="group_list[]"]').html(group_options);
      }


      $(function() {
        let permissions = @isset($admin)  @json($admin->permission_list) @else [] @endisset;
        let groups = @isset($admin)  @json($admin->group_list) @else [] @endisset;

          groups.forEach((item, i) => {
              $('[name="group_list[]"]').append(
                  `<option value="${item}" selected class="group_select"></option>`);
          });
          permissions.forEach((item, i) => {
              $('[name="permission_list[]"]').append(
                  `<option value="${item}" selected class="permission_select"></option>`);
          });

          $("#from-hijri-unactive-picker-custom ,#to-hijri-unactive-picker-custom")
              .hijriDatePicker({
                  hijri: {{ auth()->user()->is_date_hijri ? 'true' : 'false' }},
                  showSwitcher: false,
                  format: "YYYY-MM-DD",
                  hijriFormat: "iYYYY-iMM-iDD",
                  hijriDayViewHeaderFormat: "iMMMM iYYYY",
                  dayViewHeaderFormat: "MMMM YYYY",
                  ignoreReadonly: true,
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
      })();
</script>
