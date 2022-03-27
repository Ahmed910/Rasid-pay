@extends('dashboard.layouts.master')
@include('dashboard.department.style')

@section('nav-title')
@endsection

@section('content')
  <!--app-content open-->
  <div class="main-content app-content mt-0">
    <div class="side-app">
      <!-- CONTAINER -->
      <div class="main-container container-fluid">
        <!-- PAGE-HEADER -->
        <div class="page-header">
          <h1 class="page-title">أرشيف الأقسام</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- FORM OPEN -->
        <form method="get" action="">
          <div class="row align-items-end mb-3">
            <div class="col">
              <label for="departmentName">اسم القسم</label>
              <input
                type="text"
                class="form-control"
                id="departmentName"
                placeholder="اسم القسم"
              />
            </div>
            <div class="col">
              <label for="mainDepartment">القسم الرئيسي</label>
              <select
                class="form-control select2-show-search form-select"
                data-placeholder="اختر قسم رئيسي"
                id="mainDepartment"
              >
                <option selected disabled value="">اختر قسم رئيسي</option>
                <option>قسم البرمجيات</option>
                <option>قسم التصميم</option>
                <option>قسم الجودة</option>
                <option>قسم تحليل المتطلبات</option>
              </select>
            </div>
            <div class="col">
              <label for="validationCustom02"> تاريخ الأرشفة (من)</label>
              <div class="input-group">
                <input
                  id="from-hijri-picker"
                  type="text"
                  placeholder="يوم/شهر/سنة"
                  class="form-control"
                />
                <div class="input-group-text border-start-0">
                  <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
              </div>
            </div>
            <div class="col">
              <label for="validationCustom02"> تاريخ الأرشفة (إلى)</label>
              <div class="input-group">
                <input
                  id="to-hijri-picker"
                  type="text"
                  placeholder="يوم/شهر/سنة"
                  class="form-control"
                />
                <div class="input-group-text border-start-0">
                  <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
              </div>
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
                     id="archiveDepartmentTable"
                     class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
              >
                <thead>
                <tr>
                  <th class="border-bottom-0">#</th>
                  <th class="border-bottom-0">اسم القسم</th>
                  <th class="border-bottom-0">القسم الرئيسي</th>
                  <th class="border-bottom-0">تاريخ الأرشفة</th>
                  <th class="border-bottom-0 text-center">العمليات</th>
                </tr>
                </thead>

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
@endsection
@section('scripts')
  @include('dashboard.archive.department.script')
@endsection
