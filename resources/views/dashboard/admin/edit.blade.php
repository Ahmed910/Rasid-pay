@extends('dashboard.layouts.master')
@include('dashboard.admin.style')

@section('title', trans('dashboard.admin.edit_admin'))

@section('content')

<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('dashboard.admin.index') }}">
          {{ trans('dashboard.admin.sub_progs.index') }}
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ trans('dashboard.admin.edit_admin') }}
      </li>
    </ol>
  </nav>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW OPEN -->
{!! Form::model($admin, ['route' => ['dashboard.admin.update', $admin->id], 'method' => 'PUT', 'class' => 'needs-validation', 'id' => 'formId', 'files' => true, 'novalidate','autocomplete'=>"off"]) !!}
@include('dashboard.admin._form')
{!! Form::close() !!}

@endsection
