@extends('dashboard.layouts.master')
@section('title', trans('dashboard.citizen.index'))

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">المستخدمين</h1>
</div>
<!-- PAGE-HEADER END -->


<!-- FORM OPEN -->

{!! Form::open(['method' => 'GET', 'id' => 'citizen-search']) !!}
    <div class="row align-items-end mb-3">
        <div class="col-12 col-md-3 mb-3">
            <label for="citizenName">اسم المستخدم</label>
            <input type="text" class="form-control" id="citizenName" placeholder="اسم المستخدم" />
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="idNumber">رقم الهوية</label>
            <input type="number" class="form-control" id="idNumber" placeholder="رقم الهوية" />
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="phone">رقم الجوال</label>
            <div class="input-group">
                <input id="phone" type="number" placeholder="أدخل رقم الجوال" class="form-control" />
                <div class="input-group-text border-start-0">
                    +966
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="clientType">البطاقة المفعلة</label>
            <select class="form-control select2" id="clientType">
                <option selected disabled value="">إختر البطاقة </option>
                <option>الأساسية</option>
                <option>الأساسية</option>
                <option>الأساسية</option>
            </select>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="from-hijri-picker-card"> تاريخ إنتهاء البطاقة (من)</label>
            <div class="input-group">
                <input id="from-hijri-picker-card" type="text" placeholder="يوم/شهر/سنة" class="form-control" name="end_at_from" />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="to-hijri-picker-card">تاريخ إنتهاء البطاقة (إلى)</label>
            <div class="input-group">
                <input id="to-hijri-picker-card" type="text" placeholder="يوم/شهر/سنة" class="form-control" name="end_at_to"   />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="from-hijri-picker-custom"> تاريخ التسجيل (من)</label>
            <div class="input-group">
                <input id="from-hijri-picker-custom" type="text" placeholder="يوم/شهر/سنة" class="form-control" name="created_from" />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="to-hijri-picker-custom">تاريخ التسجيل (إلى)</label>
            <div class="input-group">
                <input id="to-hijri-picker-custom" type="text" placeholder="يوم/شهر/سنة" class="form-control" name="created_to" />
                <div class="input-group-text border-start-0">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-12 col-md-6 my-2">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-tray-arrow-down"></i>
                    {{ trans('dashboard.general.export') }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">PDF</a></li>
                    <li><a class="dropdown-item" href="#">Excel</a></li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-end">
            <button class="btn btn-primary mx-2" type="submit">
                <i class="mdi mdi-magnify"></i> {{ trans('dashboard.general.search') }}
            </button>

            <button class="btn btn-outline-primary" type="reset" id="reset">
                <i class="mdi mdi-restore"></i>{{ trans('dashboard.general.show_all') }}
            </button>

        </div>
    </div>
    {!! form::close() !!}

<!-- FORM CLOSED -->

<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="p-1">
            <table id="citizenTable" class="table table-bordered text-nowrap shadow-sm bg-body key-buttons">
                <thead>
                    <tr>
                        <th class="border-bottom-0">#</th>
                        <th class="border-bottom-0"> اسم المستخدم</th>
                        <th class="border-bottom-0">رقم الهوية</th>
                        <th class="border-bottom-0">رقم الجوال</th>
                        <th class="border-bottom-0">البطاقة المفعلة</th>
                        <th class="border-bottom-0">تاريخ إنتهاء البطاقة</th>
                        <th class="border-bottom-0">تاريخ التسجيل</th>
                        <th class="border-bottom-0 text-center">العمليات</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_phone" >

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
                <form method="post" action="#" class="needs-validation" id="item" novalidate>
                    @csrf
                    @method('PATCH')

                <div class="modal-body text-center p-0">
                    <lottie-player autoplay loop mode="normal" src="{{ asset('dashboardAssets/images/lottie/alert.json') }}"
                        style="width: 55%; display: block; margin: 0 auto 1em">
                    </lottie-player>
                    <p>تعديل رقم الجوال</p>
                    <div class="mt-3">
                        <input type="number" name="phone" class="form-control" placeholder="رقم الجوال الجديد" >

                    </div>
                </div>
                <div class="modal-footer justify-content-end mt-5 p-0">
                    <button type="submit" class="btn btn-primary mx-3">حفظ</button>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                        عودة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Row -->


@include('dashboard.layouts.modals.alert')

@endsection
@include('dashboard.citizen.script')