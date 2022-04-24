@extends('dashboard.layouts.master')
@section('title', trans('dashboard.admin.sub_progs.create'))

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">

        <a href="{{ route('dashboard.admin.index') }}">{{ trans('dashboard.admin.sub_progs.index') }}
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ trans('dashboard.admin.sub_progs.create') }}
      </li>
    </ol>
  </nav>
</div>
<!-- PAGE-HEADER END -->


<!-- ROW OPEN -->
{!! Form::open(['route' => 'dashboard.admin.store', 'method' => 'POST', 'class' => 'needs-validation', 'id' => 'formId', 'files' => true, 'novalidate']) !!}
@include('dashboard.admin._form')
{!! Form::close() !!}

@endsection
