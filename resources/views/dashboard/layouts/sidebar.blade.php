<div class="sticky">
  <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
  <div class="app-sidebar d-flex flex-column h-100">
    <div class="side-header">
      <a class="header-brand1" href="index.html">
        <img src="{{ asset('dashboardAssets/images/brand/logo.png') }}" class="header-brand-img desktop-logo" alt="logo" />
        <img src="{{ asset('dashboardAssets/images/brand/logo-1.png') }}" class="header-brand-img toggle-logo" alt="logo" />
        <img src="{{ asset('dashboardAssets/images/brand/logo-1.png') }}" class="header-brand-img light-logo" alt="logo" />
        <img src="{{ asset('dashboardAssets/images/brand/logo-3.png') }}" class="header-brand-img light-logo1" alt="logo" />
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
          <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('dashboard.home.index') }}"><i class="mdi mdi-home-variant-outline"></i><span class="side-menu__label">الرئيسية</span></a>
        </li>
        <li class="slide {{ request()->routeIs('dashboard.department.*') ? 'is-expanded' : '' }} ">
          <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="mdi mdi-view-dashboard-outline"></i><span class="side-menu__label">الأقسام</span><i class="angle fe fe-chevron-right"></i></a>
          <ul class="slide-menu">
            <li class="side-menu-label1">
              <a href="javascript:void(0)">الأقسام</a>
            </li>
            <li>
              <a href="{{ route('dashboard.department.index') }}" class="slide-item px-6 {{ request()->routeIs('dashboard.department.index') ? 'active' : '' }}"><i class="mdi mdi-file-document-multiple-outline"></i>
                سجل الأقسام</a>
            </li>
            <li>
              <a href="{{ route('dashboard.department.create') }}" class="slide-item px-6 {{ request()->routeIs('dashboard.department.create') ? 'active' : '' }}"><i class="mdi mdi-plus-circle-outline"></i> إضافة</a>
            </li>
          </ul>
        </li>

        <li class="slide {{ request()->routeIs('dashboard.job.*') ? 'is-expanded' : '' }}">
          <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="mdi mdi-briefcase-variant-outline"></i><span class="side-menu__label">الوظائف</span><i class="angle fe fe-chevron-right"></i></a>
          <ul class="slide-menu">
            <li class="side-menu-label1">
              <a href="javascript:void(0)">الوظائف</a>
            </li>
            <li>
              <a href="{{ route('dashboard.job.index') }}" class="slide-item px-6 {{ request()->routeIs('dashboard.job.index') ? 'active' : '' }}"><i class="mdi mdi-file-document-multiple-outline"></i>
                سجل الوظائف</a>
            </li>
            <li>
              <a href="{{ route('dashboard.job.create') }}" class="slide-item px-6 {{ request()->routeIs('dashboard.job.create') ? 'active' : '' }}"><i class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.general.add') }}</a>
            </li>
          </ul>
        </li>

        <li class="slide {{ request()->routeIs('dashboard.employee.*') ? 'is-expanded' : '' }}">
          <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="mdi mdi-account-group-outline"></i><span class="side-menu__label">{!! trans('dashboard.employee.employees') !!}</span><i
                class="angle fe fe-chevron-right"></i></a>
          <ul class="slide-menu">
            <li class="side-menu-label1">
              <a href="javascript:void(0)">{!! trans('dashboard.employee.employees') !!}</a>
            </li>
            <li>
              <a href="{!! route('dashboard.employee.index') !!}" class="slide-item px-6 {{ request()->routeIs('dashboard.employee.index') ? 'active' : '' }}"><i class="mdi mdi-file-document-multiple-outline"></i>
                {!! trans('dashboard.employee.sub_progs.index') !!}</a>
            </li>
            <li>
              <a href="{{ route('dashboard.group.create') }}" class="slide-item px-6 {{ request()->routeIs('dashboard.employee.create') ? 'active' : '' }}"><i class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.general.add') }}</a>
            </li>
          </ul>
        </li>

        <li class="slide {{ request()->routeIs('dashboard.group.*') ? 'is-expanded' : '' }}">
          <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="mdi mdi-shield-key-outline"></i><span class="side-menu__label">{!! trans('dashboard.group.groups') !!}</span><i class="angle fe fe-chevron-right"></i></a>
          <ul class="slide-menu">
            <li class="side-menu-label1">
              <a href="javascript:void(0)">{!! trans('dashboard.group.groups') !!}</a>
            </li>
            <li>
              <a href="{{ route('dashboard.group.index') }}" class="slide-item px-6 {{ request()->routeIs('dashboard.group.index') ? 'active' : '' }}"><i class="mdi mdi-file-document-multiple-outline"></i>
                {!! trans('dashboard.group.sub_progs.index') !!}</a>
            </li>
            <li>
              <a href="{{ route('dashboard.group.create') }}" class="slide-item px-6 {{ request()->routeIs('dashboard.group.create') ? 'active' : '' }}"><i class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.general.add') }}</a>
            </li>
          </ul>
        </li>

        <li class="slide {{ request()->routeIs('dashboard.admin.*') ? 'is-expanded' : '' }}">
          <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="mdi mdi-account-multiple-outline"></i><span class="side-menu__label">{!! trans('dashboard.admin.admins') !!}</span><i class="angle fe fe-chevron-right"></i></a>
          <ul class="slide-menu">
            <li class="side-menu-label1">
              <a href="javascript:void(0)">{!! trans('dashboard.admin.admins') !!}</a>
            </li>
            <li>
              <a href="{{ route('dashboard.admin.index') }}" class="slide-item px-6 {{ request()->routeIs('dashboard.admin.index') ? 'active' : '' }}"><i class="mdi mdi-file-document-multiple-outline"></i>
                {!! trans('dashboard.admin.sub_progs.index') !!}</a>
            </li>
            <li>
              <a href="{{ route('dashboard.admin.create') }}" class="slide-item px-6 {{ request()->routeIs('dashboard.admin.create') ? 'active' : '' }}"><i class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.general.add') }}</a>
            </li>
          </ul>
        </li>
        <li class="slide {{ request()->routeIs('dashboard.client.*') ? 'is-expanded' : '' }}">
          <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="mdi mdi-account-heart-outline"></i><span class="side-menu__label">{!! trans('dashboard.client.clients') !!}</span><i
                class="angle fe fe-chevron-right"></i></a>
          <ul class="slide-menu">
            <li class="side-menu-label1">
              <a href="javascript:void(0)">{!! trans('dashboard.client.clients') !!}</a>
            </li>
            <li>
              <a href="{!! route('dashboard.client.index') !!}" class="slide-item px-6 {{ request()->routeIs('dashboard.client.index') ? 'active' : '' }}"><i class="mdi mdi-file-document-multiple-outline"></i>
                {!! trans('dashboard.employee.sub_progs.index') !!}</a>
            </li>
            <li>
              <a href="{!! route('dashboard.client.create') !!}" class="slide-item px-6 {{ request()->routeIs('dashboard.client.index') ? 'active' : '' }}"><i class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.general.add') }}</a>
            </li>
          </ul>
        </li>
        <li class="slide">
          <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="mdi mdi-archive-arrow-down-outline"></i><span class="side-menu__label">الأرشيف</span><i class="angle fe fe-chevron-right"></i></a>
          <ul class="slide-menu">
            <li class="side-menu-label1">
              <a href="javascript:void(0)">الأرشيف</a>
            </li>
            <li>
              <a href="../archive/departments-archive.html" class="slide-item px-6"><i class="mdi mdi-view-dashboard-edit-outline"></i>
                أرشيف الأقسام</a>
            </li>
            <li>
              <a href="../archive/jobs-archive.html" class="slide-item px-6"><i class="mdi mdi-briefcase-edit-outline"></i> أرشيف
                الوظائف</a>
            </li>
          </ul>
        </li>
        <li class="slide">
          <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i class="mdi mdi-chart-line"></i><span class="side-menu__label">المتابعة</span><i class="angle fe fe-chevron-right"></i></a>
          <ul class="slide-menu">
            <li class="side-menu-label1">
              <a href="javascript:void(0)">المتابعة</a>
            </li>
            <li>
              <a href="../followup/activity-log.html" class="slide-item px-6"><i class="mdi mdi-file-document-multiple-outline"></i>
                سجل النشاطات</a>
            </li>
          </ul>
        </li>
        <li class="slide">
          <a class="side-menu__item" data-bs-toggle="slide" href="../blacklist.html"><i class="mdi mdi-account-cancel-outline"></i><span class="side-menu__label">القائمة
              السوداء</span></a>
        </li>
        <li class="slide">
          <a class="side-menu__item" data-bs-toggle="slide" href="../settings.html"><i class="mdi mdi-cog-outline"></i><span class="side-menu__label">الإعدادات</span></a>
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

            @auth
            {!! Form::open(['route' => 'dashboard.session.logout', 'method' => 'POST', 'id' => 'logout_form']) !!}
            <a class="nav-link icon" onclick="document.getElementById('logout_form').submit();" style="cursor: pointer;">
              <i class="mdi mdi-logout"></i>
              <span class="mx-2">تسجيل خروج</span>
            </a>
            {!! Form::close() !!}
            @endauth
          </div>
        </div>
      </div>
    </footer>
  </div>
  <!--/APP-SIDEBAR-->
</div>