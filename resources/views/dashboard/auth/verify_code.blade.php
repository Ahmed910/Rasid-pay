@extends('dashboard.auth.master')

@section('content')

<h3 class="text-center mt-5">رمز التحقق</h3>
<p class="text-center">
    من فضلك قم بإدخال كود التفعيل المرسل على رقم جوالك<br />
    <span style="direction: ltr; display: block">{{ $phone }}</span>
</p>
<!-- FORM OPEN -->

<form method="post" action="{!! route('dashboard.check_sms_code') !!}" class="needs-validation" novalidate>
    @csrf
    <input type="hidden" name="reset_token" value="{{ $reset_token }}">
    <div class="row col-12 col-md-8 m-auto">
        <div class="col">
            <input type="tel" class="form-control text-center" name="reset_code[]" required maxlength="1" />
        </div>
        <div class="col">
            <input type="tel" class="form-control text-center" name="reset_code[]" required maxlength="1" />
        </div>
        <div class="col">
            <input type="tel" class="form-control text-center" name="reset_code[]" required maxlength="1" />
        </div>
        <div class="col">
            <input type="tel" class="form-control text-center" name="reset_code[]" required maxlength="1" />
        </div>

        <div class="text-center m-auto">
            <p class="mt-5">
                <span id="countdown"> </span>
                <i class="mdi mdi-timer-outline"></i>
            </p>
            <a class="disable resend">إعادة إرسال كود التفعيل؟</a>
        </div>
    </div>

    <div class="col-12 mt-5 text-center">
        <a onclick="checkSmsCode()" class="btn btn-primary">إرسال</a>
        <a href="{!! route('dashboard.reset') !!}" class="btn btn-outline-primary">
            عودة
        </a>
    </div>
</form>
@endsection
@section('scripts')
<script>
    function checkSmsCode() {
        var form = $('form');
        var actionUrl = form.attr('action');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function(data) {
                form.submit(); // show response from the php script.
            },
            error: function(err) {
                console.log(err.responseJSON);
            }
        });
    }
</script>
@endsection
