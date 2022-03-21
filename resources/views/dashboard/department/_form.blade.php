<div class="card py-7 px-7">
    <div class="row">
        <div class="col-12 col-md-4 mb-5">
            {!! Form::label('departmentName', 'اسم القسم') !!}
            @foreach ($locales as $locale)
                {!! Form::text("{$locale}[name]", isset($department)  ? $department->name : null, ['class' => 'form-control ', 'id' => 'departmentName', 'placeholder' => 'اسم القسم']) !!}
                @if ($errors->has("{$locale}[name]"))
                    <span class="invalid-feedback">{{ $errors->first("{$locale}[name]") }}</span>
                @endif
            @endforeach
        </div>
        <div class="col-12 col-md-4 mb-5">
            {!! Form::label('mainDepartment', 'القسم الرئيسي') !!}
            {!! Form::select('parent_id', $departments, null, ['class' => 'form-control select2', 'id' => 'mainDepartment', 'required', 'placeholder' => 'اختر قسم رئيسي']) !!}
            @if ($errors->has('parent_id'))
                <span class="invalid-feedback">{{ $errors->first('parent_id') }}</span>
            @endif
        </div>

        <div class="col-12 col-md-4 mb-5">
            {!! Form::label('status', ' الحالة') !!}
            {!! Form::select('is_active', ['1' => 'مفعل', '0' => 'غير مفعل'], null, ['class' => 'form-control select2', 'id' => 'status', 'placeholder' => 'اختر الحالة']) !!}
            @if ($errors->has('is_active'))
                <span class="invalid-feedback">{{ $errors->first('is_active') }}</span>
            @endif
        </div>
        <div class="col-12">
            {!! Form::label('departmentImg', 'صورة القسم (JPG, PNG, JPEG, DWG)') !!}
            {!! Form::file('image', ['class' => 'dropify', 'data-show-remove' => 'true', 'data-default-file'=> isset($department) && count($department->images) > 0 ? asset("{$department->images[0]->media}") : '','data-bs-height' => '250', 'id' => 'departmentImg', 'data-errors-position' => 'inside', 'data-show-errors' => 'true', 'data-show-loader' => 'true', 'data-allowed-file-extensions' => 'jpg png jpeg dwg']) !!}
            @if ($errors->has('image'))
                <span class="invalid-feedback">{{ $errors->first('image') }}</span>
            @endif
        </div>
        <div class="col-12">
            {!! Form::label('departmentDes', ' الوصف') !!}
            @foreach ($locales as $locale)
                {!! Form::textarea("{$locale}[description]",  isset($department) ? $department->description : null, ['class' => 'form-control ', 'id' => 'departmentDes', 'rows' => '3', 'placeholder' => 'الوصف']) !!}
                @if ($errors->has("{$locale}[description]"))
                    <span class="invalid-feedback">{{ $errors->first("{$locale}[description]") }}</span>
                @endif
            @endforeach
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-5 text-end">
        {!! Form::button('<i class="mdi mdi-content-save-outline"></i> حفظ', ['type' => 'button', 'class' => 'btn btn-primary ', 'data-bs-toggle' => 'modal', 'data-bs-target' => '#successModal']) !!}
        @include('dashboard.layouts.modals.confirm')
        <a href="{{ route('dashboard.department.index') }}" class="btn btn-outline-primary" data-bs-toggle="modal"
            data-bs-target="#backModal">
            <i class="mdi mdi-arrow-left"></i> عودة
        </a>
        @include('dashboard.layouts.modals.back')
    </div>
</div>


@section('scripts')

    <!-- SELECT2 JS -->
    <script src="{{ asset('dashboardAssets/js/select2.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/select2/select2.full.min.js') }}"></script>
    <!-- FORMVALIDATION JS -->
    <script src="{{ asset('dashboardAssets/js/form-validation.js') }}"></script>

    <!-- FILE UPLOADES JS -->
    <script src="{{ asset('dashboardAssets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ asset('dashboardAssets/plugins/fileuploads/js/file-upload.js') }}"></script>

@endsection
