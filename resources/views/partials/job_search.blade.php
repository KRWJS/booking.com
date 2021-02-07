<div class="container container--search">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="row row-filter">
        {{ Form::open(['route' => ['jobs'], 'method' => 'POST', 'class' => 'form js-search-form', 'files' => false, 'autocomplete' => 'off']) }}
        {{ csrf_field() }}

        <div class="col-md-5 col-sm-12 col-xs-12 u-pr-7 u-r-mtb-5">
          <div class="form-group form-group--keyword-search u-p-0">

            {{ Form::text('query', null, ['class' => 'keyword-search form-control', 'placeholder' => trans('messages.partials.keywords'), 'maxlength' => 80]) }}

          </div>
        </div>
        <div class="col-md-5 col-sm-12 col-xs-12 u-pl-7 u-r-mtb-5">
          <div class="form-group form-group--keyword-search-select u-mt-0 u-mb-0">
            <select id="city" name="city">
              <option value="" selected>@lang('messages.partials.city')</option>
              @foreach($cities as $city)
              <option value="{{$city->city}}">{{$city->city_cn}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 u-p-search-0 u-r-mtb-5">
          <button type="submit"
          class="btn btn-booking-default--blue u-p-search-button fs-15 u-fw u-pl-0 u-pr-0">@lang('messages.partials.search')</button>
          {{ Form::close() }}
        </div>
</div>
</div>
</div>
</div>
