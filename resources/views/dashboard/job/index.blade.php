@extends('dashboard.layouts.master')
@section('title')
job Grid
@endsection

@section('content')

        <div class="page-header">
          <h1 class="page-title">سجل الوظائف</h1>
          <a href="{{route('dashboard.job.create')}}" class="btn btn-primary">
            <i class="mdi mdi-plus-circle-outline"></i> إضافة وظيفة
          </a>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- FORM OPEN -->
        <form method="get" action="{{ route('dashboard.job.index') }}">
          <div class="row align-items-end mb-3">
            <div class="col">
              <label for="job_name">{{ trans('dashboard.job.job_name') }}</label>

              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('dashboard.job.job_name'), 'id' => 'job_name']) !!}
            </div>
            <div class="col">
              <label for="mainDepartment"> {{ trans('dashboard.department.department') }} </label>

              {!! Form::select('department_id', $departments, null, ['placeholder' => trans('dashboard.job.select_department'),'class' => 'form-control select2-show-search select2-hidden-accessible select2 select2-container  select2-container--below', 'id' => 'mainDepartment',] , ) !!}
            </div>
            <div class="col">
              <label for="from-hijri-picker"> {{ trans('dashboard.general.from_date') }}</label>
              <div class="input-group">

                {!! Form::text('from_date', null, ['class' => 'form-control', 'readonly', 'id' => 'from-hijri-picker-custom']) !!}
                <div class="input-group-text border-start-0">
                  <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
              </div>
            </div>
            <div class="col">
              <label for="to-hijri-picker"> {{ trans('dashboard.general.to_date') }}</label>
              <div class="input-group">

                {!! Form::text('to_date', null, ['class' => 'form-control', 'placeholder' => 'يوم/شهر/سنة', 'readonly', 'id' => 'to-hijri-picker-custom']) !!}

                <div class="input-group-text border-start-0">
                  <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
              </div>
            </div>
            <div class="col">
              <label for="status">{{ trans('dashboard.general.status') }}</label>
              <select name = "is_active" class="form-control select2" id="status">
                <option selected disabled value="">
                  {{ trans('dashboard.general.select_status') }}
                </option>
                <option value="">{{ trans('dashboard.general.all') }}</option>
                <option value=1>{{ trans('dashboard.general.active') }}</option>
                <option value=0>{{ trans('dashboard.general.inactive') }}</option>
              </select>
            </div>

            <div class="col">
              <label for="type">{{ trans('dashboard.general.type') }}</label>
              <select class="form-control select2" id="type" name="is_vacant">
                <option selected disabled value="">{{ trans('dashboard.general.select_type') }}</option>
                <option value="">{{ trans('dashboard.general.all') }}</option>
                <option value=1>{{ trans('dashboard.job.is_vacant.false') }}</option>
                <option value=0>{{ trans('dashboard.job.is_vacant.true') }}</option>
              </select>
            </div>

          </div>
          <div class="row">
            <div class="col-12 col-md-6 my-2">
              <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button"
                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-tray-arrow-down"></i> تصدير
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="#">PDF</a></li>
                  <li><a class="dropdown-item" href="#">Excel</a></li>
                </ul>
              </div>
            </div>
            <div class="col-12 col-md-6 my-2 d-flex justify-content-end">
              <button class="btn btn-primary mx-2" type="submit">
                <i class="mdi mdi-magnify"></i> {{ trans('dashboard.general.search') }}
              </button>
              <button class="btn btn-outline-primary" type="submit">
                <i class="mdi mdi-restore"></i> {{ trans('dashboard.general.show_all') }}
              </button>
            </div>
          </div>

        </form>

        <!-- FORM CLOSED -->
        <!-- Row -->
        <div class="row row-sm">
          <div class="col-lg-12">
            <div class="table-responsive p-1">
              <table id="JobsTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
                <thead>
                <tr>
                  <th class="border-bottom-0">#</th>
                  <th class="border-bottom-0">{{ trans('dashboard.job.job_name') }}</th>

                  <th class="border-bottom-0">{{ trans('dashboard.department.department') }} </th>
                  <th class="border-bottom-0">{{ trans('dashboard.general.created_at') }} </th>
                  <th class="border-bottom-0">{{ trans('dashboard.general.status') }}</th>
                  <th class="border-bottom-0">{{ trans('dashboard.general.type') }}</th>
                  <th class="border-bottom-0 text-center">{{ trans('dashboard.general.actions') }}</th>
                </tr>
                </thead>
                <tbody>


                    @foreach($rasidJobs as $rasidJob)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                        <td>{{$rasidJob->name}}</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              <img
                                src="https://picsum.photos/seed/picsum/100"
                                width="25"
                                class="avatar brround cover-image"
                                alt="..."
                                data-toggle="popoverIMG"
                              />
                            </div>
                            <div class="flex-grow-1 ms-3">
                              {{-- {{$rasidJob->department->name }} --}}
                            </div>
                          </div>
                        </td>

                        <td>{{$rasidJob->created_at}}</td>
                        <td>
                          <span class="badge bg-success-opacity py-2 px-4"
                            >{{$rasidJob->is_active === 1 ? 'مفعلة ': 'معطلة ' }}</span
                          >
                        </td>
                        <td>
                          <span class="vacant">{{$rasidJob->is_vacant === 1 ? 'شاغرة ': 'مشغولة ' }}</span>
                        </td>
                        <td class="text-center">
                          <a
                            href="{{route('dashboard.job.show',$rasidJob->id)}}"
                            class="azureIcon"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="عرض"
                            ><i class="mdi mdi-eye-outline"></i
                          ></a>
                          <a
                            href="{{route('dashboard.job.edit',$rasidJob->id)}}"
                            class="warningIcon"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="تعديل"
                            ><i class="mdi mdi-square-edit-outline"></i
                          ></a>
                          <a
                            href="#"
                            class="primaryIcon"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="أرشفة"
                            ><i
                              data-bs-toggle="modal"
                              data-bs-target="#archiveModal"
                              class="mdi mdi-archive-arrow-down-outline"
                            ></i
                          ></a>
                        </td>
                      </tr>
                      @endforeach


                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- End Row -->

@endsection
@include('dashboard.job.script')
