@extends('dashboard.layouts.master')
@include('dashboard.group.style')

@section('title', trans('dashboard.group.edit_group'))

@section('content')

    <div class="page-header">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('dashboard.group.index') }}">{{ trans('dashboard.group.sub_progs.index') }}
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            {{ trans('dashboard.group.edit_group') }}
          </li>
        </ol>
      </nav>
    </div>
<!-- PAGE-HEADER END -->

<!-- ROW OPEN -->
{!! Form::model($group, ['route' => ['dashboard.group.update', $group->id], 'method' => 'PUT', 'class' => 'needs-validation', 'id' => 'formId', 'files' => true, 'novalidate']) !!}
@include('dashboard.group._form',['btn_submit' => trans('dashboard.general.edit')])
{!! Form::close() !!}

@endsection
