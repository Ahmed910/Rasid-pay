@extends('dashboard.layouts.master')
@section('title')
Jobs Grid
@endsection
@section('content')
<div class="main-content app-content mt-0">
    <div class="side-app">
      <!-- CONTAINER -->
      <div class="main-container container-fluid">
        <!-- PAGE-HEADER -->
        <div class="page-header">
          <h1 class="page-title">سجل الوظائف</h1>
          <a href="{{route('dashboard.jobs.create')}}" class="btn btn-primary">
            <i class="mdi mdi-plus-circle-outline"></i> إضافة وظيفة
          </a>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- FORM OPEN -->
            <form method="get" action="">
              <div class="row align-items-end mb-3">
                <div class="col">
                  <label for="departmentName">اسم الوظيفة</label>
                  <input
                    type="text"
                    class="form-control"
                    id="departmentName"
                    placeholder="اسم الوظيفة"
                  />
                </div>
                <div class="col">
                  <label for="mainDepartment">  اسم القسم </label>
                  <select
                    class="form-control select2-show-search form-select"
                    id="mainDepartment"
                    data-placeholder="اختر قسم"

                  >
                    <option selected disabled value="">
                      اختر قسم
                    </option>
                    <option>قسم البرمجيات</option>
                    <option>قسم التصميم</option>
                    <option>قسم الجودة</option>
                    <option>قسم تحليل المتطلبات</option>
                  </select>
                </div>
<div class="col">
              <label for="from-hijri-picker"> تاريخ الإنشاء (من)</label>
              <div class="input-group">
                <input
                  id="from-hijri-picker"
                  type="text"
                  placeholder="يوم/شهر/سنة"
                  class="form-control"
                /> <div class="input-group-text border-start-0">
                  <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
              </div>
            </div>
            <div class="col">
              <label for="to-hijri-picker">تاريخ الإنشاء (إلى)</label>
              <div class="input-group">
                <input
                  id="to-hijri-picker"
                  type="text"
                  placeholder="يوم/شهر/سنة"
                  class="form-control"
                /> <div class="input-group-text border-start-0">
                  <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
              </div>
            </div>
                <div class="col">
                  <label for="status">الحالة</label>
                  <select class="form-control select2" id="status">
                    <option selected disabled value="">
                      اختر الحالة
                    </option>
                    <option>الجميع</option>
                    <option>مفعلة</option>
                    <option>معطلة</option>
                  </select>
                </div>

                <div class="col">
                  <label for="type">النوع</label>
                  <select class="form-control select2" id="type">
                    <option selected disabled value="">اختر النوع</option>
                    <option>الجميع</option>
                    <option>ِشاغرة</option>
                    <option>مشغولة</option>
                  </select>
                </div>

              </div>
              <div class="row">
                <div class="col-12 col-md-6 my-2">
              <div class="dropdown">
                <button
                  class="btn btn-outline-primary dropdown-toggle"
                  type="button"
                  id="dropdownMenuButton1"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i class="mdi mdi-tray-arrow-down"></i> تصدير
                </button>
                <ul
                  class="dropdown-menu"
                  aria-labelledby="dropdownMenuButton1"
                >
                  <li><a class="dropdown-item" href="#">PDF</a></li>
                  <li><a class="dropdown-item" href="#">Excel</a></li>
                </ul>
              </div>
            </div>
            <div class="col-12 col-md-6 my-2 d-flex justify-content-end">
              <button class="btn btn-primary mx-2" type="submit">
                <i class="mdi mdi-magnify"></i> بحث
              </button>
              <button class="btn btn-outline-primary" type="submit">
                <i class="mdi mdi-restore"></i> عرض الكل
              </button>
            </div>
              </div>

            </form>

        <!-- FORM CLOSED -->

        <!-- Row -->
        <div class="row row-sm">
          <div class="col-lg-12">
            <div class="table-responsive p-1">
              <table
                id="historyTable"
                class="table table-bordered shadow-sm bg-body text-nowrap key-buttons"
              >
                <thead>
                  <tr>
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">اسم الوظيفة</th>
                    <th class="border-bottom-0">اسم القسم </th>
                    <th class="border-bottom-0">تاريخ الإنشاء </th>
                    <th class="border-bottom-0">الحالة</th>
                    <th class="border-bottom-0">النوع</th>
                    <th class="border-bottom-0 text-center">العمليات</th>
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
                              {{$rasidJob->department->name }}
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
                            href="{{route('dashboard.jobs.show',$rasidJob->id)}}"
                            class="azureIcon"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="عرض"
                            ><i class="mdi mdi-eye-outline"></i
                          ></a>
                          <a
                            href="{{route('dashboard.jobs.edit',$rasidJob->id)}}"
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
      </div>
      <!-- CONTAINER CLOSED -->
    </div>
  </div>
  <!--app-content closed-->
</div>

<!-- archiveModal -->
<div
  class="modal fade"
  id="archiveModal"
>
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-body text-center p-0">
        <lottie-player
          autoplay
          loop
          mode="normal"
          src="{{asset('dashboardAssets/images/lottie/archive.json')}}"
          style="width: 55%; display: block; margin: 0 auto 1em"
        >
        </lottie-player>
        <p>هل تريد إتمام عملية الأرشفة؟

</p>
        <div class="mt-3">
          <textarea
            class="form-control"
            placeholder="الرجاء ذكر السبب"
            rows="3"
          ></textarea>
        </div>
      </div>
      <div class="modal-footer mt-5 p-0">
        <button type="button" class="btn btn-primary mx-3">تأكيد</button>
        <button
          type="button"
          class="btn btn-outline-primary"
          data-bs-dismiss="modal"
        >
          إلغاء
        </button>
      </div>
    </div>
  </div>
</div>

<!-- notArchiveModal Modal -->
<div class="modal fade" id="notArchiveModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-body text-center p-0">
        <lottie-player
          autoplay
          loop
          mode="normal"
          src="{{asset('dashboardAssets/images/lottie/unarchive.json')}}"
          style="width: 55%; display: block; margin: 0 auto 1em"
        >
        </lottie-player>
        <p>لا يمكن أرشفة وظيفة مشغولة</p>
      </div>
      <div class="modal-footer justify-content-center mt-5 p-0">
        <button type="button" class="btn btn-warning mx-3">إغلاق</button>

      </div>
    </div>
  </div>
</div>
@endsection

@section('script')

