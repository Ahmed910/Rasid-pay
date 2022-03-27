@extends('dashboard.auth.master')

@section('content')
        <h3 class="text-center mt-5">{{ trans('auth.login_title') }}</h3>
        <p class="text-center">
          {{ trans('auth.login_subtitle')}}
        </p>
        <!-- FORM OPEN -->

        <form
          method="post"
          action="{{ route('dashboard.post_login') }}"
          class="needs-validation"
          novalidate
        >
        @csrf
          <div class="form-group">
            <label for="userID">{{ trans('auth.userID')}}</label>
            <input
               oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
    type = "number"
    pattern="^[1-9]\d*$"
    maxlength = "6"
              class="form-control @error('username') is-invalid @enderror"
              id="userID"
              name="username"
              value="{{ old('username') }}"
              placeholder="{{ trans('auth.userID')}}"
            />
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label>{{ trans('auth.password')}}</label>
            <div class="input-group" id="show_hide_password">
              <input
                class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ trans('auth.password')}}"
                name="password"
                type="password"
              />
              @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="input-group-text border-start-0">
                <a href=""
                  ><i class="mdi mdi-eye-off-outline d-flex"></i
                ></a>
              </div>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col">
              <label class="custom-control custom-checkbox mb-0">
                <input type="checkbox" class="custom-control-input" name="remember" />
                <span class="custom-control-label">{{ trans('auth.remember')}}</span>
              </label>
            </div>
            <div class="col text-end">
             <a href="{!! route('dashboard.reset') !!}">{{ trans('auth.reset_password')}}</a>
            </div>
          </div>
          {!! Form::submit(trans('auth.login_title'),['class' => "btn btn-primary w-100 mt-5"]) !!}
        </form>
        <!-- FORM CLOSED -->
@endsection
