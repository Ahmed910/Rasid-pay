<!-- <div class="card custom px-5 py-5">
  <h5 class="card-title mb-0">المعلومات الأساسية</h5>
  <div class="card-body pb-0"> -->

<div class="card py-7 px-7">

  <div class="row">
    <div class="col-12 col-md-3 mb-5">

      @foreach ($locales as $locale)
        {!! Form::label('jobName', trans('dashboard.job.job_name')) !!}
        {!! Form::text("{$locale}[name]", isset($rasidJob) ? $rasidJob->name : null, ['class' => 'form-control', 'id' => 'departmentName', 'placeholder' => trans('dashboard.job.job_name') , 'required']) !!}
        {{--                <div class="invalid-feedback">اسم الوظيفة مطلوب.</div>--}}
          @error("${locale}.name")
          <span class="text-danger">{{ $message }}</span>
          @enderror
    </div>
    @endforeach
    <div class="col-12 col-md-3 mb-5">


      {!! Form::label('mainDepartment', trans('dashboard.department.department'), ['class' => 'd-block']) !!}


      {!! Form::select('department_id', $departments, null, ['class' => 'form-control select2-show-search', 'id' => 'mainDepartment', 'required', 'placeholder' =>  trans('dashboard.job.select_department')]) !!}
      @error('department_id')
      <span class="text-danger">{{ $message }}</span>
      @enderror
{{--      <div class="invalid-feedback">القسم مطلوب.</div>--}}
    </div>

    <div class="col-12 col-md-3 mb-5">
      {!! Form::label('employeName', trans('dashboard.job.employee_name')) !!}

      {!! Form::text('added_by_id', Auth::user()->fullname ?? null, ['class' => 'form-control', 'id' => 'employeName', 'placeholder' => Auth::user()->fullname ??"", 'disabled' ,]) !!}
      @error('added_by_id')
      <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    @foreach ($locales as $locale)
      <div class="col-12 col-md-9">
        {!! Form::label('departmentDes',trans('dashboard.job.job_description')) !!}
        {!! form::textarea("{$locale}[description]", isset($rasidJob) ? $rasidJob->description: null, ['class' => 'form-control', 'id' => 'departmentDes', 'placeholder' => trans('dashboard.job.job_description'), 'rows' => '5']) !!}

      </div>
    @endforeach

    @if (Route::currentRouteName() == 'dashboard.job.edit')
      <div class="col-12 col-md-3 mb-5">

        {!! Form::label('status', trans("dashboard.general.status"), ['class' => 'd-block']) !!}
        {!! Form::select('is_active', ['1' => trans('dashboard.general.active'), '0' => trans('dashboard.general.active')], $rasidJob->is_active, ['class' => 'form-control select2-show-search', 'id' => 'departmentStatus', 'required']) !!}
        <div class="invalid-feedback">الحالة مطلوبة.</div>
      </div>
      <div class="col-12 col-md-3 mb-5">
        {!! Form::label('jobType', trans("dashboard.general.type")) !!}
        {!! Form::text('is_vacant', $rasidJob->is_vacant?trans('dashboard.job.is_vacant.true'):trans('dashboard.job.is_vacant.false'), ['class' => 'form-control', 'placeholder' =>trans('dashboard.job.is_vacant.false') , 'disabled']) !!}
      </div>
    @endif

  </div>
</div>
<!-- </div>
</div> -->
<div class="row">
  <div class="col-12 mb-5 text-end">
    {!! Form::button('<i class="mdi mdi-content-save-outline"></i> '.trans("dashboard.general.save"), ['type' => 'button', 'class' => 'btn btn-primary ', 'data-bs-toggle' => 'modal', 'data-bs-target' => '#successModal']) !!}

    <a href="departments-record.html" class="btn btn-outline-primary" data-bs-toggle="modal"
       data-bs-target="#backModal">
      <i class="mdi mdi-arrow-left"></i> @lang("dashboard.general.back")
    </a>
  </div>
</div>
@include('dashboard.layouts.modals.confirm')
@include('dashboard.layouts.modals.back')
