@extends('dashboard.layouts.master')
@section('title', trans('dashboard.general.create'))

@section('content')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.client_package.index') }}">{{ trans('dashboard.package.cards_discount') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"> {{ trans('dashboard.general.add') }} </li>
            </ol>
        </nav>
    </div>
    <!-- PAGE-HEADER END -->

    {!! Form::open(['route' => 'dashboard.client_package.store', 'method' => 'POST', 'id' => 'formId' , 'autocomplete'=>"off"]) !!}

         @include('dashboard.client_package._form')

    {!! Form::close() !!}




    @include('dashboard.layouts.modals.confirm')
    @include('dashboard.layouts.modals.back')
    @include('dashboard.layouts.modals.alert')

@section('scripts')
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/fileupload.js"></script>
    <script src="{{ asset('dashboardAssets') }}/plugins/fileuploads/js/file-upload.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script src="{{ asset('dashboardAssets/js/custom_scripts.js') }}"></script>
@endsection
@endsection
