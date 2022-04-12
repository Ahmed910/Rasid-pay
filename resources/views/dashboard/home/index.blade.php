@extends('dashboard.layouts.master')

@section('content')

<div class="page-header">
  <h1 class="page-title">الرئيسية</h1>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<!-- <div class="row statistics">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                <div class="row">
                  <div class="col-lg-6 col-md-12 col-sm-12 col-xl-3">
                    <div class="card overflow-hidden">
                      <div class="card-body">
                        <div class="d-flex">
                          <div class="mt-2">
                            <h6 class="">إجمالي عدد المستخدمين</h6>
                            <h2 class="mb-0 number-font">44,278</h2>
                          </div>
                          <div class="ms-auto">
                            <i class="mdi mdi-account-outline mdi-48px"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-12 col-sm-12 col-xl-3">
                    <div class="card overflow-hidden">
                      <div class="card-body">
                        <div class="d-flex">
                          <div class="mt-2">
                            <h6 class="">إجمالي عدد الأقسام</h6>
                            <h2 class="mb-0 number-font">50</h2>
                          </div>
                          <div class="ms-auto">
                            <i
                              class="mdi mdi-view-dashboard-outline mdi-48px"
                            ></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-12 col-sm-12 col-xl-3">
                    <div class="card overflow-hidden">
                      <div class="card-body">
                        <div class="d-flex">
                          <div class="mt-2">
                            <h6 class="">إجمالي الربح</h6>
                            <h2 class="mb-0 number-font">67,987 ريال</h2>
                          </div>
                          <div class="ms-auto">
                            <i class="mdi mdi-cash-multiple mdi-48px"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6 col-md-12 col-sm-12 col-xl-3">
                    <div class="card overflow-hidden">
                      <div class="card-body">
                        <div class="d-flex">
                          <div class="mt-2">
                            <h6 class="">إجمالي الوظائف</h6>
                            <h2 class="mb-0 number-font">3254</h2>
                          </div>
                          <div class="ms-auto">
                            <i
                              class="mdi mdi-briefcase-variant-outline mdi-48px"
                            ></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
<div class="row">
  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
    <div class="card bg-primary img-card box-primary-shadow">
      <a href="{{ route('dashboard.department.index') }}">

      <div class="card-body">
        <div class="d-flex">
          <div class="text-white">
            <h2 class="mb-0 number-font">{{ $departments }}</h2>
            <p class="text-white mb-0">{{ trans('dashboard.general.Total_departments') }}</p>
          </div>
          <div class="ms-auto">
            <i class="fa fa-envelope-o text-white fs-30 me-2 mt-2"></i>
          </div>
        </div>
      </div>
      </a>
    </div>
  </div>
  <!-- COL END -->
  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
    <div class="card bg-secondary img-card box-secondary-shadow">
      <a href="{{ route('dashboard.employee.index') }}">
      <div class="card-body">
        <div class="d-flex">
          <div class="text-white">
            <h2 class="mb-0 number-font">{{ $employees }}</h2>
            <p class="text-white mb-0">{{ trans('dashboard.general.Total_employees') }}</p>
          </div>
          <div class="ms-auto">
            <i class="fa fa-user-o text-white fs-30 me-2 mt-2"></i>
          </div>
        </div>
      </div>
      </a>
    </div>
  </div>
  <!-- COL END -->
  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
    <div class="card bg-success img-card box-success-shadow">
      <a href="{{ url('dashboard/admin?ban_status=active') }}">

      <div class="card-body">
        <div class="d-flex">
          <div class="text-white">
            <h2 class="mb-0 number-font">{{ $Active_users }}</h2>
            <p class="text-white mb-0">{{ trans('dashboard.general.Total_active_users') }}</p>
          </div>
          <div class="ms-auto">
            <i class="fa fa-user-o text-white fs-30 me-2 mt-2"></i>
          </div>
        </div>
      </div>
      </a>
    </div>
  </div>
  <!-- COL END -->
  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
    <div class="card bg-info img-card box-info-shadow">
      <a href="{{ url('dashboard/admin?ban_status=permanent') }}">
      <div class="card-body">
        <div class="d-flex">
          <div class="text-white">
            <h2 class="mb-0 number-font">{{ $permanent_users }}</h2>
            <p class="text-white mb-0">{{ trans('dashboard.general.Total_permenant_users') }}</p>
          </div>
          <div class="ms-auto">
            <i class="fa fa-user-o text-white fs-30 me-2 mt-2"></i>
          </div>
        </div>
      </div>
      </a>
    </div>
  </div>
  <!-- COL END -->
  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
    <div class="card bg-info img-card box-info-shadow">
      <a href="{{ url('dashboard/admin?ban_status=temporary') }}">
      <div class="card-body">
        <div class="d-flex">
          <div class="text-white">
            <h2 class="mb-0 number-font">{{ $temporary_users }}</h2>
            <p class="text-white mb-0">{{ trans('dashboard.general.Total_temporary_users') }}</p>
          </div>
          <div class="ms-auto">
            <i class="fa fa-user-o text-white fs-30 me-2 mt-2"></i>
          </div>
        </div>
      </div>
      </a>
    </div>
  </div>
  <!-- COL END -->
  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
    <div class="card bg-info img-card box-info-shadow">
      <a href="{{ url('dashboard/rasid_job?is_vacant=1') }}">
      <div class="card-body">
        <div class="d-flex">
          <div class="text-white">
            <h2 class="mb-0 number-font">{{ $vacant_jobs }}</h2>
            <p class="text-white mb-0">{{ trans('dashboard.general.Total_vacant_jobs') }}</p>
          </div>
          <div class="ms-auto">
            <i class="fa fa-envelope-o text-white fs-30 me-2 mt-2"></i>
          </div>
        </div>
      </div>
      </a>
    </div>
  </div>
   <!-- COL END -->
   <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
    <div class="card bg-info img-card box-info-shadow">
      <a href="{{ url('dashboard/rasid_job?is_vacant=0') }}">
      <div class="card-body">
        <div class="d-flex">
          <div class="text-white">
            <h2 class="mb-0 number-font">{{ $unvacant_jobs }}</h2>
            <p class="text-white mb-0">{{ trans('dashboard.general.Total_unvacant_jobs') }}</p>
          </div>
          <div class="ms-auto">
            <i class="fa fa-envelope-o text-white fs-30 me-2 mt-2"></i>
          </div>
        </div>
      </div>
      </a>
    </div>
  </div>

