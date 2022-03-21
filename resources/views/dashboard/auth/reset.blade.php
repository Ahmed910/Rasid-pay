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
                    <a href="#tab5" class="{{ !$errors->any() || $errors->has('email') ? 'active' : null }}" data-bs-toggle="tab"
                      >البريد الإلكتروني</a
                    >
                  </li>
                  <li class="mx-0">
                    <a href="#tab6" class="@error('phone') active @enderror" data-bs-toggle="tab">رقم الجوال</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="panel-body tabs-menu-body p-0 pt-5">
              <div class="tab-content">
                <div class="tab-pane {{ !$errors->any() || $errors->has('email') ? 'active' : null }}" id="tab5">
                  <!-- FORM OPEN -->
                  <form
                    action=""
                    method="post"
                    class="needs-validation"
                    novalidate
                  >
                  @csrf
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
                      @error('email')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
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
                <div class="tab-pane  @error('phone') active @enderror" id="tab6">
                  <!-- FORM OPEN -->
                  <form
                    action=""
                    method="post"
                    class="needs-validation"
                    novalidate
                  >
                  @csrf
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
                      @error('phone')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
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
