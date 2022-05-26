@extends('dashboard.layouts.master')
@section('title', trans('dashboard.client.sub_progs.create'))

@section('content')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.card_package.index') }}">{{ trans('dashboard.card_package.cards_discount') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"> {{ trans('dashboard.general.add') }} </li>
            </ol>
        </nav>
    </div>
    <!-- PAGE-HEADER END -->
    <form action="{{ route('dashboard.card_package.store') }}" id="formId" method="POST">
        @csrf
        <div class="card px-7 py-7">
            <div class="row">
                <div class="col-12 col-md-6 mb-5">
                    <label for="client_id">{{ trans('dashboard.client.name') }}</label><span
                        class="requiredFields">*</span>
                    <select class="form-control select2-show-search" id="client_id" name="client_id">
                        <option selected disabled value="">{{ trans('dashboard.client.select_client') }}</option>
                        @foreach ($clients as $key => $clientName)
                            <option value="{{ $key }}"> {!! $clientName !!}</option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="client_idError" hidden></span>
                </div>

                <div class="col-12 col-md-6 mb-5">
                    <label for="discountRate">{{ trans('dashboard.card_package.basic_card_discount') }}</label><span
                        class="requiredFields">*</span>
                    <div class="input-group">
                        <input id="discountRate" type="number"
                            placeholder="{{ trans('dashboard.card_package.enter_discount') }}" class="form-control"
                            name="basic_discount" onpaste="return false" onCopy="return false" onCut="return false"
                            onDrag="return false" onDrop="return false" autocomplete=off />
                        <div class="input-group-text border-start-0">
                            %
                        </div>
                    </div>
                    <span class="text-danger" id="basic_discountError" hidden></span>

                </div>
                <div class="col-12 col-md-6 mb-5">
                    <label for="discountRate">{{ trans('dashboard.card_package.golden_card_discount') }}</label><span
                        class="requiredFields">*</span>
                    <div class="input-group">
                        <input id="discountRate" type="number"
                            placeholder="{{ trans('dashboard.card_package.enter_discount') }}" class="form-control"
                            name="golden_discount" onpaste="return false" onCopy="return false" onCut="return false"
                            onDrag="return false" onDrop="return false" autocomplete=off />
                        <div class="input-group-text border-start-0">
                            %
                        </div>
                    </div>
                    <span class="text-danger" id="golden_discountError" hidden></span>

                </div>
                <div class="col-12 col-md-6 mb-5">
                    <label for="discountRate">{{ trans('dashboard.card_package.platinum_card_discount') }}</label><span
                        class="requiredFields">*</span>
                    <div class="input-group">
                        <input id="discountRate" type="number"
                            placeholder="{{ trans('dashboard.card_package.enter_discount') }}" class="form-control"
                            name="platinum_discount" onpaste="return false" onCopy="return false" onCut="return false"
                            onDrag="return false" onDrop="return false" autocomplete=off />
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
                <button class="btn btn-primary" data-bs-toggle="modal" type="submit" id="saveButton">
                    <i class="mdi mdi-page-next-outline"></i> {{ trans('dashboard.general.save') }}
                </button>
                <button type="button" class="btn btn-outline-primary" id="showBack">

                    <i class="mdi mdi-arrow-left"></i> {{ trans('dashboard.general.back') }}
                </button>


            </div>
        </div>
    </form>




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
            $('#saveButton').on('click', function(e) {
                e.preventDefault();
                if (erroe) {
                    $('span[id*="Error"]').attr('hidden', true);
                    $('*input,select').removeClass('border-danger');
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
                    success: function() {
                        $('#successModal').modal('show');
                        toggleSaveButton();
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
                    $("#saveButton").html('<i class="spinner-border spinner-border-sm"></i>' +
                        "{{ trans('dashboard.general.save') }}");
                    $('#saveButton').attr('disabled', true);
                } else {
                    saveButton = true;
                    $("#saveButton").html('<i class="mdi mdi-content-save-outline"></i>' +
                        "{{ trans('dashboard.general.save') }}");
                    $('#saveButton').attr('disabled', false);
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
