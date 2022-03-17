@extends('dashboard.auth.master')

@section('content')

<h3 class="text-center mt-5">اعادة تعيين كلمة المرور</h3>
<p class="text-center">
    من فضلك قم بادخال كلمة المرور الجديدة وتأكيدها
</p>
<!-- FORM OPEN -->

<form method="post" action="{!! route('dashboard.') !!}" class="needs-validation" novalidate>
    <div class="form-group">
        <label>كلمة المرور الجديدة</label>
        <div class="input-group" id="show_hide_password">
            <input class="form-control" placeholder="كلمة المرور" type="password" />
            <div class="input-group-text bg-white border-start-0">
                <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>تأكيد كلمة المرور </label>
        <div class="input-group" id="show_hide_confirm_password">
            <input class="form-control" placeholder="كلمة المرور" type="password" />
            <div class="input-group-text bg-white border-start-0">
                <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
            </div>
        </div>
    </div>
    <div class="col-12 mt-5 text-center">
        <a href="login.html" class="btn btn-primary">
            تأكيد
        </a>
        <a href="verifyCode.html" class="btn btn-outline-primary">
            عودة
        </a>
    </div>

</form>
@endsection
