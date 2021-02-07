@extends('admin.layouts.admin')

@section('content')

{!! Breadcrumbs::renderIfExists() !!}

<div class="page-title-well">
    <h2><i class="fa fa-wrench"></i> Edit page {{ $page->getPageTitle() }}</h2>
    <p class="subtitle">Any changes made are only put live after clicking the "Save" button</p>
</div>

@include('admin.partials.notifications')

{!! Form::model($page, ['route' => ['comasy.page.update', $id], 'method' => 'PUT', 'class' => 'form form-admin', 'files' => true]) !!}

    <div class="form-group">
        @include('admin.partials.toggle', ['field' => 'published', 'on' => 'Published', 'off' => 'Unpublished']) <span class="text-muted">(only published pages can be viewed on the website)</span>
    </div>

    <div class="form-group">
        @include('admin.partials.toggle', ['field' => 'listed', 'on' => 'Listed', 'off' => 'Unlisted']) <span class="text-muted">(only listed pages will be visible on the category's overview)</span>
    </div>

    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        {{ Form::label('title', 'Title') }}  <span class="text-muted">(Required, Max length: 30 characters)</span>
        {{ Form::text('title', null, ['class' => 'form-control input-lg character-counter', 'required' => 'required', 'placeholder' => 'title...', 'maxlength' => 30]) }}
        <p class="char-count-wrap"><span class="char-count">30</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'title'])
    </div>

    <div class="form-group{{ $errors->has('subtitle') ? ' has-error' : '' }}">
        {{ Form::label('subtitle', 'Subtitle') }} <span class="text-muted">(Max length: 15 characters)</span>
        {{ Form::text('subtitle', null, ['class' => 'form-control character-counter', 'placeholder' => 'subtitle...', 'maxlength' => 15]) }}
        <p class="char-count-wrap"><span class="char-count">15</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'subtitle'])
        <div class="help-block">The subtitle is displayed after the title, but in italic</div>
    </div>

    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
        {{ Form::label('slug', 'URL slug') }}  <span class="text-muted">(Unique, Required, Max length: 80 characters)</span>
        {{ Form::text('slug', null, ['class' => 'form-control character-counter url-warning', 'required' => 'required', 'maxlength' => 80]) }}
        <p class="char-count-wrap"><span class="char-count">80</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'slug'])
    </div>

    <div class="form-group{{ $errors->has('intro') ? ' has-error' : '' }}">
        {{ Form::label('intro', 'Intro') }} <span class="text-muted">(Max length: 180 characters, Optional)</span>
        {{ Form::textarea('intro', null, ['class' => 'form-control character-counter', 'placeholder' => 'intro...', 'maxlength' => 180, 'rows' => 5]) }}
        <p class="char-count-wrap"><span class="char-count">180</span> characters left</p>
        @include('admin.partials.form-error', ['field' => 'intro'])
        <div class="help-block">The intro is displayed on the overview pages</div>
    </div>

    <div class="form-group{{ $errors->has('weight') ? ' has-error' : '' }}">
        {{ Form::label('weight', 'Order') }} <span class="text-muted">(Required)</span>
        {{ Form::number('weight', null, ['class' => 'form-control', 'required' => 'required']) }}
        @include('admin.partials.form-error', ['field' => 'weight'])
        <div class="help-block">Determines the order in which the pages are sorted</div>
    </div>

    <div class="form-group{{ $errors->has('page_category_id') ? ' has-error' : '' }}">
        {{ Form::label('page_category_id', 'Category') }}  <span class="text-muted">(Required)</span>
        {{ Form::select('page_category_id', $pageCategories, null, ['class' => 'form-control', 'required' => 'required']) }}
        @include('admin.partials.form-error', ['field' => 'page_category_id'])
        <div class="help-block">Determines in which section of this website the page appears</div>
    </div>

    @include('admin.partials.image-upload', ['imageFieldName' => 'listing_image', 'imageField' => $page->listing_image, 'entityName' => 'page', 'size' => 'l', 'imageValidationType' => 'header_image', 'required' => 'required'])

    @include('admin.partials.image-upload', ['imageFieldName' => 'header_image', 'imageField' => $page->header_image, 'entityName' => 'page', 'size' => 'l', 'imageValidationType' => 'header_image'])

    @include('admin.block.section')

    @include('admin.partials.seo-options')

    <div class="form-actions">
        {!! Form::submit('Save', ['class' => 'btn btn-success btn-save']) !!}
        <a href="{{ route('comasy.page.index') }}" class="btn btn-default"><i class="fa fa-list"></i> Back to list</a>
    </div>

{!! Form::close() !!}

@endsection

@push('scripts')

    <script src="{{ asset('js/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/vendor/ckeditor/adapters/jquery.js') }}"></script>

@endpush
