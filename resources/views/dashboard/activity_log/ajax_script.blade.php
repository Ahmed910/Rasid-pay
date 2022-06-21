<script>
  //get subprogs from activity_logs script
$("#mainProgram").change(function (e) {
  e.preventDefault();
  let mainprog_id = $("#mainProgram").val();
  $('#branchProgram').empty();
  $("#branchProgram").append('<option value=""> {{ trans('dashboard.activity_log.select_subprogram') }} </option>')
  if (mainprog_id != '') {


    //send ajax
    $.ajax({
      url: '{{ url("dashboard/activitylog/sub-programs") }}' + '/' + mainprog_id,
      type: 'get',
      success: function (data) {
        if (data) {
          $.each(data.data, function (index, subprogram) {
            $("#branchProgram").append('<option value="' + subprogram.name +
              '">' + subprogram.name + '</option>')
          });
        }
      }
    });
  }

});

//get employees from Department
$("#mainDepartment").change(function (e) {
  e.preventDefault();
  let maindep_id = $("#mainDepartment").val();
  $('#employee').empty();
  $("#employee").append('<option value=""> {{ trans('dashboard.activity_log.select_employee') }} </option>')
  if (maindep_id != '') {


    //send ajax
    $.ajax({
      url: '/dashboard/activitylog/all-employees/' + maindep_id,
      type: 'get',
      success: function (data) {
        if (data) {
          $.each(data.data, function (index, user_id) {
            $("#employee").append('<option value="' + user_id.id +
              '">' + user_id.fullname + '</option>')
          });

        }
      }
    });
  }

});

</script>
