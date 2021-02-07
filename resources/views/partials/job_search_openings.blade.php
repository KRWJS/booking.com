<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="row row-filter">
        {{ Form::open(['route' => ['jobs'], 'method' => 'POST', 'class' => 'form-inline form-inline--keyword-search js-loadmore-form', 'files' => false, 'autocomplete' => 'off']) }}
        {{ Form::hidden('page', 1, array('id' => 'page')) }}

        <div class="col-md-5 col-sm-12 col-xs-12 u-pr-7 u-r-mtb-5">
          <div class="form-group form-group--keyword-search u-p-0">

            {{ Form::text('query', null, ['class' => 'keyword-search form-control', 'placeholder' => trans('messages.partials.keywords'), 'maxlength' => 80]) }}

          </div>
        </div>

        <div class="col-md-5 col-sm-12 col-xs-12 u-pl-7 u-r-mtb-5">
          <div class="form-group form-group--keyword-search-select u-mt-0 u-mb-0">
            <select id="city" name="city">
              <option value="" selected>@lang('messages.partials.city')</option>
              @foreach($cities as $city_item)
              <option value="{{$city_item->city}}" @if($city_item == $city) selected="selected" @endif>{{$city_item->city_cn}}</option>
              @endforeach

            </select>
          </div>
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 u-p-search-0 u-r-mtb-5">
          <button type="submit"
          class="btn btn-booking-default--blue u-p-search-button fs-15 u-fw u-pl-0 u-pr-0">@lang('messages.partials.search')</button>
        </div>
        {{ Form::close() }}
    </div>
  </div>
</div>