</div>
<!-- <div class="row row-cards">
              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card">
                  <div class="card-header pb-0 border-bottom-0">
                    <h3 class="card-title">Total Revenue</h3>
                    <div class="card-options">
                      <a
                        class="btn btn-sm btn-primary"
                        href="javascript:void(0)"
                        ><i class="fa fa-bar-chart mb-0"></i
                      ></a>
                    </div>
                  </div>
                  <div class="card-body pt-0">
                    <h3 class="d-inline-block mb-2">46,789</h3>
                    <div class="progress h-2 mt-2 mb-2">
                      <div
                        class="progress-bar bg-primary"
                        style="width: 50%"
                        role="progressbar"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card">
                  <div class="card-header pb-0 border-bottom-0">
                    <h3 class="card-title">Total Requests</h3>
                    <div class="card-options">
                      <a
                        class="btn btn-sm btn-success"
                        href="javascript:void(0)"
                        ><i class="fa fa-send-o mb-0"></i
                      ></a>
                    </div>
                  </div>
                  <div class="card-body pt-0">
                    <h3 class="d-inline-block mb-2">23,536</h3>
                    <div class="progress h-2 mt-2 mb-2">
                      <div
                        class="progress-bar bg-success"
                        style="width: 50%"
                        role="progressbar"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card">
                  <div class="card-header pb-0 border-bottom-0">
                    <h3 class="card-title">Requests Answered</h3>
                    <div class="card-options">
                      <a
                        class="btn btn-sm btn-warning"
                        href="javascript:void(0)"
                        ><i class="fa fa-mail-reply mb-0"></i
                      ></a>
                    </div>
                  </div>
                  <div class="card-body pt-0">
                    <h3 class="d-inline-block mb-2">32,784</h3>
                    <div class="progress h-2 mt-2 mb-2">
                      <div
                        class="progress-bar bg-warning"
                        style="width: 50%"
                        role="progressbar"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <div class="card">
                  <div class="card-header pb-0 border-bottom-0">
                    <h3 class="card-title">Support Cost</h3>
                    <div class="card-options">
                      <a
                        class="btn btn-sm btn-danger"
                        href="javascript:void(0)"
                        ><i class="fa fa-money mb-0"></i
                      ></a>
                    </div>
                  </div>
                  <div class="card-body pt-0">
                    <h3 class="d-inline-block mb-2">14,563</h3>
                    <div class="progress h-2 mt-2 mb-2">
                      <div
                        class="progress-bar bg-danger"
                        style="width: 50%"
                        role="progressbar"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

@endsection
