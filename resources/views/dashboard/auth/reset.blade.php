@extends('dashboard.auth.master')

@section('content')

        {{-- <form class="login100-form validate-form"> --}}
          <h3 class="text-center mt-5">إستعادة كلمةالمرور</h3>
          <p class="text-center">
            من فضلك قم بإدخال بريدك الإلكتروني أو رقم جوالك لإرسال كود
            التفعيل
          </p>
          <div class="panel panel-primary">
            <div class="tab-menu-heading">
              <div class="tabs-menu1">
                <!-- Tabs -->
                <ul class="nav panel-tabs">
                  <li class="mx-0">
                    <a href="#tab5" class="active" data-bs-toggle="tab"
                      >البريد الإلكتروني</a
                    >
                  </li>
                  <li class="mx-0">
                    <a href="#tab6" data-bs-toggle="tab">رقم الجوال</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="panel-body tabs-menu-body p-0 pt-5">
              <div class="tab-content">
                <div class="tab-pane active" id="tab5">
                  <!-- FORM OPEN -->
                  <form
                    action=""
                    method="post"
                    class="needs-validation"
                    novalidate
                  >
                  @csrf
                  {!! Form::hidden('send_type', 'email') !!}
                    <div class="form-group">
                      <label for="email">البريد الإلكتروني</label>
                      <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        placeholder="البريد الإلكتروني"
                        required
                      />
                      <div class="invalid-feedback">
                        البريد الإلكتروني مطلوب.
                      </div>
                    </div>
                    <div class="col-12 mt-5 text-center">
                      {!! Form::submit('إرسال', ['class' => "btn btn-primary",'formaction' => route('dashboard.post_reset')]) !!}
                      <a
                        href="{!! route('dashboard.login') !!}"
                        class="btn btn-outline-primary"
                      >
                        عودة
                      </a>
                    </div>
                  </form>
                  <!-- FORM CLOSED -->
                </div>
                <div class="tab-pane" id="tab6">
                  <!-- FORM OPEN -->
                  <form
                    action="{!! route('dashboard.post_reset') !!}"
                    method="post"
                    class="needs-validation"
                    novalidate
                  >
                  @csrf
                  {!! Form::hidden('send_type', 'phone') !!}
                    <div class="form-group">
                      <label for="mobile">رقم الجوال</label>
                      <input
                        type="number"
                        class="form-control @error('phone') is-invalid @enderror"
                        id="mobile"
                        name="phone"
                        placeholder="رقم الجوال"
                        required
                      />
                      <div class="invalid-feedback">
                        رقم الجوال مطلوب.
                      </div>
                    </div>
                    <div class="col-12 mt-5 text-center">
                      {!! Form::submit('إرسال', ['class' => "btn btn-primary",'formaction' => route('dashboard.post_reset')]) !!}
                      <a
                        href="{!! route('dashboard.login') !!}"
                        class="btn btn-outline-primary"
                      >
                        عودة
                      </a>
                    </div>
                  </form>
                  <!-- FORM CLOSED -->
                </div>
              </div>
            </div>
          </div>
@endsection
