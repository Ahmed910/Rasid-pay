@extends('dashboard.auth.master')

@section('content')

<h3 class="text-center mt-5">اعادة تعيين كلمة المرور</h3>
<p class="text-center">
    من فضلك قم بادخال كلمة المرور الجديدة وتأكيدها
</p>
<!-- FORM OPEN -->
@error('email','token')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<form method="post" id="email-form" action="{!! route('dashboard.passwords.reset.new_password') !!}" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label>كلمة المرور الجديدة</label>
        <div class="input-group" id="show_hide_password">
            <input class="form-control stop-copy-paste @error('password') is-invalid @enderror" placeholder="كلمة المرور" type="password" name="password"/>
            <div class="input-group-text border-start-0">
                <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
            </div>
        </div>
        <span class="text-danger" id="password_error"></span>
    </div>
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">
    <div class="form-group">
        <label>تأكيد كلمة المرور </label>
        <div class="input-group" id="show_hide_confirm_password">
            <input class="form-control stop-copy-paste @error('password_confirmation') is-invalid @enderror" placeholder="كلمة المرور" type="password" name="password_confirmation"/>
            <div class="input-group-text border-start-0">
                <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
            </div>
        </div>
        <span class="text-danger" id="password_confirmation_error"></span>
    </div>
    <div class="col-12 mt-5 text-center">
      <a onclick="submitForm('#email-form')" class="btn btn-primary a-submit">{{ trans('dashboard.general.confirm') }}</a>

        {{-- {!! Form::submit('تأكيد',['class' => "btn btn-primary"]) !!} --}}
        <a href="{!! route('dashboard.login') !!}" class="btn btn-outline-primary">
          {{ trans('dashboard.general.back') }}
        </a>
    </div>

</form>
@endsection
@section('scripts')
<script>
     toastr.options.target = null
</script>
@endsection
