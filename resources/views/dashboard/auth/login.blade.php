@extends('dashboard.auth.master')

@section('content')
    <div class="col-12 col-md-7 d-flex align-center">
      <div class="card m-auto w-60 p-9">
        <img
          src="assets/images/brand/Rasid-Jack-Logo-V.svg"
          width="150"
          alt=""
          class="mb-5"
        />
        <h3 class="text-center mt-5">تسجيل دخول</h3>
        <p class="text-center">
          من فضلك قم بإدخال بريدك الإلكتروني وكلمة المرور
        </p>
        <!-- FORM OPEN -->

        <form
          method="post"
          action="{{ route('dashboard.post_login') }}"
          class="needs-validation"
          novalidate
        >
          <div class="form-group">
            <label for="userID">رقم المستخدم</label>
            <input
              type="text"
              class="form-control"
              id="userID"
              name="username"
              placeholder="رقم المستخدم"
              required
            />
            <div class="invalid-feedback">رقم المستخدم مطلوب.</div>
          </div>

          <div class="form-group">
            <label>كلمة المرور</label>
            <div class="input-group" id="show_hide_password">
              <input
                class="form-control border-end-0"
                placeholder="كلمة المرور"
                name="password"
                type="password"
              />
              <div class="input-group-text bg-white border-start-0">
                <a href=""
                  ><i class="mdi mdi-eye-off-outline d-flex"></i
                ></a>
              </div>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col">
              <label class="custom-control custom-checkbox mb-0">
                <input type="checkbox" class="custom-control-input" />
                <span class="custom-control-label">تذكرني</span>
              </label>
            </div>
            <div class="col text-end">
              <a href="reset.html">استعادة كلمة المرور؟</a>
            </div>
          </div>
            <a href="index.html" class="btn btn-primary d-block mt-5" type="submit"
              >تسجيل دخول</a
            >
        </form>
        <!-- FORM CLOSED -->
      </div>
    </div>
@endsection
