@extends('dashboard.layouts.master')
@include('dashboard.client.style')

@section('title', trans('dashboard.client.edit_client'))

@section('content')

<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('dashboard.client.index') }}">
          {{ trans('dashboard.client.sub_progs.index') }}
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ trans('dashboard.client.edit_client') }}
      </li>
    </ol>
  </nav>
</div>
<!-- PAGE-HEADER END -->


@endsection
