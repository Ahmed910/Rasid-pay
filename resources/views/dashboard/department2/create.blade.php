@extends("dashboard.layouts.master")
@section("content")
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="departments-record.html"> سجل الأقسام</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                إضافة قسم
                            </li>
                        </ol>
                    </nav>
                </div>
                <!-- PAGE-HEADER END -->

                <!-- ROW OPEN -->

                {{ Form::open(array('url' => 'departments2')) }}
                     {{dd($parents)}}
{{--                <form method="post" action="" class="needs-validation" novalidate="">--}}
                    <div class="card py-7 px-7">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-5">
{{--                                <label for="departmentName">اسم القسم</label>--}}
{{--                                <input type="text" class="form-control" id="departmentName" placeholder="اسم القسم" required="">--}}
                                    {{ Form::label('name', 'اسم القسم') }}
                                    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                                <div class="invalid-feedback">اسم القسم مطلوب.</div>
                            </div>

                            <div class="col-12 col-md-4 mb-5">
                                <label for="mainDepartment">القسم الرئيسي</label>
                                <select class="form-control select2-show-search select2-hidden-accessible" id="mainDepartment" tabindex="-1" aria-hidden="true">
                                    <option selected="" disabled="" value="">
                                        اختر قسم رئيسي
                                    </option>
                                    <option>قسم البرمجيات</option>
                                    <option>قسم التصميم</option>
                                    <option>قسم الجودة</option>
                                    <option>قسم تحليل المتطلبات</option>
                                </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-mainDepartment-container"><span class="select2-selection__rendered" id="select2-mainDepartment-container" title="
                          اختر قسم رئيسي
                        ">
                          اختر قسم رئيسي
                        </span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>

                            </div>

                            <div class="col-12 col-md-4 mb-5">
                                <label for="status">الحالة</label>
                                <select class="form-control select2 select2-hidden-accessible" id="status" tabindex="-1" aria-hidden="true">
                                    <option selected="" disabled="" value="">اختر الحالة</option>
                                    <option>مفعل</option>
                                    <option>معطل</option>
                                </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-status-container"><span class="select2-selection__rendered" id="select2-status-container" title="اختر الحالة">اختر الحالة</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
                            <div class="col-12">
                                <label for="departmentImg">صورة القسم (JPG, PNG, JPEG, DWG)</label>
                                <div class="dropify-wrapper"><div class="dropify-message"><span class="file-icon"> <p>اسحب واسقط او قم برفع الصورة</p></span><p class="dropify-error">اووه ، حدث خطأ ما</p></div><div class="dropify-loader"></div><div class="dropify-errors-container"><ul></ul></div><input type="file" class="dropify" data-show-remove="true" data-bs-height="250" id="departmentImg" data-errors-position="inside" data-show-errors="true" data-show-loader="true" data-allowed-file-extensions="jpg png jpeg dwg" required=""><button type="button" class="dropify-clear">حذف</button><div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-filename"><span class="dropify-filename-inner"></span></p><p class="dropify-infos-message">اسحب واسقط او إضغط لتغغير الصورة</p></div></div></div></div>
                            </div>
                            <div class="col-12">
                                <label for="departmentDes">الوصف</label>
                                <textarea type="text" class="form-control" id="departmentDes" rows="3" placeholder="الوصف"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-5 text-end">
                            {{ Form::submit('حفظ', array('class' => 'btn btn-primary','data-bs-toggle'=>'modal' ,'data-bs-target'=>'#successModal'),

                                 ) }}
{{--                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successModal" type="submit">--}}
{{--                                <i class="mdi mdi-content-save-outline"></i> حفظ--}}
{{--                            </button>--}}
                            <a href="departments-record.html" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#backModal">
                                <i class="mdi mdi-arrow-left"></i> عودة
                            </a>
                        </div>
                    </div>

                {{ Form::close() }}
                <!-- ROW CLOSED -->
            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>
@endsection
