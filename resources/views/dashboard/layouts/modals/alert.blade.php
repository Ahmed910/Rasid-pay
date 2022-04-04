@if (session()->has("success"))
 @section('toast')
     <script>
         toastr.success("{{ session()->get("success") }}.", '', {
             closeButton: false,
             tapToDismiss: false,
             positionClass: 'toast-top-center',
             progressBar: true,
             hideDuration: 9000,
             rtl: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}"
         });
     </script>
 @endsection
@endif
@if (session()->has("info"))
 @section('toast')
     <script>
         toastr.info("{{ session()->get("info") }}.", '', {
             closeButton: false,
             tapToDismiss: false,
             positionClass: 'toast-top-center',
             progressBar: true,
             hideDuration: 9000,
             rtl: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}"
         });
     </script>
 @endsection
 @endif

 @if (session()->has("fail"))
 @section('toast')
     <script>
         toastr.error("{{ session()->get("fail") }}.", '', {
             closeButton: false,
             tapToDismiss: false,
             positionClass: 'toast-top-center',
             progressBar: true,
             hideDuration: 9000,
             rtl: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}"
         });
     </script>
 @endsection
 @endif
 @if(count($errors) > 0)
 @section('toast')
     <script>
        @foreach($errors->all() as $error)
        toastr['error']('{{ $error }}.', '', {
          closeButton: false,
          tapToDismiss: false,
          positionClass: 'toast-top-center',
          progressBar: true,
          hideDuration: 9000,
          rtl: "{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}"
        });
         @endforeach
     </script>
 @endsection
 @endif
