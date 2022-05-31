<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar d-flex flex-column h-100">
        <div class="side-header">
            <a class="header-brand1" href="#!">
                <img src="{{ asset('dashboardAssets/images/brand/fintech-icon.svg') }}" class="header-brand-img desktop-logo"
                    alt="logo" />
                <img src="{{ asset('dashboardAssets/images/brand/fintech-logo.svg') }}" class="header-brand-img toggle-logo"
                    alt="logo" />
                <img src="{{ asset('dashboardAssets/images/brand/fintech-icon.svg') }}" class="header-brand-img light-logo"
                    alt="logo" />
                <img src="{{ asset('dashboardAssets/images/brand/fintech-logo.svg') }}" class="header-brand-img light-logo1"
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
                    <a class="side-menu__item {{ request()->routeIs('dashboard.home.index') ? 'active' : '' }}" data-bs-toggle="slide" href="{{ route('dashboard.home.index') }}"><i
                            class="mdi mdi-home-variant-outline"></i><span
                            class="side-menu__label">{{trans('dashboard.home.home')}}</span></a>
                </li>
                {{-- <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-cpu"></i>
                        <span class="side-menu__label">رصيد</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1"><a href="javascript:void(0)">Submenu items</a></li>
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)"><span
                                    class="sub-side-menu__label">Submenu-2</span><i class="sub-angle fe fe-chevron-right"></i></a>
                            <ul class="sub-slide-menu">
                                <li><a class="sub-slide-item" href="javascript:void(0)">Submenu-2.1</a></li>
                                <li><a class="sub-slide-item" href="javascript:void(0)">Submenu-2.2</a></li>
                            </ul>
                        </li>
                    </ul>
                </li> --}}
                <li class="sub-category">
                    <h3>رصيد </h3>
                </li>
                <li class="slide {{ request()->routeIs('dashboard.department.*') && !request()->routeIs('dashboard.*.archive') ? 'is-expanded' : '' }} ">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-view-dashboard-outline"></i><span
                            class="side-menu__label">{{trans('dashboard.department.departments')}}</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">{{trans('dashboard.department.departments')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.department.index') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.department.index') ? 'active' : '' }}"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                {{ trans('dashboard.department.sub_progs.index') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.department.create') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.department.create') ? 'active' : '' }}"><i
                                    class="mdi mdi-plus-circle-outline"></i> {!!
                                trans('dashboard.department.sub_progs.create') !!}</a>
                        </li>
                    </ul>
                </li>
                <li class="slide {{ request()->routeIs('dashboard.rasid_job.*') && !request()->routeIs('dashboard.*.archive') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-briefcase-variant-outline"></i><span class="side-menu__label">{{
                            trans('dashboard.rasid_job.rasid_jobs') }}</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">{{ trans('dashboard.rasid_job.rasid_jobs') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.rasid_job.index') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.rasid_job.index') ? 'active' : '' }}"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                {{ trans('dashboard.rasid_job.sub_progs.index') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.rasid_job.create') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.rasid_job.create') ? 'active' : '' }}"><i
                                    class="mdi mdi-plus-circle-outline"></i> {!!
                                trans('dashboard.rasid_job.sub_progs.create') !!}</a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="slide {{ request()->routeIs('dashboard.employee.*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-account-group-outline"></i><span class="side-menu__label">{!!
                            trans('dashboard.employee.employees') !!}</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">{!! trans('dashboard.employee.employees') !!}</a>
                        </li>
                        <li>
                            <a href="{!! route('dashboard.employee.index') !!}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.employee.index') ? 'active' : '' }}"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                {!! trans('dashboard.employee.sub_progs.index') !!}</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.group.create') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.employee.create') ? 'active' : '' }}"><i
                                    class="mdi mdi-plus-circle-outline"></i> {!!
                                trans('dashboard.employee.sub_progs.create') !!}</a>
                        </li>
                    </ul>
                </li> --}}
                <li class="slide {{ request()->routeIs('dashboard.group.*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-shield-key-outline"></i><span class="side-menu__label">{!!
                            trans('dashboard.group.all_groups') !!}</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">{!! trans('dashboard.group.all_groups') !!}</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.group.index') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.group.index') ? 'active' : '' }}"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                {!! trans('dashboard.group.sub_progs.index') !!}</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.group.create') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.group.create') ? 'active' : '' }}"><i
                                    class="mdi mdi-plus-circle-outline"></i> {!!
                                trans('dashboard.group.sub_progs.create') !!}</a>
                        </li>
                    </ul>
                </li>
                <li class="slide {{ request()->routeIs('dashboard.admin.*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-account-multiple-outline"></i><span class="side-menu__label">{!!
                            trans('dashboard.admin.admins') !!}</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">{!! trans('dashboard.admin.admins') !!}</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.admin.index') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.admin.index') ? 'active' : '' }}"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                {!! trans('dashboard.admin.sub_progs.index') !!}</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.admin.create') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.admin.create') ? 'active' : '' }}"><i
                                    class="mdi mdi-plus-circle-outline"></i> {!!
                                trans('dashboard.admin.sub_progs.create') !!}</a>
                        </li>
                    </ul>
                </li>
                <li class="slide {{ request()->routeIs('dashboard.client.*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-account-heart-outline"></i><span class="side-menu__label">{!!
                            trans('dashboard.client.clients') !!}</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">{!! trans('dashboard.client.clients') !!}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.client.index') ? 'active' : '' }}"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                {!! trans('dashboard.client.sub_progs.index') !!}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.client.account_orders') ? 'active' : '' }}"><i
                                    class="mdi mdi-badge-account-horizontal-outline"></i> {!!
                                trans('dashboard.client.sub_progs.account_order') !!}</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.client.create') ? 'active' : '' }}"><i
                                    class="mdi mdi-plus-circle-outline"></i> {!!
                                trans('dashboard.client.sub_progs.create') !!}</a>
                        </li>
                    </ul>
                </li>
                <li class="slide {{ request()->routeIs('dashboard.*.archive') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-archive-arrow-down-outline"></i><span class="side-menu__label">{{
                            trans('dashboard.general.the_archive') }}</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">{{ trans('dashboard.general.the_archive') }}</a>
                        </li>
                        <li>
                       
                            <a href="{{ route('dashboard.department.archive') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.department.archive') ? 'active' : '' }}"><i
                                    class="mdi mdi-view-dashboard-edit-outline"></i>
                                {{ trans('dashboard.department.department_archive') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.rasid_job.archive') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.rasid_job.archive') ? 'active' : '' }}"><i
                                    class="mdi mdi-briefcase-edit-outline"></i>
                                {{ trans('dashboard.rasid_job.sub_progs.archive') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="slide {{ request()->routeIs('dashboard.activity_log.*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-chart-line"></i><span class="side-menu__label">{{
                            trans('dashboard.activity_log.activity_logs') }}</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">{{ trans('dashboard.activity_log.activity_logs') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.activity_log.index') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.activity_log.index') ? 'active' : '' }}"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                {{ trans('dashboard.activity_log.activity_log_records') }}</a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="../blacklist.html"><i
                            class="mdi mdi-account-cancel-outline"></i><span
                            class="side-menu__label">{{trans('dashboard.general.black_menu')}}</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="../settings.html"><i
                            class="mdi mdi-cog-outline"></i><span
                            class="side-menu__label">{{trans('dashboard.general.settings')}}</span></a>
                </li> --}}
                <li class="sub-category">
                    <h3>رصيد باي</h3>
                </li>

                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('dashboard.citizen.index') ? 'active' : '' }}" data-bs-toggle="slide" href="{{ route('dashboard.citizen.index') }}"><i
                            class="mdi mdi-account-multiple-check-outline"></i><span
                            class="side-menu__label">{{ trans('dashboard.citizens.citizens') }}</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('dashboard.transaction.index') ? 'active' : '' }}" data-bs-toggle="slide" href="{{ route('dashboard.transaction.index') }}"><i
                            class="mdi mdi-bank-transfer"></i><span
                            class="side-menu__label">المعاملات</span></a>
                </li>
                <li
                    class="slide {{ request()->routeIs('dashboard.card_package.*') && !request()->routeIs('dashboard.*.archive') ? 'is-expanded' : '' }} ">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="mdi mdi-view-dashboard-outline"></i><span
                            class="side-menu__label">{{ trans('dashboard.card_package.cards_discount') }}</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu-label1">
                            <a href="javascript:void(0)">{{ trans('dashboard.card_package.cards_discount') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.card_package.index') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.card_package.index') ? 'active' : '' }}"><i
                                    class="mdi mdi-file-document-multiple-outline"></i>
                                    {{ trans('dashboard.card_package.cards_discount_records') }}
                                </a>
                        </li>

                        <li>
                            <a href="{{ route('dashboard.card_package.create') }}"
                                class="slide-item px-6 {{ request()->routeIs('dashboard.card_package.create') ? 'active' : '' }}"><i
                                    class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.general.add') }}</a>
                        </li>
                    </ul>
                </li>
            <li class="slide {{ request()->routeIs('dashboard.bank.*') && !request()->routeIs('dashboard.*.archive') ? 'is-expanded' : '' }} ">
                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                        class="mdi mdi-bank-outline"></i><span class="side-menu__label">البنوك</span><i
                        class="angle fe fe-chevron-right"></i></a>
                <ul class="slide-menu">
                    <li class="side-menu-label1">
                        <a href="javascript:void(0)">البنوك</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.bank.index') }}"
                            class="slide-item px-6 {{ request()->routeIs('dashboard.bank.index') ? 'active' : '' }}"><i
                                class="mdi mdi-file-document-multiple-outline"></i>
                            سجل البنوك</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.bank.create') }}"
                            class="slide-item px-6 {{ request()->routeIs('dashboard.bank.create') ? 'active' : '' }}"><i
                                class="mdi mdi-plus-circle-outline"></i> إضافة</a>
                    </li>
                </ul>
            </li>
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewbox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg>
            </div>
        </div>

        <footer class="mt-auto py-3">
            <div class="container">
                <div class="row">
                    <div class="col d-flex">
                        {!! Form::open(['route' => 'dashboard.session.logout', 'method' => 'POST', 'id' =>
                        'logout_form']) !!}
                        <a class="nav-link icon" onclick="document.getElementById('logout_form').submit();"
                            style="cursor: pointer;">
                            <i class="mdi mdi-logout"></i>
                            <span class="mx-2">{{trans('dashboard.general.logout')}}</span>
                        </a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!--/APP-SIDEBAR-->
</div>
