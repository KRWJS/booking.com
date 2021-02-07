<div class="panel panel-default">
    <div class="panel-heading">{{ Str::beautify($imageFieldName) }}</div>
    <div class="panel-body">

        <div class="form-group{{ $errors->has($imageFieldName) ? ' has-error' : '' }}">
            {{ Form::label($imageFieldName, Str::beautify($imageFieldName)) }} <span class="text-muted">(@if(isset($required)) Required, @else Optional, @endif @if($size == 's')Max size: 200 KB @elseif($size == 'm')Max size: 500 KB @elseif($size == 'l')Max size: 1 MB @endif )</span>
            <div class="fileinput @if ($imageField) fileinput-exists @else fileinput-new @endif" data-provides="fileinput">
                <!-- New file image -->
                <div class="fileinput-new thumbnail thumbnail--{{ $size }}"><div class="no-image"><img data-src="/images/placeholders/no-image.gif" src="/images/placeholders/no-image.gif"></div></div>

                <!-- Selected image preview box -->
                <div class="fileinput-preview fileinput-exists thumbnail thumbnail--{{ $size }}">
                    @if ($imageField)
                    <a href="{{ $imageField }}" target="_blank" title="Click to view full image"><img data-src="/images/placeholders/no-image.gif" src="@if($size == 's'){{ Image::crop($imageField, 190, 140) }}@elseif($size == 'm'){{ Image::crop($imageField, 190, 140) }}@elseif($size == 'l'){{ Image::crop($imageField, 390, 190) }}@endif"></a>
                    @endif
                </div>

                <!-- Error block -->
                <div class="fileinput-error-block thumbnail thumbnail--{{ $size }}">
                    <div class="text-danger bg-danger">Error</div>
                </div>

                <!-- Input fields and buttons -->
                <div>
                    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                      {{ Form::file($imageFieldName.'_file', ['data-image-validation' =>  $imageValidationType]) }}
                    </span>
                    @if (isset($required))
                        {{ Form::text($imageFieldName, null, ['required' => 'required', 'class' => 'js-image-input l-is-visually-hidden']) }}
                    @else
                        {{ Form::text($imageFieldName, null, ['class' => 'js-image-input l-is-visually-hidden']) }}
                    @endif
                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
                @include('admin.partials.form-error', ['field' => $imageFieldName])
            </div>
        </div>

        <div class="form-group{{ $errors->has($imageFieldName.'_alt') ? ' has-error' : '' }}">
            {{ Form::label($imageFieldName.'_alt', Str::beautify($imageFieldName.'_description')) }}
            {{ Form::text($imageFieldName.'_alt', null, ['class' => 'form-control']) }}
            @include('admin.partials.form-error', ['field' => $imageFieldName.'_alt'])
        </div>

    </div>
</div>
