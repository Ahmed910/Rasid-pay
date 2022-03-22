@extends('dashboard.layouts.master')

@section('title')
    Create Job
@endsection
@section('content')
    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="jobs-record.html"> سجل الوظائف</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                إضافة وظيفة
                            </li>
                        </ol>
                    </nav>
                </div>
                <!-- PAGE-HEADER END -->

                <!-- ROW OPEN -->
                {!! Form::open(['route'=>'dashboard.job.store', 'method' => 'POST', 'class' => 'needs-validation novalidate','id'=>'formId']) !!}
                @include('dashboard.job._form')
                {!! form::close() !!}

                {{-- </form> --}}
                <!-- ROW CLOSED -->
            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>
    <!--app-content closed-->
    </div>

    <!-- Confirm Modal -->
    @include('dashboard.layouts.modals.save')
    <!-- Back Modal -->
    <div class="modal fade" id="backModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-body text-center p-0">
                    <lottie-player autoplay loop mode="normal" src="{{asset('dashboardassets/images/lottie/back.json')}}"
                        style="width: 55%; display: block; margin: 0 auto 1em">
                    </lottie-player>
                    <p>هل تريد العودة دون الحفظ؟</p>
                </div>
                <div class="modal-footer d-flex justify-content-center mt-5 p-0">
                    <button type="button" class="btn btn-warning mx-3 " onClick="backsubmit()">موافق</button>
                    <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">
                        غير موافق
                    </button>
                </div>
            </div>
        </div>
    </div>



    <script language="javascript" type="text/javascript">
        function submitDetailsForm() {
           $("#formId").submit();
        }
    </script>
@endsection
