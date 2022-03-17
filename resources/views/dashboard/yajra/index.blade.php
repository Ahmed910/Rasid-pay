@extends('dashboard.layouts.master')
@include('dashboard.department.style')

@section('title', 'departments')

@section('content')
    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <h1 class="page-title">سجل الأقسام</h1>
                    <a href="department-add.html" class="btn btn-primary">
                        <i class="mdi mdi-plus-circle-outline"></i> إضافة قسم
                    </a>
                </div>
                <!-- PAGE-HEADER END -->

                <!-- FORM OPEN -->

                <form method="get" id="searchForm">
                    <div class="row align-items-end mb-3">
                        <div class="col">
                            <label for="departmentName">اسم القسم</label>
                            <input type="text" class="form-control" id="departmentName" placeholder="اسم القسم" />
                        </div>
                        <div class="col">
                            <label for="mainDepartment">القسم الرئيسي</label>
                            <select class="form-control select2-show-search form-select" data-placeholder="اختر قسم رئيسي"
                                id="mainDepartment">
                                <option selected disabled value="">اختر قسم رئيسي</option>
                                @forelse ($mainDepartments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @empty
                                @endforelse

                            </select>
                        </div>
                        <div class="col">
                            <label for="validationCustom02"> تاريخ الإنشاء (من)</label>
                            <div class="input-group">
                                <input id="from-hijri-picker" type="text" placeholder="يوم/شهر/سنة"
                                    class="form-control" />
                                <div class="input-group-text border-start-0">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="validationCustom02"> تاريخ الإنشاء (إلى)</label>
                            <div class="input-group">
                                <input id="to-hijri-picker" type="text" placeholder="يوم/شهر/سنة" class="form-control" />
                                <div class="input-group-text border-start-0">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="status">الحالة</label>
                            <select class="form-control select2" id="status">
                                <option selected disabled value="">اختر الحالة</option>
                                <option value="-1">الجميع</option>
                                <option value="1">مفعل</option>
                                <option value="0">معطل</option>
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
                            {{-- <button class="btn btn-primary mx-2" type="submit">
                                <i class="mdi mdi-magnify"></i> بحث
                            </button> --}}
                            <button class="btn btn-outline-primary" type="reset" id="reset">
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
                            <table id="historyTable" class="table table-bordered shadow-sm bg-body text-nowrap key-buttons">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">اسم القسم</th>
                                        <th class="border-bottom-0">القسم الرئيسي</th>
                                        <th class="border-bottom-0">تاريخ الإنشاء</th>
                                        <th class="border-bottom-0">الحالة</th>
                                        <th class="border-bottom-0 text-center">العمليات</th>
                                    </tr>
                                </thead>
                                {{-- <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="https://picsum.photos/seed/picsum/100" width="25"
                                                        class="avatar brround cover-image" alt="..."
                                                        data-toggle="popoverIMG" />
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    قسم التطبيقات الذكية
                                                </div>
                                            </div>
                                        </td>
                                        <td>قسم البرمجيات</td>
                                        <td>20 يناير 2022</td>
                                        <td>
                                            <span class="badge bg-success-opacity py-2 px-4">
                                                مفعل</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="department-view.html" class="azureIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="التفاصيل"><i
                                                    class="mdi mdi-eye-outline"></i></a>
                                            <a href="department-add.html" class="warningIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="تعديل"><i
                                                    class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="#" class="primaryIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="أرشفة"><i data-bs-toggle="modal"
                                                    data-bs-target="#archiveModal"
                                                    class="mdi mdi-archive-arrow-down-outline"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="https://picsum.photos/seed/picsum/100" width="25"
                                                        class="avatar brround cover-image" alt="..."
                                                        data-toggle="popoverIMG" />
                                                </div>
                                                <div class="flex-grow-1 ms-3">قسم الجودة</div>
                                            </div>
                                        </td>
                                        <td>قسم البرمجيات</td>
                                        <td>20 يناير 2022</td>
                                        <td>
                                            <span class="badge bg-danger-opacity py-2 px-4">معطل</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="department-view.html" class="azureIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="التفاصيل"><i
                                                    class="mdi mdi-eye-outline"></i></a>
                                            <a href="department-add.html" class="warningIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="تعديل"><i
                                                    class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="#" class="primaryIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="أرشفة"><i data-bs-toggle="modal"
                                                    data-bs-target="#notArchiveModal"
                                                    class="mdi mdi-archive-arrow-down-outline"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="https://picsum.photos/seed/picsum/100" width="25"
                                                        class="avatar brround cover-image" alt="..."
                                                        data-toggle="popoverIMG" />
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    قسم تصميم الواجهات
                                                </div>
                                            </div>
                                        </td>
                                        <td>قسم التصميم</td>
                                        <td>20 يناير 2022</td>
                                        <td>
                                            <span class="badge bg-success-opacity py-2 px-4">
                                                مفعل</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="department-view.html" class="azureIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="التفاصيل"><i
                                                    class="mdi mdi-eye-outline"></i></a>
                                            <a href="department-add.html" class="warningIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="تعديل"><i
                                                    class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="#" class="primaryIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="أرشفة"><i data-bs-toggle="modal"
                                                    data-bs-target="#archiveModal"
                                                    class="mdi mdi-archive-arrow-down-outline"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="https://picsum.photos/seed/picsum/100" width="25"
                                                        class="avatar brround cover-image" alt="..."
                                                        data-toggle="popoverIMG" />
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    قسم التطبيقات الذكية
                                                </div>
                                            </div>
                                        </td>
                                        <td>قسم البرمجيات</td>
                                        <td>20 يناير 2022</td>
                                        <td>
                                            <span class="badge bg-success-opacity py-2 px-4">
                                                مفعل</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="department-view.html" class="azureIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="التفاصيل"><i
                                                    class="mdi mdi-eye-outline"></i></a>
                                            <a href="department-add.html" class="warningIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="تعديل"><i
                                                    class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="#" class="primaryIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="أرشفة"><i data-bs-toggle="modal"
                                                    data-bs-target="#archiveModal"
                                                    class="mdi mdi-archive-arrow-down-outline"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="https://picsum.photos/seed/picsum/100" width="25"
                                                        class="avatar brround cover-image" alt="..."
                                                        data-toggle="popoverIMG" />
                                                </div>
                                                <div class="flex-grow-1 ms-3">قسم الجودة</div>
                                            </div>
                                        </td>
                                        <td>قسم البرمجيات</td>
                                        <td>20 يناير 2022</td>
                                        <td>
                                            <span class="badge bg-danger-opacity py-2 px-4">معطل</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="department-view.html" class="azureIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="التفاصيل"><i
                                                    class="mdi mdi-eye-outline"></i></a>
                                            <a href="department-add.html" class="warningIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="تعديل"><i
                                                    class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="#" class="primaryIcon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="أرشفة"><i data-bs-toggle="modal"
                                                    data-bs-target="#notArchiveModal"
                                                    class="mdi mdi-archive-arrow-down-outline"></i></a>
                                        </td>
                                    </tr>
                                </tbody> --}}
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
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#historyTable').DataTable({
                order: [
                    [3, "DESC"]
                ],
                sDom: "t<'domOption'lpi>",
                pageLength: 10,
                lengthMenu: [
                    [1, 5, 10, 20, -1],
                    [1, 5, 10, 20, "الكل"],
                ],


                columnDefs: [{
                    "targets": "_all",
                    "className": "text-center",
                }],
                language: {
                    lengthMenu: "عرض _MENU_",
                    zeroRecords: "لا يوجد بيانات",
                    info: "عرض _PAGE_ من _PAGES_ عنصر",
                    infoEmpty: "لا يوجد نتائج بحث متاحة",
                    paginate: {
                        previous: '<i class="mdi mdi-chevron-right"></i>',
                        next: '<i class="mdi mdi-chevron-left"></i>',
                    },
                },
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('dashboard.yajra.listDepartments') }}",
                    data: function(s) {
                        s.name = $('#departmentName').val();
                        s.created_from = $('#from-hijri-picker').val();
                        s.created_to = $('#to-hijri-picker').val();
                        s.is_active = $('#status').val();
                        s.parent_id = $('#mainDepartment').val();
                    }
                },
                // data.statusValue = $('select[name="requestStatus"]').val()
                // data.statusValue = $('select[name="requestStatus"]').val()
                columns: [{
                        data: 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'parent.name',
                        name: 'parent.name'
                    },

                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false
                    },
                ]
            });


            $('#status').on('change', function(e) {
                table.draw();

            });

            $('#mainDepartment').on('change', function(e) {
                table.draw();
            });


            $("#departmentName").keyup(function() {
                table.draw();
            });

            $('#searchForm').on('reset', function(e) {
                $('#status').val('').trigger('change');
                $('#mainDepartment').val('').trigger('change');
            });

            // Select2
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
@endsection
