@extends('dashboard.layouts.master')
@section('title', trans('dashboard.client.sub_progs.index'))

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
  <h1 class="page-title">{{ trans('dashboard.client.sub_progs.account_order') }}</h1>
  
</div>
<!-- PAGE-HEADER END -->


@include('dashboard.layouts.modals.archive')
@include('dashboard.layouts.modals.not_archive')
@endsection
@include('dashboard.client.script')