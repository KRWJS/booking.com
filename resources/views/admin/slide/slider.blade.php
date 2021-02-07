<div class="panel panel-default js-slider" data-maxlength="{{ isset($maxlength) ? $maxlength : 9 }}">
    <div class="panel-heading"><i class="fa fa-fw fa-files-o"></i> Slider</div>
    <div class="panel-body">

        <div class="js-slides-container">
            {{-- ### load existing slides ### --}}
            @if(isset($slides))
                @foreach($slides as $slide)

                    <div class="panel panel-default form-group js-slide">
                        <div class="panel-heading"><i class="fa fa-fw fa-file-image-o"></i>
                            {{ Form::label('slides['.$slide->id.'][image-file]', 'Slide') }} <span class="text-muted">(Required, Max size: 1 MB)</span>
                            <div class="pull-right tools"><a href="#" class="text-warning l-offset-xxs-right js-slide-up"><i class="fa fa-arrow-circle-up"></i></a><a href="#" class="text-warning l-offset-xxs-right js-slide-down"><i class="fa fa-arrow-circle-down"></i></a><a href="#" class="text-danger js-slide-remove"><i class="fa fa-trash"></i></a></div>
                        </div>
                        <div class="panel-body">
                            <div class="fileinput @if (isset($slide->image) && $slide->image != null) fileinput-exists @else fileinput-new @endif" data-provides="fileinput">
                                <!-- New file image -->
                                <div class="fileinput-new thumbnail thumbnail--l"><div class="no-image"><img data-src="/images/placeholders/no-image.gif" src="/images/placeholders/no-image.gif"></div></div>

                                <!-- Selected image preview box -->
                                <div class="fileinput-preview fileinput-exists thumbnail thumbnail--l">
                                    @if (isset($slide->image) && $slide->image != null)
                                        <a href="{{ $slide->image }}" target="_blank" title="Click to view full image"><img data-src="/images/placeholders/no-image.gif" src="{{ Image::crop($slide->image, 390, 190) }}"></a>
                                    @endif
                                </div>

                                <!-- Error block -->
                                <div class="fileinput-error-block thumbnail thumbnail--l">
                                    <div class="text-danger bg-danger">Error</div>
                                </div>

                                <!-- Input fields and buttons -->
                                <div>
                                    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>{{ Form::file('slides['.$slide->id.'][image-file]', ['data-image-validation' =>  'block_single_image']) }}</span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    {{ Form::text('slides['.$slide->id.'][image]', isset($slide->image) ? $slide->image : null, ['required' => 'required', 'class' => 'js-image-input l-is-visually-hidden']) }}
                                    {{ Form::hidden('slides['.$slide->id.'][weight]', isset($slide->weight) ? $slide->weight : null, ['required' => 'required', 'class' => 'js-slide-weight']) }}
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach

            @else

                <div class="panel panel-default form-group js-slide">
                    <div class="panel-heading"><i class="fa fa-fw fa-file-image-o"></i>
                        {{ Form::label('slides[-1][image-file]', 'Slide') }} <span class="text-muted">(Required, Max size: 1 MB)</span>
                        <div class="pull-right tools"><a href="#" class="text-warning l-offset-xxs-right js-slide-up"><i class="fa fa-arrow-circle-up"></i></a><a href="#" class="text-warning l-offset-xxs-right js-slide-down"><i class="fa fa-arrow-circle-down"></i></a><a href="#" class="text-danger js-slide-remove"><i class="fa fa-trash"></i></a></div>
                    </div>
                    <div class="panel-body">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <!-- New file image -->
                            <div class="fileinput-new thumbnail thumbnail--l"><div class="no-image"><img data-src="/images/placeholders/no-image.gif" src="/images/placeholders/no-image.gif"></div></div>

                            <!-- Selected image preview box -->
                            <div class="fileinput-preview fileinput-exists thumbnail thumbnail--l"></div>

                            <!-- Error block -->
                            <div class="fileinput-error-block thumbnail thumbnail--l">
                                <div class="text-danger bg-danger">Error</div>
                            </div>

                            <!-- Input fields and buttons -->
                            <div>
                                <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>{{ Form::file('slides[-1][image-file]', ['required'  =>  'required', 'data-image-validation' =>  'block_single_image']) }}</span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                {{ Form::text('slides[-1][image]', null, ['required' => 'required', 'class' => 'js-image-input l-is-visually-hidden']) }}
                                {{ Form::hidden('slides[-1][weight]', null, ['required' => 'required', 'class' => 'js-slide-weight']) }}
                            </div>
                        </div>
                    </div>
                </div>

            @endif

        </div>

        <div class="form-group">
            <a href="#" class="btn btn-success js-slides-add"><i class="fa fa-plus"></i> Add another slide</a>
        </div>


        <div class="panel panel-default form-group js-slide skeleton hidden">
            <div class="panel-heading"><i class="fa fa-fw fa-file-image-o"></i>
                {{ Form::label('slides[__slide_index__][image-file]', 'Slide') }} <span class="text-muted">(Required, Max size: 1 MB)</span>
                <div class="pull-right tools"><a href="#" class="text-warning l-offset-xxs-right js-slide-up"><i class="fa fa-arrow-circle-up"></i></a><a href="#" class="text-warning l-offset-xxs-right js-slide-down"><i class="fa fa-arrow-circle-down"></i></a><a href="#" class="text-danger js-slide-remove"><i class="fa fa-trash"></i></a></div>
            </div>
            <div class="panel-body">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <!-- New file image -->
                    <div class="fileinput-new thumbnail thumbnail--l"><div class="no-image"><img data-src="/images/placeholders/no-image.gif" src="/images/placeholders/no-image.gif"></div></div>

                    <!-- Selected image preview box -->
                    <div class="fileinput-preview fileinput-exists thumbnail thumbnail--l"></div>

                    <!-- Error block -->
                    <div class="fileinput-error-block thumbnail thumbnail--l">
                        <div class="text-danger bg-danger">Error</div>
                    </div>

                    <!-- Input fields and buttons -->
                    <div>
                        <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>{{ Form::file('slides[__slide_index__][image-file]', ['disabled' => 'disabled', 'required'  =>  'required', 'data-image-validation' =>  'block_single_image']) }}</span>
                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        {{ Form::text('slides[__slide_index__][image]', null, ['required' => 'required', 'class' => 'js-image-input l-is-visually-hidden', 'disabled' => 'disabled']) }}
                        {{ Form::hidden('slides[__slide_index__][weight]', null, ['required' => 'required', 'class' => 'js-slide-weight', 'disabled' => 'disabled']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>