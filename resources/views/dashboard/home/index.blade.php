@extends('dashboard.layouts.master')

@section('content')
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <!-- PAGE-HEADER -->
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
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="text-white">
                                        <h2 class="mb-0 number-font">7,865</h2>
                                        <p class="text-white mb-0">Total Followers</p>
                                    </div>
                                    <div class="ms-auto">
                                        <i class="fa fa-user-o text-white fs-30 me-2 mt-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- COL END -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="card bg-secondary img-card box-secondary-shadow">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="text-white">
                                        <h2 class="mb-0 number-font">86,964</h2>
                                        <p class="text-white mb-0">Total Likes</p>
                                    </div>
                                    <div class="ms-auto">
                                        <i class="fa fa-heart-o text-white fs-30 me-2 mt-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- COL END -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="card bg-success img-card box-success-shadow">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="text-white">
                                        <h2 class="mb-0 number-font">98</h2>
                                        <p class="text-white mb-0">Total Comments</p>
                                    </div>
                                    <div class="ms-auto">
                                        <i class="fa fa-comment-o text-white fs-30 me-2 mt-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- COL END -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="card bg-info img-card box-info-shadow">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="text-white">
                                        <h2 class="mb-0 number-font">893</h2>
                                        <p class="text-white mb-0">Total Posts</p>
                                    </div>
                                    <div class="ms-auto">
                                        <i class="fa fa-envelope-o text-white fs-30 me-2 mt-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- COL END -->
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

                <!-- ROW-1 END -->

            </div>
            <!-- CONTAINER END -->
        </div>
    </div>
@endsection
