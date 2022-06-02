@extends('dashboard.layouts.master')
@section('title', trans('dashboard.general.edit'))

@section('content')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.card_package.index') }}">{{ trans('dashboard.card_package.cards_discount') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"> {{ trans('dashboard.general.edit') }} </li>
            </ol>
        </nav>
    </div>
    <!-- PAGE-HEADER END -->

    {!! Form::model($card_package, ['route' => ['dashboard.card_package.update', $card_package->id], 'method' => 'PUT', 'id' => 'formId']) !!}

    @include('dashboard.card_package._form')

    {!! Form::close() !!}




    @include('dashboard.layouts.modals.not_change')
    @include('dashboard.layouts.modals.confirm')
    @include('dashboard.layouts.modals.back')
    @include('dashboard.layouts.modals.alert')

@section('scripts')
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/fileupload.js"></script>
    <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/file-upload.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>

    <script>
        (function() {
            'use strict';
            let validate = false;
            let saveButton = true;

            let erroe = false;
            $('#submitButton').on('click', function(e) {
                e.preventDefault();
                if (erroe) {
                    $('span[id*="Error"]').attr('hidden', true);
                    $('*input,select').removeClass('border-danger');
                    erroe = false;
                }


                let form = $('#formId')[0];
                let data = new FormData(form);

                let originalData = {!! json_encode($card_package->only('client_id', 'basic_discount', 'golden_discount', 'platinum_discount')) !!};
                let originalDataArr = Object.values(originalData);

                //capture users inputs
                let userClientID = $('form').find('input[name="client_id"]').val();
                let userBasicDiscount = $('form').find('input[name="basic_discount"]').val();
                let userGoldenDiscount = $('form').find('input[name="golden_discount"]').val();
                let userPlatinumDiscount = $('form').find('input[name="platinum_discount"]').val();

                let userFields = [userClientID, userBasicDiscount, userGoldenDiscount, userPlatinumDiscount];
                var is_same = (originalDataArr.length == userFields.length) && originalDataArr.every(function(element, index) {
                    return element === userFields[index];
                });

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
                        if (is_same) {
                            $('#notChangeModal').modal('show');
                            toggleSaveButton();
                        } else {
                            $('#successModal').modal('show');
                            toggleSaveButton();
                        }

                    },
                    error: function(data) {
                        toggleSaveButton();

                        $.each(data.responseJSON.errors, function(name, message) {
                            erroe = true;
                            let inputName = name;
                            let inputError = name + 'Error';

                            if (inputName.includes('.')) {
                                let convertArray = inputName.split('.');
                                inputName = convertArray[0] + '[' + convertArray[1] + ']'
                            }

                            $('input[name="' + inputName + '"]').addClass('border-danger');
                            $('select[name="' + inputName + '"]').addClass('border-danger');
                            $('span[id="' + inputError + '"]').attr('hidden', false);
                            $('span[id="' + inputError + '"]').html(
                                `<small>${message}</small>`);
                        });
                    }
                });
            });

            function toggleSaveButton() {
                if (saveButton) {
                    saveButton = false;
                    $("#submitButton").html('<i class="spinner-border spinner-border-sm"></i>' +
                        "{{ trans('dashboard.general.save') }}");
                    $('#submitButton').attr('disabled', true);
                } else {
                    saveButton = true;
                    $("#submitButton").html('<i class="mdi mdi-content-save-outline"></i>' +
                        "{{ trans('dashboard.general.save') }}");
                    $('#submitButton').attr('disabled', false);
                }
            }

            $("#showBack").click(function() {
                let validate = false;
                $('#formId input').each(function() {
                    if ($(this).attr('name') !== '_token' && ($(this).val() != '' || $(this).attr(
                            'checked')))
                        validate = true;
                });
                if (validate) {
                    $('#backModal').modal('show');
                    return false;
                } else {
                    window.location.href = "{{ route('dashboard.card_package.index') }}";
                }
            });

        })();
    </script>
@endsection
@endsection
