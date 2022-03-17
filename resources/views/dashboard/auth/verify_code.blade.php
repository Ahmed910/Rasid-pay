@extends('dashboard.auth.master')

@section('content')

<h3 class="text-center mt-5">رمز التحقق</h3>
<p class="text-center">
    من فضلك قم بإدخال كود التفعيل المرسل على رقم جوالك<br />
    <span style="direction: ltr; display: block">{{ $phone }}</span>
</p>
<!-- FORM OPEN -->

<form method="POST" action="{!! route('dashboard.check_sms_code') !!}" class="needs-validation" id="form_sms" novalidate>
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
        {!! Form::submit('إرسال',['class' => "btn btn-primary"]) !!}
        <a href="{!! route('dashboard.reset') !!}" class="btn btn-outline-primary">
            عودة
        </a>
    </div>
</form>
@endsection
