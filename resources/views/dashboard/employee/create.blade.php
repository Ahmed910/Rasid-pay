@extends('dashboard.layouts.master')
@include('dashboard.employee.style')

@section('title', trans('dashboard.employee.sub_progs.create'))

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('dashboard.employee.index') }}">{{ trans('dashboard.employee.sub_progs.index') }}
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ trans('dashboard.employee.sub_progs.create') }}
      </li>
    </ol>
  </nav>
</div>
<!-- PAGE-HEADER END -->


<!-- ROW OPEN -->
{!! Form::open(['route' => 'dashboard.employee.store', 'method' => 'POST', 'class' => 'needs-validation', 'id' => 'formId', 'files' => true, 'novalidate']) !!}
@include('dashboard.employee._form',['btn_submit' => trans('dashboard.general.save')])
{!! Form::close() !!}

@endsection
