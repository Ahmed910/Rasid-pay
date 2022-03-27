@if (session()->has("success"))
 @section('notify')
     <script>
         toastr.success("{{ session()->get("success") }}.", "success", {
             has_icon:false,
             has_close_btn:true,
             stack: true,
             fullscreen:false,
             timeout:8000,
             sticky:false,
             has_progress:true,
             position_class:"toast-top-left",
             rtl:"{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}",
         });
     </script>
 @endsection
@endif
@if (session()->has("info"))
 @section('notify')
     <script>
         toastr.info("{{ session()->get("info") }}.", "info", {
             has_icon:false,
             has_close_btn:true,
             stack: true,
             fullscreen:false,
             timeout:8000,
             sticky:false,
             has_progress:true,
             position_class:"toast-top-left",
             rtl:"{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}",
         });
     </script>
 @endsection
 @endif

 @if (session()->has("fail"))
 @section('notify')
     <script>
         toastr.error("{{ session()->get("fail") }}.", "error", {
             has_icon:false,
             has_close_btn:true,
             stack: true,
             fullscreen:false,
             timeout:8000,
             sticky:false,
             has_progress:true,
             position_class:"toast-top-left",
             rtl:"{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}",
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
