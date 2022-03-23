@extends('dashboard.layouts.master')

@section('title',trans('dashboard.job.sub_progs.create'))
@section('content')

<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="jobs-record.html"> سجل الوظائف</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        إضافة وظيفة
      </li>
    </ol>
  </nav>
</div>
{!! Form::open(['route'=>'dashboard.job.store', 'method' => 'POST', 'class' => 'needs-validation novalidate','id'=>'formId']) !!}
@include('dashboard.job._form')
{!! form::close() !!}

@endsection
