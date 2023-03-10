@extends('dashboard.auth.master')

@section('content')
    <h3 class="text-center mt-5">رمز التحقق</h3>
    <p class="text-center">
        من فضلك قم بإدخال رمز التحقق المرسل على رقم جوالك<br />
        <span style="direction: ltr; display: block">{{ $phone }}</span>
       
    </p>
    <!-- FORM OPEN -->
    @error('reset_token')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <form method="POST" id="verify-form" action="{!! route('dashboard.check_sms_code') !!}" class="needs-validation" id="form_sms" novalidate>
        @csrf
        <input type="hidden" name="reset_token" value="{{ $reset_token }}">
        <div class="row col-12 col-md-8 m-auto" dir="ltr">
            <div class="col">
                <input type="text" oninput='digitValidate(this)' onkeyup='tabChange(1)'
                    class="inputs-code form-control text-center stop-copy-paste @error('reset_code') border-danger @enderror"
                    name="reset_code[]" required maxlength="1" />
            </div>
            <div class="col">
                <input type="text" oninput='digitValidate(this)' onkeyup='tabChange(2)'
                    class="inputs-code form-control text-center stop-copy-paste  @error('reset_code') border-danger @enderror"
                    name="reset_code[]" required maxlength="1" />
            </div>
            <div class="col">
                <input type="text" oninput='digitValidate(this)' onkeyup='tabChange(3)'
                    class="inputs-code form-control text-center stop-copy-paste @error('reset_code') border-danger @enderror"
                    name="reset_code[]" required maxlength="1" />
            </div>
            <div class="col">
                <input type="text" oninput='digitValidate(this)' onkeyup='tabChange(4)'
                    class="inputs-code form-control text-center  stop-copy-paste  @error('reset_code') border-danger @enderror"
                    name="reset_code[]" required maxlength="1" />
            </div>
        </div>
        <span class="text-danger" id="reset_code_error"></span>
        @error('reset_code')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <div class="text-center m-auto">
            <p class="mt-5">
                <span id="countdown"> </span>
                <i class="mdi mdi-timer-outline"></i>
            </p>
            <a href ="#!" class="disable resend">إعادة إرسال رمز التحقق؟</a>
        </div>

        <div class="col-12 mt-5 text-center">
            <a onclick="submitForm('#verify-form')" class="btn btn-primary mx-3 a-submit"
                id="code-submit">{{ trans('dashboard.general.confirm') }}</a>

            {{-- {!! Form::submit(trans('dashboard.general.confirm'), ['class' => 'btn btn-primary', 'id' => 'code-submit']) !!} --}}
            <a href="{!! url()->previous() !!}" class="btn btn-outline-primary">
                {{ trans('dashboard.general.back') }}
            </a>
        </div>
    </form>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            function countdown(elementName, minutes, seconds) {
                var element, endTime, hours, mins, msLeft, time;

                function twoDigits(n) {
                    return n <= 9 ? "0" + n : n;
                }

                function updateTimer() {
                    msLeft = endTime - +new Date();
                    if (msLeft < 1000) {
                        element.innerHTML = "تم انتهاء صلاحية الكود!";
                        $(".resend").removeClass("disable").attr('href',"{{ route('dashboard.resend_code',request('token')) }}");
                        $(".inputs-code").attr('disabled',true);
                        $('#code-submit').addClass('disable');
                        $('form').addClass('disable_form');
                        $(".a-submit").attr('disabled',true);
                    } else {
                        time = new Date(msLeft);
                        hours = time.getUTCHours();
                        mins = time.getUTCMinutes();
                        element.innerHTML =
                            (hours ? hours + ":" + twoDigits(mins) : mins) +
                            ":" +
                            twoDigits(time.getUTCSeconds());
                        setTimeout(updateTimer, time.getUTCMilliseconds() + 500);
                    }
                }

                element = document.getElementById(elementName);
                endTime = +new Date() + 1000 * (60 * minutes + seconds) + 500;
                updateTimer();
            }

            countdown("countdown", 0, 30);

            $(".resend").click(function(e) {
                if($(this).hasClass('disable')) {
                  return e.preventDefault();
                }

                countdown("countdown", 0, 30);
                $(this).addClass("disable");
            });
        });

        let digitValidate = function(ele) {
            ele.value = ele.value.replace(/[^0-9]/g, "");
        };

        let tabChange = function(val) {
            let ele = document.querySelectorAll(".inputs-code");
            if (ele[val - 1].value != "") {
                ele[val].focus();
            } else if (ele[val - 1].value == "") {
                ele[val - 2].focus();
            }
        };

         $("#verify-form").validate({
            onfocusout: function(element) {$(element).css('color', 'black').valid()},

            errorPlacement: function errorPlacement(error, element) {
               $('#reset_code_error').text(error[0].innerText)
            },
            success: function(label,element) {
                $('#reset_code_error').text("");
            },
            rules: {
                    "reset_code[]": {required:true,number:true},
                },
            messages: {
                    "reset_code[]": {
                        required: '{{__('validation.required', ['attribute' => __('dashboard.general.reset_code')])}}',
                        number: '{{__('validation.numeric', ['attribute' => __('dashboard.general.reset_code')])}}',
                    },
              }

        });

    </script>
@endsection

@section('styles')
    <style>
        #code-submit {
            border-color: transparent !important;
        }

    </style>
@endsection
