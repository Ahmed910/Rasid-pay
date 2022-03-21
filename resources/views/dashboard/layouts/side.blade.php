<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar d-flex flex-column h-100">
        <div class="side-header">
            <a class="header-brand1" href="index.html">
                <img src="{{ asset('dashboardAssets/images/brand/logo.png') }}" class="header-brand-img desktop-logo"
                    alt="logo" />
                <img src="{{ asset('dashboardAssets/images/brand/logo-1.png') }}" class="header-brand-img toggle-logo"
                    alt="logo" />
                <img src="{{ asset('dashboardAssets/images/brand/logo-1.png') }}" class="header-brand-img light-logo"
                    alt="logo" />
                <img src="{{ asset('dashboardAssets/images/brand/logo-3.png') }}" class="header-brand-img light-logo1"
                    alt="logo" />
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewbox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>
            <ul class="side-menu">
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('dashboard.home.index') }}"><i
                            class="mdi mdi-home-variant-outline"></i><span class="side-menu__label">الرئيسية</span></a>
                </li>
                <li class="slide {{ strpos(URL::current(), 'department') !== false ? 'is-expanded' : '' }} ">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-view-dashboard-outline"></i><span class="side-menu__label">الأقسام</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">الأقسام</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.departments.index') }}" class="slide-item px-6"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                سجل الأقسام</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.departments.create') }}" class="slide-item px-6"><i
                                    class="mdi mdi-plus-circle-outline"></i> إضافة</a>
                        </li>
                    </ul>
                </li>

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-briefcase-variant-outline"></i><span
                            class="side-menu__label">الوظائف</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">الوظائف</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.job.index') }}" class="slide-item px-6"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                سجل الوظائف</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.job.create') }}" class="slide-item px-6"><i
                                    class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.general.add') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-account-group-outline"></i><span class="side-menu__label">الموظفين</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">الموظفين</a>
                        </li>
                        <li>
                            <a href="../employees/employees-record.html" class="slide-item px-6"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                سجل الموظفين</a>
                        </li>
                        <li>
                            <a href="../employees/employee-add.html" class="slide-item px-6"><i
                                    class="mdi mdi-plus-circle-outline"></i> إضافة</a>
                        </li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-shield-key-outline"></i><span class="side-menu__label">الصلاحيات</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">الصلاحيات</a>
                        </li>
                        <li>
                            <a href="permissions-record.html" class="slide-item px-6"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                سجل الصلاحيات</a>
                        </li>
                        <li>
                            <a href="permission-add.html" class="slide-item px-6"><i
                                    class="mdi mdi-plus-circle-outline"></i> إضافة</a>
                        </li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-account-multiple-outline"></i><span
                            class="side-menu__label">المستخدمين</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">المستخدمين</a>
                        </li>
                        <li>
                            <a href="../users/users-record.html" class="slide-item px-6"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                سجل المستخدمين</a>
                        </li>
                        <li>
                            <a href="../users/user-add.html" class="slide-item px-6"><i
                                    class="mdi mdi-plus-circle-outline"></i> إضافة</a>
                        </li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-account-heart-outline"></i><span class="side-menu__label">العملاء</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">العملاء</a>
                        </li>
                        <li>
                            <a href="../clients/clients-record.html" class="slide-item px-6"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                سجل العملاء</a>
                        </li>
                        <li>
                            <a href="../clients/client-add.html" class="slide-item px-6"><i
                                    class="mdi mdi-plus-circle-outline"></i> إضافة</a>
                        </li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-archive-arrow-down-outline"></i><span
                            class="side-menu__label">الأرشيف</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">الأرشيف</a>
                        </li>
                        <li>
                            <a href="../archive/departments-archive.html" class="slide-item px-6"><i
                                    class="mdi mdi-view-dashboard-edit-outline"></i>
                                أرشيف الأقسام</a>
                        </li>
                        <li>
                            <a href="../archive/jobs-archive.html" class="slide-item px-6"><i
                                    class="mdi mdi-briefcase-edit-outline"></i> أرشيف
                                الوظائف</a>
                        </li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-chart-line"></i><span class="side-menu__label">المتابعة</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">المتابعة</a>
                        </li>
                        <li>
                            <a href="../followup/activity-log.html" class="slide-item px-6"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                سجل النشاطات</a>
                        </li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="../blacklist.html"><i
                            class="mdi mdi-account-cancel-outline"></i><span class="side-menu__label">القائمة
                            السوداء</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="../settings.html"><i
                            class="mdi mdi-cog-outline"></i><span class="side-menu__label">الإعدادات</span></a>
                </li>
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewbox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg>
            </div>
        </div>
    </div>
    <!--/APP-SIDEBAR-->
</div>
