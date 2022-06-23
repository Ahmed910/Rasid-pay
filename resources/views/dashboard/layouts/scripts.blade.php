<script>
  function validateData(item) {

        let itemId = $(item).attr('id');
        let form = $(item).closest('form');

        if (item !== undefined) {
            var currentElement = $(`#${itemId}`).attr('name');

        }

        let finalCurrentElement = replaceInValidation(currentElement)
        let lang = '{{ app()->getLocale() }}';
        let resource_name = form.attr('action');
        let firstSpan = getSpanError(itemId);

        $.ajax({
            url: resource_name
            , type: 'post'
            , data: form.serialize(),

            error: function(errors) {

                var errs = errors.responseJSON.errors;
                var formvalues = $('#formId').serializeArray();

                formvalues.forEach(function(item, index) {
                    name = item.name

                    //  finalItem = name.includes("[") ? (name.replaceAll("[", ".")).slice(0, -1) : name;
                    let finalItem = replaceInValidation(name)

                    if (finalItem == finalCurrentElement) {
                          checkInputValidaty(errs[finalCurrentElement],firstSpan)
                    }else{
                       checkInputValidaty(errs[finalCurrentElement],firstSpan)
                    }


                })
            },
            success: function(){
               firstSpan.attr('hidden')
               firstSpan.text('')
            }

        });
    }


    function checkInputValidaty(validatedElement, span) {
        if (validatedElement == undefined) {
            span.attr('hidden')
            span.text('')
        } else {

            span.removeAttr('hidden')
            span.text(validatedElement[0])
        }
    }

    function replaceInValidation(element) {

        if (element.includes("[")) {
            finalCurrentElement = element.slice(0, -1);
            finalCurrentElement = finalCurrentElement.endsWith('[') ? finalCurrentElement.slice(0, -1) : finalCurrentElement.replaceAll("[", ".")
            if (finalCurrentElement.includes("]")) {
                finalCurrentElement = (finalCurrentElement.replaceAll("]", ""))
            }
        } else {
            finalCurrentElement = element
        }
        return finalCurrentElement;
    }

    let getSpanError = itemId => {
        if ($(`#${itemId}`).parent().hasClass("input-group")) {
            span = $(`#${itemId}`).parent().nextAll('span:first')
        } else if ($(`#${itemId}`).is("select")) {
            span = $(`#${itemId}`).nextAll('span:last')
        } else {
            span = $(`#${itemId}`).nextAll('span:first')
        }
        return span;
    }

    (function() {
        "use strict";

        let validate = false;
        let saveButton = true;

        $("#saveButton").on("click", function(e) {
            if (!validate) {
                $("#notChangeModal").modal("show");
                return false;
            };

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

        $(".showBack").click(function() {
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


        $("input,select,textarea").not('.dropify').on('drop dragstart',function(event) {
            event.preventDefault();
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
