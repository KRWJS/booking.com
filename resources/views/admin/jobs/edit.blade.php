@extends('admin.layouts.admin')

@section('content')

{!! Breadcrumbs::renderIfExists() !!}

<div class="page-title-well">
    <h2><i class="fa fa-wrench"></i> Edit Jobs</h2>
    <p class="subtitle">Any changes made are only put live after clicking the "Save" button</p>
</div>

@include('admin.partials.notifications')

{!! Form::model($jobs, ['route' => ['comasy.jobs.update', $id], 'method' => 'PUT', 'class' => 'form form-admin', 'files' => true]) !!}

    <div class="form-group">
        @include('admin.partials.toggle', ['field' => 'published', 'on' => 'Published', 'off' => 'Unpublished']) <span class="text-muted">(only published pages can be viewed on the website)</span>
    </div>


    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        {{ Form::label('title', 'Title') }}  <span class="text-muted">(Required, Max length: 30 characters)</span>
        {{ Form::text('title', null, ['class' => 'form-control input-lg character-counter', 'required' => 'required', 'placeholder' => 'title...', 'maxlength' => 30]) }}
        <p class="char-count-wrap"><span class="char-count">30</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'title'])
    </div>

    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
        {{ Form::label('slug', 'URL slug') }}  <span class="text-muted">(Unique, Required, Max length: 80 characters)</span>
        {{ Form::text('slug', null, ['class' => 'form-control character-counter url-warning', 'required' => 'required', 'maxlength' => 80]) }}
        <p class="char-count-wrap"><span class="char-count">80</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'slug'])
    </div>

    <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
        {{ Form::label('country', 'Country') }}  <span class="text-muted">(Unique, Required, Max length: 80 characters)</span>
        {{ Form::text('country', null, ['class' => 'form-control character-counter url-warning', 'required' => 'required', 'maxlength' => 80]) }}
        <p class="char-count-wrap"><span class="char-count">80</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'country'])
    </div>

    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
        {{ Form::label('city', 'City') }}  <span class="text-muted">(Unique, Required, Max length: 80 characters)</span>
        {{ Form::text('city', null, ['class' => 'form-control character-counter url-warning', 'required' => 'required', 'maxlength' => 80]) }}
        <p class="char-count-wrap"><span class="char-count">80</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'city'])
    </div>

    <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
        {{ Form::label('department', 'Department') }}  <span class="text-muted">(Unique, Required, Max length: 80 characters)</span>
        {{ Form::text('department', null, ['class' => 'form-control character-counter url-warning', 'required' => 'required', 'maxlength' => 80]) }}
        <p class="char-count-wrap"><span class="char-count">80</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'department'])
    </div>

    <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
        {{ Form::label('location', 'Location') }}  <span class="text-muted">(Unique, Required, Max length: 80 characters)</span>
        {{ Form::text('location', null, ['class' => 'form-control character-counter url-warning', 'required' => 'required', 'maxlength' => 80]) }}
        <p class="char-count-wrap"><span class="char-count">80</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'location'])
    </div>

    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
        {{ Form::label('description', 'Description') }} <span class="text-muted">(Max length: 180 characters, Optional)</span>
        {{ Form::textarea('description', null, ['class' => 'form-control character-counter', 'placeholder' => 'description...', 'maxlength' => 1800, 'rows' => 5]) }}
        <p class="char-count-wrap"><span class="char-count">180</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'description'])
        <div class="help-block">The description is displayed on the overview pages</div>
    </div>

    <div class="form-group{{ $errors->has('requirement') ? ' has-error' : '' }}">
        {{ Form::label('requirement', 'Requirement') }} <span class="text-muted">(Max length: 180 characters, Optional)</span>
        {{ Form::textarea('requirement', null, ['class' => 'form-control character-counter', 'placeholder' => 'requirement...', 'maxlength' => 1800, 'rows' => 5]) }}
        <p class="char-count-wrap"><span class="char-count">180</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'requirement'])
        <div class="help-block">The requirement is displayed on the overview pages</div>
    </div>

    <div class="form-group{{ $errors->has('responsibility') ? ' has-error' : '' }}">
        {{ Form::label('responsibility', 'Responsibility') }} <span class="text-muted">(Max length: 180 characters, Optional)</span>
        {{ Form::textarea('responsibility', null, ['class' => 'form-control character-counter', 'placeholder' => 'responsibility...', 'maxlength' => 1800, 'rows' => 5]) }}
        <p class="char-count-wrap"><span class="char-count">180</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'responsibility'])
        <div class="help-block">The responsibility is displayed on the overview pages</div>
    </div>


    <div class="form-actions">
        {!! Form::submit('Save', ['class' => 'btn btn-success btn-save']) !!}
        <a href="{{ route('comasy.jobs.index') }}" class="btn btn-default"><i class="fa fa-list"></i> Back to list</a>
    </div>

{!! Form::close() !!}

@endsection

@push('scripts')

    <script src="{{ asset('js/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/vendor/ckeditor/adapters/jquery.js') }}"></script>

@endpush
