@extends("dashboard.layouts.master")
@section("content")
{{--    {{dd($activity)}}--}}
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="departments-record.html"> سجل الأقسام</a></li>
                            <li class="breadcrumb-item active" aria-current="page">عرض القسم</li>
                        </ol>
                    </nav>

                </div>
                <!-- PAGE-HEADER END -->


                <!-- Row -->
                <div class="card py-7 px-7">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <label>اسم القسم:</label>
                            <p class="text-muted">

                                {{($department->translations[0]->name)}}
                            </p>
                        </div>
                        <div class="col-12 col-md-4">
                            <label>القسم الرئيسي:</label>
                            <p class="text-muted">
                                {{(isset($department->parent)?$department->parent->translations[0]->name:"لايوجد")}}</p>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="d-block" for="departmentName">الحالة:</label>
                            <p class="badge bg-success-opacity py-2 px-4">{{$department->is_active==1?"مفعل":"معطل"}}</p>
                        </div>
                        <div class="col-12 col-md-4">
                            <label>صورة القسم:</label>
                            <img src="https://picsum.photos/seed/picsum/1000" width="150" height="150" class="d-block rounded-3" alt="" data-toggle="popoverIMG" data-bs-original-title="" title="">
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="d-block" for="departmentName">الوصف</label>
                            <p class="text-muted">
                                {{$department->translations[0]->description}}

                            </p>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 text-end">
{{--                        {{ link_to_action("Blade\Dashboard\Department2Controller@edit" , $title = null, $parameters =["departments2"=>$department->id] ) }}--}}
                        <a href="{{Request::url()}}/edit" class="btn btn-primary">
                            <i class="mdi mdi-square-edit-outline"></i> تعديل
                        </a>
                        <a href="departments-record.html" class="btn btn-outline-primary">
                            <i class="mdi mdi-arrow-left"></i> عودة
                        </a>
                    </div>
                </div>
                <!-- End Row -->

                <!-- Row -->
                <label>الحركة التاريخية</label>
                <div class="table-responsive p-1">
                    <div id="historyTable_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer"><table id="historyTable" class="table table-bordered shadow-sm bg-body key-buttons historyTable dataTable no-footer" role="grid" aria-describedby="historyTable_info">
                            <thead>
                            <tr role="row"><th class="border-bottom-0 sorting sorting_asc" tabindex="0" aria-controls="historyTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#: activate to sort column descending" style="width: 11.5px;">#</th><th class="border-bottom-0 sorting" tabindex="0" aria-controls="historyTable" rowspan="1" colspan="1" aria-label="تم بواسطة: activate to sort column ascending" style="width: 106.312px;">تم بواسطة</th><th class="border-bottom-0 sorting" tabindex="0" aria-controls="historyTable" rowspan="1" colspan="1" aria-label="اسم القسم: activate to sort column ascending" style="width: 141.266px;">اسم القسم</th><th class="border-bottom-0 sorting" tabindex="0" aria-controls="historyTable" rowspan="1" colspan="1" aria-label="تاريخ النشاط: activate to sort column ascending" style="width: 74.9375px;">تاريخ النشاط</th><th class="border-bottom-0 sorting" tabindex="0" aria-controls="historyTable" rowspan="1" colspan="1" aria-label="
                                النشاط
                              : activate to sort column ascending" style="width: 65.8125px;">
                                    النشاط
                                </th><th class="border-bottom-0 sorting" style="max-width: 800px; width: 921.172px;" tabindex="0" aria-controls="historyTable" rowspan="1" colspan="1" aria-label="السبب: activate to sort column ascending">السبب</th></tr>
                            </thead>
                            <tbody>



                                @foreach($activity as $key=>$value)
{{--                                 {{dd($value)}}--}}
                            <tr class="odd">
                                <td class="sorting_1">1</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="https://picsum.photos/seed/picsum/100" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" data-bs-original-title="" title="">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                           {{($value->user->fullname)}}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="https://picsum.photos/seed/picsum/100" width="25" class="avatar brround cover-image" alt="..." data-toggle="popoverIMG" data-bs-original-title="" title="">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            {{($department->translations[0]->name)}}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{($value->created_at)}}
                                </td>
                                <td>
                                    <span class="badge bg-primary-opacity py-2 px-4">{{$value->action_type}} </span>
                                </td>
                                <td>
                                    <p>
                                        {{($value->reason)}}
                                    </p>
                                </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                <!-- End Row -->

                <!-- Row -->



                <!-- End Row -->
            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>
@endsection
