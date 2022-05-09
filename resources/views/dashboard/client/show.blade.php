@extends('dashboard.layouts.master')

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('dashboard.client.index') }}">{{ trans('dashboard.client.sub_progs.index') }}
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            {{ trans('dashboard.client.sub_progs.show') }}
          </li>
        </ol>
      </nav>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- Row -->
    <div class="card py-7 px-7">
        <div class="row">
            <div class="col-12 col-md-4">
                <label>اسم العميل :</label>
                <p class="text-muted">name</p>
            </div>
            <div class="col-12 col-md-4">
                <label>نوع العميل :</label>
                <p class="text-muted">companies</p>
            </div>
            <div class="col-12 col-md-4">
                <label>رقم الجوال :</label>
                <p class="text-muted">0123456789</p>
            </div>
            <div class="col-12 col-md-4">
                <label>رقم السجل التجاري :</label>
                <p class="text-muted">5435643512</p>
            </div>
            <div class="col-12 col-md-4">
                <label>الرقم الضريبي :</label>
                <p class="text-muted">54321321321321</p>
            </div>
            <div class="col-12 col-md-4">
                <label>رقم الحساب البنكي :</label>
                <p class="text-muted">123456781234567812345678</p>
            </div>
            <div class="col-12 col-md-4">
                <label>البنك :</label>
                <p class="text-muted">البنك الأهلي</p>
            </div>
            <div class="col-12 col-md-4">
                <label>نوع النشاط :</label>
                <p class="text-muted">active</p>
            </div>
            <div class="col-12 col-md-4">
                <label>العنوان :</label>
                <p class="text-muted">address</p>
            </div>
            <div class="col-12 col-md-4">
                <label>الجنسية :</label>
                <p class="text-muted">مصري</p>
            </div>
            <div class="col-12 col-md-4">
                <label>النوع :</label>
                <p class="text-muted">male</p>
            </div>
            <div class="col-12 col-md-4">
                <label>الحالة الاجتماعية :</label>
                <p class="text-muted">single</p>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-12 text-end">
            <a href="{{ route('dashboard.client.edit', $client->id) }}" class="btn btn-primary">
                <i class="mdi mdi-square-edit-outline"></i> {{ trans('dashboard.general.edit') }}
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                <i class="mdi mdi-arrow-left"></i> {{ trans('dashboard.general.back') }}
            </a>
        </div>
    </div>
    <!-- End Row -->

    <!-- Row -->
    <label> أسماء المديرين/المفوضين </label>
      <div class="row row-sm">
        <div class="col-lg-12">
          <div class="table-responsive p-1">
            <table id="collapsedTable" class="table table-bordered dt-responsive  nowrap shadow-sm bg-body key-buttons historyTable">
              <thead>
                <tr>
                  <th class="border-bottom-0">#</th>
                  <th class="border-bottom-0">اسم المدير</th>
                  <th class="border-bottom-0">رقم الهوية</th>
                  <th class="border-bottom-0">تاريخ الميلاد</th>
                  <th class="border-bottom-0">رقم الجوال</th>
                  <th class="border-bottom-0 text-center">العمليات</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>محمد رمضان</td>
                  <td>234654313</td>
                  <td>22-2-2022</td>
                  <td>013256465313</td>
                  <td data-bs-toggle="tooltip" data-bs-placement="top" title="تفاصيل المدير"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <!-- End Row -->



     <!-- Row -->
    <label class="my-5">مرفقات العميل</label>
     <div class="card py-7 px-7">
        <div class="row">
          <div class="card px-5 py-5 col-12 col-md-4">
            <div class="row">
              <div class="col-12 col-md-6">
                <label>النوع</label>
                <p class="text-muted">أخري</p>
              </div>
              <div class="col-12 col-md-6">
                <label>العنوان</label>
                <p class="text-muted">image</p>
              </div>
              <div class="col-12 mt-5">
                <div class="row">
                  <div class="col-12 col-md-4">
                    <img src="{{ asset('dashboardAssets/images/pngs/calendar.png') }}" width="100" height="100" alt="photo"/>
                  </div>
                  <div class="col-12 col-md-4">
                    <img src="{{ asset('dashboardAssets/images/pngs/calendar.png') }}" width="100" height="100" alt="photo"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
              
        </div>
      </div>
    <!-- End Row -->

  
@endsection
@include('dashboard.client.show_script')
