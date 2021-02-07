@extends('layouts.main')
@section('content')
<header class="header-image header-image--home">
  @include('partials.primary_nav', ['activeOnScroll' => true])
  @include('partials.mobile_nav')

  @if($jobs_last_amount>0)
  <div class="alert alert-default alert-dismissible" role="alert">

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <i class="booking-close fa-times--close" aria-hidden="true"></i>
    </button>

    {!! trans('messages.notifications.new_jobs', ['new_jobs' => $jobs_last_amount]) !!}
  </div>
  @endif

  @include('partials.job_search')
</header>
<div class="container container-intro l-standard-padding l-standard-padding--home">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h1>@lang('messages.index.lead.title')</h1>
      <p>@lang('messages.index.lead.body')</p>
      <a href="{{route('our-story')}}" class="arrow-link">@lang('messages.index.lead.find_out_more')</a>
    </div>
  </div>
</div>
<div class="container-fluid u-light-blue-bg carousel--vacancy">
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h2>@lang('messages.index.hot_jobs.title')</h2>
        <div class="slick-slider slick-slider--vacancy">
          @foreach($jobs as $job)
          <div>
            <a class="btn btn-booking-lg--white js-match-height" href="{{route('jobs-detail',['id'=>$job->id])}}" role="button"><span>{{ $job->title }}</span>{{ $job->department }}

              <ul class="list-inline u-mt-15">
                @if($job->flag != '')<li><img src="images/flag-icons/{{$job->flag}}.svg" width="20px" height="15px"/></li>@endif
                <li>{!! trans('messages.cities.'.$job->city) !!}</li>
              </ul>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="row carousel--spacer-margin">
      <div class="col-md-10 col-md-offset-1 text-center">
        <a class="btn btn-booking-default--blue" href="{{route('jobs')}}" role="button">@lang('messages.index.hot_jobs.show_all')</a>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6 u-p-0">
      <img src="images/index/index-image--left.jpg" class="img-responsive u-fw" width="100%" height="100%"/>
    </div>
    <div class="col-md-6 u-p-0 hidden-sm hidden-xs">
      <img src="images/index/index-image--right.jpg" class="img-responsive u-fw" width="100%" height="100%"/>
    </div>
  </div>
</div>
<div class="container l-standard-padding l-standard-padding--bullets">
  <div class="row">
    <div class="col-md-10 col-md-offset-1 col--bullet-title title-centered--tablet">
      <h2>@lang('messages.index.why_join.title')</h2>
    </div>
  </div>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <ol class="ol-default ol-2-cols ol-default--hire">
        <li>
          <div class="ol-default--title">
            @lang('messages.index.why_join.reason_1_title')
          </div>
          <div class="ol-default--body">
            @lang('messages.index.why_join.reason_1_body')
          </div>
        </li>
        <li>
          <div class="ol-default--title">
            @lang('messages.index.why_join.reason_2_title')
          </div>
          <div class="ol-default--body">
            @lang('messages.index.why_join.reason_2_body')
          </div>
        </li>
        <li>
          <div class="ol-default--title">
            @lang('messages.index.why_join.reason_3_title')
          </div>
          <div class="ol-default--body">
            @lang('messages.index.why_join.reason_3_body')
          </div>
        </li>
        <li>
          <div class="ol-default--title">
            @lang('messages.index.why_join.reason_4_title')
          </div>
          <div class="ol-default--body">
            @lang('messages.index.why_join.reason_4_body')
          </div>
        </li>
      </ol>
    </div>
  </div>
  <div class="row">
    <div class="col-md-10 col-md-offset-1 text-left title-centered--tablet">
      <a href="{{route('our-story')}}" class="arrow-link arrow-link--center">@lang('messages.index.why_join.show_all')</a>
    </div>
  </div>
</div>
@endsection
