@extends('dashboard.auth.master')

@section('content')

  {{-- <form class="login100-form validate-form"> --}}
  <h3 class="text-center mt-5">{{ trans('auth.reset_password')}}</h3>
  <p class="text-center">
    {{ trans('auth.reset_subtitle')}}
  </p>
  <div class="panel panel-primary">
    <div class="tab-menu-heading">
      <div class="tabs-menu1">
        <!-- Tabs -->
        <ul class="nav panel-tabs">
          <li class="mx-0">
            <a href="#tab5" class="{{ !$errors->any() || $errors->has('email') ? 'active' : null }}" data-bs-toggle="tab"
            >{{trans('dashboard.general.email')}}</a
            >
          </li>
          <li class="mx-0">
            <a href="#tab6" class="@error('phone') active @enderror" data-bs-toggle="tab">{{ trans('dashboard.general.phone')}}</a>
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
            id="email-reset-password"
            novalidate
          >
            @csrf
            <div class="form-group">
              <label for="email">{{trans('dashboard.general.email')}}</label>
              <input  onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off
                      type="text"
                      class="form-control @error('email') is-invalid @enderror"
                      id="email"
                      name="email"
                      value="{{ old('email') }}"
                      placeholder="{{trans('dashboard.general.email')}}"

              />
              @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <span class="text-danger" id="email_error"></span>
            </div>
            <div class="col-12 mt-5 text-center">
              {!! Form::submit(trans('dashboard.general.send'), ['class' => "btn btn-primary m-1",'id' => 'resend_btn','formaction' => route('dashboard.post_reset')]) !!}
              <a
                href="{!! route('dashboard.login') !!}"
                class="btn btn-outline-primary m-1"
              >
                {{trans('dashboard.general.back')}}
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
            id="phone-reset-password"
            class="needs-validation"
            novalidate
          >
            @csrf


            <div class="form-group">
              <label for="mobile">{{trans('dashboard.general.phone')}}</label>
              <div class="input-group">
              <input  onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off
                      type="number"
                      class="form-control number-regex @error('phone') is-invalid @enderror"
                      id="mobile"
                      name="phone"
                      value="{{ old('phone') }}"
                      placeholder="{{trans('dashboard.general.phone')}}"
              />

              @error('phone')
              <div class="invalid-feedback reset-phone">{{ $message }}</div>

              @enderror
              <div class="input-group-text border-start-0" dir="ltr" style="position:absolute;z-index:3 ;">
                +966
              </div>
              </div>
               <span class="text-danger" id="phone_error"></span>
            </div>
            <div class="col-12 mt-5 text-center">
              {!! Form::submit(trans('dashboard.general.send'), ['class' => "btn btn-primary m-1",'id' => 'resend_btn','formaction' => route('dashboard.post_reset')]) !!}
              <a
                href="{!! route('dashboard.login') !!}"
                class="btn btn-outline-primary m-1"
              >
                {{trans('dashboard.general.back')}}
              </a>
            </div>
          </form>
          <!-- FORM CLOSED -->
        </div>
      </div>
    </div>
  </div>
@endsection
@section('styles')
  <style>
    #resend_btn{
      border-color: transparent !important;
    }
  </style>
@endsection
@section('scripts')
<script>
   $("#phone-reset-password").validate({
        onfocusout: function(element) {$(element).css('color', 'black').valid()},
        errorPlacement: function errorPlacement(error, element) {
           span = element.parent().nextAll('span:first')
            span.text(error[0].innerText)
        },
        rules: {
                phone: {required:true,number:true,minlength:5,maxlength:20},

            },
        messages: {
                phone: {
                    required: '{{__('validation.required', ['attribute' => __('dashboard.general.phone')])}}',
                    number: '{{__('validation.numeric', ['attribute' => __('dashboard.general.phone')])}}',
                    minlength: '{{__('validation.min.numeric', ['attribute' => __('dashboard.general.phone'),'min'=>'5'])}}',
                    maxlength: '{{__('validation.max.numeric', ['attribute' => __('dashboard.general.phone'),'max'=>'20'])}}'
                },

           }
        });

         $("#email-reset-password").validate({
        onfocusout: function(element) {$(element).css('color', 'black').valid()},
        errorPlacement: function errorPlacement(error, element) {

           span = element.nextAll('span:first')
            span.text(error[0].innerText)
        },
        rules: {
                email: {required:true,email:true},
            },
        messages: {
                email: {
                    required: '{{__('validation.required', ['attribute' => __('dashboard.general.email')])}}',
                    email: '{{__('validation.email', ['attribute' => __('dashboard.general.email')])}}',

                },

           }
        });
</script>
@endsection
