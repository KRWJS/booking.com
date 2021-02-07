@if ($errors->has($field))
    <span class="error-block">
        <strong>{!! implode('<br>', $errors->get($field)) !!}</strong>
    </span>
@endif

