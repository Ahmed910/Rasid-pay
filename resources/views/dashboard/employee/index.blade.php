@extends('dashboard.layouts.master')
@section('title', 'Page Title')

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
  <h1 class="page-title">{{ trans('dashboard.employee.sub_progs.index') }}</h1>
  <a href="{!! route('dashboard.employee.create') !!}" class="btn btn-primary">
    <i class="mdi mdi-plus-circle-outline"></i> {{ trans('dashboard.employee.sub_progs.create') }}
  </a>
</div>
<!-- PAGE-HEADER END -->

@include('dashboard.layouts.modals.archive')
@include('dashboard.layouts.modals.not_archive')
@endsection
@include('dashboard.employee.script')
