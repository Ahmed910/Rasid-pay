@if (session()->has("success"))
 @section('toast')
     <script>
         toast('success','{{ session()->get("success") }}.',"{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}");
     </script>
 @endsection
@endif
@if (session()->has("info"))
 @section('toast')
     <script>
         toast('info','{{ session()->get("info") }}.',"{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}");
     </script>
 @endsection
 @endif

 @if (session()->has("fail"))
 @section('toast')
     <script>
         toast('error','{{ session()->get("fail") }}.',"{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}");
     </script>
 @endsection
 @endif
 @if(count($errors) > 0)
 @section('toast')
     <script>
        @foreach($errors->all() as $error)
        toast('error','{{ $error }}.',"{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' }}");
         @endforeach
     </script>
 @endsection
 @endif
