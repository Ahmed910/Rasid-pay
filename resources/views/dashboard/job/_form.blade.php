<!-- <div class="card custom px-5 py-5">
  <h5 class="card-title mb-0">المعلومات الأساسية</h5>
  <div class="card-body pb-0"> -->

<div class="card py-7 px-7">
    <div class="row">
        <div class="col-12 col-md-3 mb-5">

            @foreach ($locales as $locale)
                {!! Form::label('jobName', 'اسم الوظيفة') !!}
                {!! Form::text("{$locale}[name]", Route::currentRouteName() == 'dashboard.job.edit'? $rasidJob->name : null, ['class' => 'form-control', 'id' => 'departmentName', 'placeholder' => 'اسم الوظيفة', 'required']) !!}


                <div class="invalid-feedback">اسم الوظيفة مطلوب.</div>
        </div>
        @endforeach

        <div class="col-12 col-md-3 mb-5">



            {!! Form::label('mainDepartment', 'القسم', ['class' => 'd-block']) !!}


            {!! Form::select('department_id', $departments, null, ['class' => 'form-control select2-show-search', 'id' => 'mainDepartment', 'required', 'placeholder' => 'اختر قسم رئيسي']) !!}

            <div class="invalid-feedback">القسم مطلوب.</div>
        </div>

        <div class="col-12 col-md-3 mb-5">
            {!! Form::label('employeName', 'اسم الموظف') !!}

            {!! Form::text(null, null, ['class' => 'form-control', 'id' => 'employeName', 'placeholder' => 'هشام أشرف', 'disabled']) !!}

        </div>
        @foreach ($locales as $locale)
            <div class="col-12 col-md-9">

                {!! Form::label('departmentDes', 'الوصف الوظيفي') !!}
                {!! form::textarea("{$locale}[description]", Route::currentRouteName() == 'dashboard.job.edit'? $rasidJob->description: null, ['class' => 'form-control', 'id' => 'departmentDes', 'placeholder' => 'الوصف', 'rows' => '5']) !!}

            </div>
        @endforeach

        @if (Route::currentRouteName() == 'dashboard.jobs.edit')
            <div class="col-12 col-md-3 mb-5">

                {!! Form::label('status', 'الحالة', ['class' => 'd-block']) !!}
                {!! Form::select('is_active', ['1' => 'مفعلة', '0' => 'معطلة'], $rasidJob->is_active, ['class' => 'form-control select2-show-search', 'id' => 'departmentStatus', 'required']) !!}
                <div class="invalid-feedback">الحالة مطلوبة.</div>
            </div>
            <div class="col-12 col-md-3 mb-5">
                {!! Form::label('jobType', 'النوع') !!}
                {!! Form::text('is_vacant', $rasidJob->is_vacant, ['class' => 'form-control', 'placeholder' => 'مشغولة', 'disabled']) !!}
            </div>
        @endif

    </div>
</div>
<!-- </div>
</div> -->
<div class="row">
    <div class="col-12 mb-5 text-end">
        {!! Form::button('<i class="mdi mdi-content-save-outline"></i> حفظ', ['type' => 'button', 'class' => 'btn btn-primary ', 'data-bs-toggle' => 'modal', 'data-bs-target' => '#successModal']) !!}

        <a href="departments-record.html" class="btn btn-outline-primary" data-bs-toggle="modal"
            data-bs-target="#backModal">
            <i class="mdi mdi-arrow-left"></i> عودة
        </a>
    </div>
</div>
