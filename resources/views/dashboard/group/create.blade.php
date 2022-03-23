@extends('dashboard.layouts.master')
@include('dashboard.group.style')

@section('title', trans('dashboard.group.sub_progs.create'))

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="permissions-record.html"> سجل الصلاحيات</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        إضافة مجموعة
      </li>
    </ol>
  </nav>
</div>
<!-- PAGE-HEADER END -->


<!-- ROW OPEN -->
{!! Form::open(['route' => 'dashboard.group.store', 'method' => 'POST', 'class' => 'needs-validation', 'id' => 'formId', 'files' => true, 'novalidate']) !!}
@include('dashboard.group._form',['btn_submit' => trans('dashboard.general.save')])
{!! Form::close() !!}

@endsection
