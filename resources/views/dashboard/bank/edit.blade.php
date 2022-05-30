@extends('dashboard.layouts.master')

@section('title', trans('dashboard.bank.edit_bank'))

@section('content')

    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.bank.index') }}">
                        {{ trans('dashboard.bank.sub_progs.index') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  {{ trans('dashboard.bank.sub_progs.edit') }}

                </li>
            </ol>
        </nav>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW OPEN -->
  
    {!! Form::model($bank, ['route' => ['dashboard.bank.update', $bank->id], 'method' => 'PUT', 'class' => 'needs-validation', 'id' => 'formId', 'files' => true, 'novalidate']) !!}
    @include('dashboard.bank._form')
    {!! Form::close() !!}

@endsection
