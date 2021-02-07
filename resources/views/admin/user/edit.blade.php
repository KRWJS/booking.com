@extends('admin.layouts.admin')

@section('content')

{!! Breadcrumbs::renderIfExists() !!}

<div class="page-title-well">
    <h2><i class="fa fa-wrench"></i> Edit user {{ $user->name }}</h2>
    <p class="subtitle">Any changes made are only put live after clicking the "Save" button</p>
</div>

@include('admin.partials.notifications')

{!! Form::model($user, ['route' => ['comasy.user.update', $id], 'method' => 'PUT', 'class' => 'form form-admin']) !!}

    <div class="form-group">
        @include('admin.partials.toggle', ['field' => 'activated', 'on' => 'Activated', 'off' => 'Deactivated']) <span class="text-muted">(only activated users can log in)</span>
    </div>

    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
        {{ Form::label('name', 'Name') }}  <span class="text-muted">(Required)</span>
        {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'name...']) }}
        @include('admin.partials.form-error', ['field' => 'name'])
    </div>

    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
        {{ Form::label('email', 'Email') }}  <span class="text-muted">(Required)</span>
        {{ Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'email...']) }}
        @include('admin.partials.form-error', ['field' => 'email'])
    </div>


    <div class="form-actions">
        {!! Form::submit('Save', ['class' => 'btn btn-success btn-save']) !!}
        <a href="{{ route('comasy.user.index') }}" class="btn btn-default"><i class="fa fa-list"></i> Back to list</a>
        <a href="#" class="btn-delete btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
    </div>

{!! Form::close() !!}

@include('admin.partials.form-delete', ['route' => 'comasy.user.destroy', 'id' => $user->id])

@endsection
