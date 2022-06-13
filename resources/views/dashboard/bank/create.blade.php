@extends('dashboard.layouts.master')
@section('title', trans('dashboard.bank.sub_progs.create'))

@section('content')

<!-- PAGE-HEADER -->
<div class="page-header">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('dashboard.bank.index') }}">{{ trans('dashboard.bank.sub_progs.index') }}
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ trans('dashboard.bank.sub_progs.create') }}
      </li>
    </ol>
  </nav>
</div>
<!-- PAGE-HEADER END -->

  <!-- ROW OPEN -->
  {!! Form::open(['route' => 'dashboard.bank.store', 'method'=>'POST','class' => 'needs-validation', 'id' => 'formId', 'novalidate' ,'autocomplete'=>"off"]) !!}
  @include('dashboard.bank._form')
  {!! Form::close() !!}

@endsection

