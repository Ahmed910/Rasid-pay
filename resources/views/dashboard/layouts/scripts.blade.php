<script>
  (function () {
  "use strict";

  let validate = false;
  let saveButton = true;

  $("#saveButton").on("click", function (e) {
    e.preventDefault();

    $('span[id*="Error"]').attr("hidden", true);
    $("*input,select,.select2-selection").removeClass("border-danger");

    let form = $("#formId")[0];
    let data = new FormData(form);

    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });

    $.ajax({
      url: $("#formId").attr("action"),
      type: "POST",
      data: data,
      beforeSend: toggleSaveButton(),
      processData: false,
      contentType: false,
      cache: false,
      success: function () {
        $("#successModal").modal("show");
        toggleSaveButton();
      },
      error: function (data) {
        toggleSaveButton();

        $.each(data.responseJSON.errors, function (name, message) {
          let inputName = name;
          let inputError = name + "Error";

          if (inputName.includes(".")) {
            let convertArray = inputName.split(".");
            inputName = convertArray[0] + "[" + convertArray[1] + "]";
          }

          $('input[name="' + inputName + '"]').addClass("border-danger");
          $('select[name="' + inputName + '"]').addClass("border-danger");
          $('.select2-selection[name="' + inputName + '"]').addClass("border-danger");
          $('span[id="' + inputError + '"]').attr("hidden", false);
          $('span[id="' + inputError + '"]').html(`<small>${message}</small>`);
        });
      },
    });
  });

  function toggleSaveButton() {
    if (saveButton) {
      saveButton = false;
      $("#saveButton").html(
        '<i class="spinner-border spinner-border-sm"></i>' +
          "{{ trans('dashboard.general.save')}}"
      );
      $("#saveButton").attr("disabled", true);
    } else {
      saveButton = true;
      $("#saveButton").html(
        '<i class="mdi mdi-content-save-outline"></i>' +
          "{{ trans('dashboard.general.save')}}"
      );
      $("#saveButton").attr("disabled", false);
    }
  }

  $("#showBack").click(function () {
    if (validate) {
      $("#backModal").modal("show");
      return false;
    } else {
      window.location.href = "{{ route('dashboard.backButton') }}";
    }
  });

  $("input,select").change(function () {
    validate = true;
  });

  if($(".dropify").length){

    let drEvent = $(".dropify").dropify({
      messages: {
      default: "{{ trans('dashboard.general.hold_upload') }}",
      replace: "{{ trans('dashboard.general.hold_change') }}",
      remove: "{{ trans('dashboard.general.delete') }}",
      error: "{{ trans('dashboard.general.upload_error') }}",
    },
    error: {
      fileExtension: "{{ trans('dashboard.general.notAllowdedToUpload') }}",
      fileSize: "{{ trans('dashboard.general.upload_file_max') }} (5M max).",
    },
  });

  drEvent.on("dropify.afterClear", function (event, element) {
    $("#imageStatus").val(1);
  });
}

})();

</script>
