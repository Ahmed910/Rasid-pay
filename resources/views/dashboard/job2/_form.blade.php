
<div class="card py-7 px-7">
    <div class="row">

        @foreach (config('translatable.locales') as $locale)

            <div class="col-12 col-md-3 mb-5">
                <label for="job_name">{{ trans('dashboard.job.job_name') }}</label>

                {!! Form::text($locale . '[name]', isset($job) ? $job->translate($locale)->name : null, ['class' => 'form-control', 'placeholder' => trans('dashboard.job.job_name'), 'required' => 'required', 'id' => 'job_name']) !!}

            </div>
        @endforeach

        <div class="col-12 col-md-3 mb-5">
            <label class="d-block" for="mainDepartment">{{ trans('dashboard.job.department') }}</label>

            {!! Form::select('department_id', $departments, null, ['class' => 'form-control select2-show-search', 'placeholder' => trans('dashboard.job.select_department'), 'id' => 'mainDepartment']) !!}

            {{-- <div class="invalid-feedback">القسم مطلوب.</div> --}}
        </div>

        <div class="col-12 col-md-3 mb-5">
            <label class="d-block" for="departmentStatus">{{ trans('dashboard.job.status') }}</label>
            {{-- <select
              class="form-control select2"
              id="departmentStatus"
              required
            >
              <option selected disabled value="">{{ trans('dashboard.job.select_status') }}</option>
              <option>مفعلة</option>
              <option>معطلة</option>
            </select> --}}
            {!! Form::select('is_active', [true => trans('dashboard.job.is_active.active'), false => trans('dashboard.job.is_active.disactive')], isset($job) ? $job->is_active : trans('dashboard.job.select_status'), ['class' => 'form-control select2', 'placeholder' => trans('dashboard.job.select_status'), 'id' => 'mainDepartment']) !!}

            {{-- <div class="invalid-feedback">الحالة مطلوبة.</div> --}}
        </div>

        <div class="col-12 col-md-3 mb-5">
            <label class="d-block" for="jobType">{{ trans('dashboard.job.type') }}</label>
            {{-- <input
              type="text"
              class="form-control"
              id="jobType"
              placeholder="مشغولة"
              disabled
            /> --}}
            {!! Form::text('is_vacant', trans('dashboard.job.is_vacant.true'), ['class' => 'form-control', 'disabled' => 'disabled', 'id' => 'jobType']) !!}

        </div>
        <div class="col-12 col-md-3 mb-5">
            <label for="added_by">{{ trans('dashboard.job.employee_name') }}</label>

            {!! Form::text('added_by_id',auth()->id() ?? null, ['class' => 'form-control', 'placeholder' => auth()->user()->fullname ?? 'احمد ابوطالب' , 'readonly', 'id' => 'added_by']) !!}
        </div>

        @foreach (config('translatable.locales') as $locale)
            <div class="col-12 col-md-9">
                <label for="description">{{ trans('dashboard.job.job_description') }}</label>

                {!! Form::textarea($locale . '[description]', isset($job) ? $job->translate($locale)->description : null, ['class' => 'form-control', 'placeholder' => trans('dashboard.job.job_description'), 'id' => 'description']) !!}
            </div>
        @endforeach
    </div>
</div>
<!-- </div>
      </div> -->
<div class="row">
    <div class="col-12 mb-5 text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successModal" type="submit">
            <i class="mdi mdi-content-save-outline"></i> {{ trans('dashboard.general.save') }}
        </button>
        <a href="departments-record.html" class="btn btn-outline-primary" data-bs-toggle="modal"
            data-bs-target="#backModal">
            <i class="mdi mdi-arrow-left"></i> عودة
        </a>
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
