@if (session()->has("success"))
 @section('notify')
     <script>
         toastr.success("{{ session()->get("success") }}.", '', {
             closeButton: false,
             tapToDismiss: false,
             positionClass: 'toast-top-left',
             progressBar: true,
             hideDuration: 9000,
             rtl: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}"
         });
     </script>
 @endsection
@endif
@if (session()->has("info"))
 @section('notify')
     <script>
         toastr.info("{{ session()->get("info") }}.", '', {
             closeButton: false,
             tapToDismiss: false,
             positionClass: 'toast-top-left',
             progressBar: true,
             hideDuration: 9000,
             rtl: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}"
         });
     </script>
 @endsection
 @endif

 @if (session()->has("fail"))
 @section('notify')
     <script>
         toastr.error("{{ session()->get("fail") }}.", '', {
             closeButton: false,
             tapToDismiss: false,
             positionClass: 'toast-top-left',
             progressBar: true,
             hideDuration: 9000,
             rtl: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}"
         });
     </script>
 @endsection
 @endif
 @if(count($errors) > 0)
 @section('notify')
     <script>
        @foreach($errors->all() as $error)
        toastr['error']('{{ $error }}.', '', {
          closeButton: false,
          tapToDismiss: false,
          positionClass: 'toast-top-left',
          progressBar: true,
          hideDuration: 9000,
          rtl: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}"
        });
         @endforeach
     </script>
 @endsection
 @endif
