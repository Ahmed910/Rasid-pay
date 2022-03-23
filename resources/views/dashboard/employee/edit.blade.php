@extends('dashboard.layouts.master')
@include('dashboard.employee.style')

@section('title', trans('dashboard.employee.edit_employee'))

@section('content')

<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('dashboard.employee.index') }}">
          {{ trans('dashboard.employee.sub_progs.index') }}
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ trans('dashboard.employee.edit_employee') }}
      </li>
    </ol>
  </nav>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW OPEN -->
{!! Form::model($employee, ['route' => ['dashboard.employee.update', $employee->id], 'method' => 'PUT', 'class' => 'needs-validation', 'id' => 'formId', 'files' => true, 'novalidate']) !!}
@include('dashboard.employee._form',['btn_submit' => trans('dashboard.general.edit')])
{!! Form::close() !!}

@endsection
