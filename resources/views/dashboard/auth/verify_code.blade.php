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
<form method="POST" action="{!! route('dashboard.check_sms_code') !!}" class="needs-validation" id="form_sms" novalidate>
    @csrf
    <input type="hidden" name="reset_token" value="{{ $reset_token }}">
     <div class="row col-12 col-md-8 m-auto" dir="ltr">
                  <div class="col">
                    <input
                       type="text" oninput='digitValidate(this)' onkeyup='tabChange(1)'
                      class="form-control text-center   @error('reset_code') border-danger @enderror"  name="reset_code[]"
                      required
                      maxlength="1"
                    />
                  </div>
                  <div class="col">
                    <input
                       type="text" oninput='digitValidate(this)' onkeyup='tabChange(2)'
                      class="form-control text-center   @error('reset_code') border-danger @enderror"  name="reset_code[]"
                      required
                      maxlength="1"
                    />
                  </div>
                  <div class="col">
                    <input
                       type="text" oninput='digitValidate(this)' onkeyup='tabChange(3)'
                      class="form-control text-center   @error('reset_code') border-danger @enderror"  name="reset_code[]"
                      required
                      maxlength="1"
                    />
                  </div>
                  <div class="col">
                    <input
                       type="text" oninput='digitValidate(this)' onkeyup='tabChange(4)'
                      class="form-control text-center   @error('reset_code') border-danger @enderror"  name="reset_code[]"
                      required
                      maxlength="1"
                    />
                  </div>
                </div>
    @error('reset_code')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="text-center m-auto">
        <p class="mt-5">
            <span id="countdown"> </span>
            <i class="mdi mdi-timer-outline"></i>
        </p>
        <a class="disable resend">إعادة إرسال كود التفعيل؟</a>
    </div>

    <div class="col-12 mt-5 text-center">
        {!! Form::submit('إرسال',['class' => "btn btn-primary"]) !!}
        <a href="{!! route('dashboard.login') !!}" class="btn btn-outline-primary">
            عودة
        </a>
    </div>
</form>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        function countdown(elementName, minutes, seconds) {
          var element, endTime, hours, mins, msLeft, time;

          function twoDigits(n) {
            return n <= 9 ? "0" + n : n;
          }

          function updateTimer() {
            msLeft = endTime - +new Date();
            if (msLeft < 1000) {
              element.innerHTML = "تم انتهاء صلاحية الكود!";
              $(".resend").removeClass("disable");
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

        $(".resend").click(function () {
          countdown("countdown", 0, 30);
          $(this).addClass("disable");
        });
      });
  let digitValidate = function(ele){
  console.log(ele.value);
  ele.value = ele.value.replace(/[^0-9]/g,'');
}

let tabChange = function(val){
    let ele = document.querySelectorAll('input');
    if(ele[val-1].value != ''){
      ele[val].focus()
    }else if(ele[val-1].value == ''){
      ele[val-2].focus()
    }   
 }

</script>
@endsection