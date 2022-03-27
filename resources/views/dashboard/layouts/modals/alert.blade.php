@if (session()->has("success"))
 @section('notify')
     <script>
         $.Toast("Success", "{{ session()->get("success") }}.", "success", {
             has_icon:false,
             has_close_btn:true,
             stack: true,
             fullscreen:false,
             timeout:8000,
             sticky:false,
             has_progress:true,
             position_class:"toast-top-right",
             rtl:"{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}",
         });
     </script>
 @endsection
@endif
@if (session()->has("info"))
 @section('notify')
     <script>
         $.Toast("Info", "{{ session()->get("info") }}.", "info", {
             has_icon:false,
             has_close_btn:true,
             stack: true,
             fullscreen:false,
             timeout:8000,
             sticky:false,
             has_progress:true,
             position_class:"toast-top-right",
             rtl:"{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}",
         });
     </script>
 @endsection
 @endif

 @if (session()->has("fail"))
 @section('notify')
     <script>
         $.Toast("Error", "{{ session()->get("fail") }}.", "error", {
             has_icon:false,
             has_close_btn:true,
             stack: true,
             fullscreen:false,
             timeout:8000,
             sticky:false,
             has_progress:true,
             position_class:"toast-top-right",
             rtl:"{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}",
         });
     </script>
 @endsection
 @endif
 @if(count($errors) > 0)
 @section('notify')
     <script>
        @foreach($errors->all() as $error)
         $.Toast("Error", "{{ $error }}.", "error", {
             has_icon:false,
             has_close_btn:true,
             stack: true,
             fullscreen:false,
             timeout:8000,
             sticky:false,
             has_progress:true,
             position_class:"toast-top-right",
             rtl:"{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}",
         });
         @endforeach
     </script>
 @endsection
 @endif
