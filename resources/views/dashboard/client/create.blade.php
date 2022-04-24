@extends('dashboard.layouts.master')
@section('title', trans('dashboard.client.sub_progs.create'))

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('dashboard.client.index') }}">{{ trans('dashboard.client.sub_progs.index') }}
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ trans('dashboard.client.sub_progs.create') }}
      </li>
    </ol>
  </nav>
</div>
<!-- PAGE-HEADER END -->



@endsection
