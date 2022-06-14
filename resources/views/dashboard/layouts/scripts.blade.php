<script>
    function validateData(id) {

        if (id !== undefined) {
            var currentElement = $(`#${id}`).attr('name');

        }
        // var finalCurrentElement = currentElement.includes("[") ? (currentElement.replace("[", ".")).slice(0,-1) : currentElement;
        if (currentElement.includes("[")) {
            finalCurrentElement = (currentElement.replaceAll("[", ".")).slice(0, -1)
            if (finalCurrentElement.includes("]")) {
                finalCurrentElement = (finalCurrentElement.replaceAll("]", ""))
            }
        } else {
            finalCurrentElement = currentElement
        }

        let lang = '{{ app()->getLocale() }}';
        let resource_name = '{{ request()->segment(3) }}';
        var firstSpan = $(`#${id}`).parent().hasClass("input-group") ? $(`#${id}`).parent().nextAll('span:first') : $(`#${id}`).nextAll('span:first')

        var formData = $('#formId').serialize();

        $.ajax({
            url: `{{ url('/dashboard/${resource_name}') }}`
            , type: 'post'
            , data: formData,

            error: function(errors) {

                var errs = errors.responseJSON.errors;
                var formvalues = $('#formId').serializeArray();

                formvalues.forEach(function(item, index) {
                    name = item.name

                    finalItem = name.includes("[") ? (name.replaceAll("[", ".")).slice(0, -1) : name;
                    if (name.includes("[")) {
                        finalItem = (name.replaceAll("[", ".")).slice(0, -1)
                        if (finalItem.includes("]")) {
                            finalItem = (finalItem.replaceAll("]", ""))
                        }
                    } else {
                        finalItem = name
                    }
                    
                    if (finalItem == finalCurrentElement) {

                        firstSpan.removeAttr('hidden')
                        firstSpan.text(errs[finalCurrentElement][0])
                        // console.log(currentElement)
                    }
                })
            }
        });
    }
    (function() {
        "use strict";

        let validate = false;
        let saveButton = true;

        $("#saveButton").on("click", function(e) {
            e.preventDefault();

            $('span[id*="Error"]').attr("hidden", true);
            $("*input,select,.select2-selection").removeClass("border-danger");

            let form = $("#formId")[0];
            let data = new FormData(form);

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                , }
            , });

            $.ajax({
                url: $("#formId").attr("action")
                , type: "POST"
                , data: data
                , beforeSend: toggleSaveButton()
                , processData: false
                , contentType: false
                , cache: false
                , success: function() {
                    $("#successModal").modal("show");
                    toggleSaveButton();
                }
                , error: function(data) {
                    toggleSaveButton();

                    if (data.status == 401) {
                        window.location.reload(true)
                    }

                    $.each(data.responseJSON.errors, function(name, message) {
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
                }
            , });
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

        $("#showBack").click(function() {
            if (validate) {
                $("#backModal").modal("show");
                return false;
            } else {
                window.location.href = "{{ route('dashboard.backButton') }}";
            }
        });

        $("input,select,textarea").change(function() {
            validate = true;
        });

        if ($(".dropify").length) {

            let drEvent = $(".dropify").dropify({
                messages: {
                    default: "{{ trans('dashboard.general.hold_upload') }}"
                    , replace: "{{ trans('dashboard.general.hold_change') }}"
                    , remove: "{{ trans('dashboard.general.delete') }}"
                    , error: "{{ trans('dashboard.general.upload_error') }}"
                , }
                , error: {
                    fileExtension: "{{ trans('dashboard.general.notAllowdedToUpload') }}"
                    , fileSize: "{{ trans('dashboard.general.upload_file_max') }} (5M max)."
                , }
            , });

            drEvent.on("dropify.afterClear", function(event, element) {
                $("#imageStatus").val(1);
            });
        }

    })();

</script>
