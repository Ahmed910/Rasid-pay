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
        <form method="post" action="" class="needs-validation" novalidate>
            @include('dashboard.department._form')
        </form>
        <!-- ROW CLOSED -->
      </div>
      <!-- CONTAINER CLOSED -->
    </div>
  </div>

  <!--app-content closed-->

  @endsection
  @include('dashboard.department.script')

