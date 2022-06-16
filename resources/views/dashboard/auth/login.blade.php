@extends('dashboard.auth.master')

@section('content')
    <h3 class="text-center mt-5">{{ trans('auth.login_title') }}</h3>
    <p class="text-center">
        {{ trans('auth.login_subtitle') }}
    </p>

<form method="post" action="{{ route('dashboard.post_login') }}" class="needs-validation" id="login-form" novalidate>
  @csrf
  <div class="form-group">
    <label for="userID">{{ trans('auth.userID')}}</label>
    <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" pattern="^[1-9]\d*$" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" maxlength="10" class="form-control stop-copy-paste number-regex @error('username') is-invalid @enderror"
           id="userId" name="username"
    value="{{ old('username') }}"
    placeholder="{{ trans('auth.your_userID')}}"
    />
    <span class="text-danger" id="username_error"></span>
  @if($errors->has('username'))
      <div class="invalid-feedback">{{ array_first($errors->messages()['username']) }}</div>
    @endif
  </div>
  <div class="form-group" id="password">
    <label>{{ trans('auth.password')}}</label>
    <div class="input-group" id="show_hide_password">
      <input class="form-control stop-copy-paste @error('password') is-invalid @enderror"
      placeholder="{{ trans('auth.password')}}"
      type="password"  name="password"
      />
      @error('password')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
      <div class="input-group-text border-start-0" >
        <a href=""><i class="mdi mdi-eye-off-outline d-flex"></i></a>
      </div>
    </div>
    <span class="text-danger" id="password_error"></span>
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
  {{-- <a onclick="submitForm('#login-form')" class="btn btn-primary w-100 mt-5 a-submit">{{ trans('auth.login_title') }}</a> --}}
  {!! Form::submit(trans('auth.login_title'),['class' => "btn btn-primary w-100 mt-5" ]) !!}
</form>
@endsection

@section('styles')
    <style>
        #login-id {
            border-color: transparent !important;
        },
        .error {
            color: red;
         }
    </style>
@endsection

@section('scripts')
   <script>
   // trends form validation
        $("#login-form").validate({
        onfocusout: function(element) {$(element).css('color', 'black').valid()},
        errorPlacement: function errorPlacement(error, element) {
           if (element.attr("type") == "password") {
            span = element.parent().nextAll('span:first')
        } else {
             span = element.nextAll('span:first')
        }

            span.removeAttr('hidden')
            span.text(error[0].innerText)
        },
        rules: {
                password: {required:true},
                username: {required:true,number: true},
            },
        messages: {
                password: {
                    required: '{{__('validation.required', ['attribute' => __('dashboard.admin.password')])}}'

                },
                 username: {
                    required: '{{__('validation.required', ['attribute' => __('dashboard.admin.login_id')])}}',
                    numeric: '{{__('validation.string', ['attribute' => __('dashboard.admin.login_id')])}}',
                },
           }
        });
   </script>
@endsection
