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
<form method="post" action="{!! route('dashboard.passwords.reset.new_password') !!}" class="needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label>كلمة المرور الجديدة</label>
        <div class="input-group" id="show_hide_password">
            <input class="form-control @error('password') is-invalid @enderror" placeholder="كلمة المرور" type="password" name="password"/>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            <div class="input-group-text bg-white border-start-0">
                <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
            </div>
        </div>
    </div>
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">
    <div class="form-group">
        <label>تأكيد كلمة المرور </label>
        <div class="input-group" id="show_hide_confirm_password">
            <input class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="كلمة المرور" type="password" name="password_confirmation"/>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            <div class="input-group-text bg-white border-start-0">
                <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
            </div>
        </div>
    </div>
    <div class="col-12 mt-5 text-center">
        {!! Form::submit('تأكيد',['class' => "btn btn-primary"]) !!}
        <a href="{!! route('dashboard.login') !!}" class="btn btn-outline-primary">
            عودة
        </a>
    </div>

</form>
@endsection
