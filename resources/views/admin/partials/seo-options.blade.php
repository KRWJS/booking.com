<div class="panel panel-default">
    <div class="panel-heading panel-heading--big" role="tab" id="panel-heading">
        <h4 class="panel-title">
            <a class="collapsed collapsable-panel-link" role="button" data-toggle="collapse" href="#collapsable-panel" aria-expanded="false" aria-controls="collapsable-panel">
                Custom SEO options <i class="fa fa-caret-down"></i>
            </a>
        </h4>
    </div>
    <div id="collapsable-panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel-heading">
        <div class="panel-body seo-options">

            <div class="form-group">
                {{ Form::label('page_title', 'Page Title') }}  <span class="text-muted">(Max length: 65 characters)</span>
                {{ Form::text('page_title', null, ['class' => 'form-control character-counter page-title', 'maxlength' => 65]) }}
                <p class="char-count-wrap"><span class="char-count">65</span> characters left</p>
                @include('admin.partials.form-error', ['field' => 'page_title'])
            </div>

            <div class="form-group">
                {{ Form::label('meta_description', 'Meta Description') }}  <span class="text-muted">(Max length: 160 characters)</span>
                {{ Form::textarea('meta_description', null, ['class' => 'form-control character-counter text-area-sm meta-desc', 'maxlength' => 160]) }}
                <p class="char-count-wrap"><span class="char-count">160</span> characters left</p>
                @include('admin.partials.form-error', ['field' => 'meta_description'])
            </div>

            <div class="form-group">
                {{ Form::label('meta_keywords', 'Meta Keywords') }}  <span class="text-muted">(Max 5 keywords separated by comma's)</span>
                {{ Form::text('meta_keywords', null, ['class' => 'form-control js-keyword-counter', 'maxlength' => 150, 'data-max-keywords' => 5]) }}
                <p class="keyword-count-wrap"><span class="keyword-count">5</span> keywords left</p>
                @include('admin.partials.form-error', ['field' => 'meta_keywords'])
            </div>

            <div class="google-preview">
                <p class="gp-title"></p>
                <p class="gp-url"></p>
                <p class="gp-desc"></p>
            </div>

        </div>
    </div>
</div>