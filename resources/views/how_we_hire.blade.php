@extends('layouts.main')
@section('content')
@include('partials.primary_nav', ['activeOnScroll' => true])
@include('partials.mobile_nav')
<header class="header-image header-image--how-we-hire">
  @include('partials.job_search')
</header>
<div class="container container-intro l-standard-padding">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h1>@lang('messages.how_we_hire.intro.title')</h1>
      <p>@lang('messages.how_we_hire.intro.content')</p>
    </div>
  </div>
</div>
<div class="container-fluid u-light-blue-bg">
  <div class="container container--hire-title">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h2>@lang('messages.how_we_hire.your_fits.title')</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 ol-2-cols col-md-offset-1">
        <ol class="ol-default ol-default--hire">
          <li><div class="ol-default--title">
            @lang('messages.how_we_hire.your_fits.fit_1_title')</div><div class="ol-default--body">@lang('messages.how_we_hire.your_fits.fit_1_body')</div></li>
            <li><div class="ol-default--title">@lang('messages.how_we_hire.your_fits.fit_2_title')</div><div class="ol-default--body">@lang('messages.how_we_hire.your_fits.fit_2_body')</div></li>
            <li><div class="ol-default--title">@lang('messages.how_we_hire.your_fits.fit_3_title')</div><div class="ol-default--body">@lang('messages.how_we_hire.your_fits.fit_3_body')</div></li>
            <li><div class="ol-default--title">@lang('messages.how_we_hire.your_fits.fit_4_title')</div><div class="ol-default--body">@lang('messages.how_we_hire.your_fits.fit_4_body')</div></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="container l-standard-padding hidden-sm hidden-xs">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h2>@lang('messages.how_we_hire.route')</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <img src="{{asset('images/how-we-hire/how-we-hire--roadmap.'.App::getLocale().'.svg')}}" class="img-responsive roadmap" width="100%" height="100%" />
      </div>
    </div>
  </div>
  <div class="container-fluid u-light-blue-bg l-container-hire-padding">
    <div class="container container-hire-content">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <h2>@lang('messages.how_we_hire.tips.title')</h2>
          <h3>@lang('messages.how_we_hire.tips.tip_1')</h3>
          <p>@lang('messages.how_we_hire.tips.intro_1')</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-10 col-md-offset-1 text-center u-p-0">
          <img src="../images/how-we-hire/how-we-hire--full-width.jpg" class="img-responsive" width="100%" />
        </div>
      </div>
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <h3>@lang('messages.how_we_hire.tips.tip_2')</h3>
          <p>@lang('messages.how_we_hire.tips.intro_2')</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <h3>@lang('messages.how_we_hire.tips.tip_3')</h3>
          <p>@lang('messages.how_we_hire.tips.intro_3')</p>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid hidden-sm hidden-xs">
    <div class="row">
      <div class="col-md-6 u-p-0">
        <img src="../images/how-we-hire/how-we-hire-image--left.jpg" class="img-responsive" width="100%" height="100%"/>
      </div>
      <div class="col-md-6 u-p-0">
        <img src="../images/how-we-hire/how-we-hire-image--right.jpg" class="img-responsive" width="100%" height="100%"/>
      </div>
    </div>
  </div>
</div>
@endsection
