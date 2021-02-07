<div class="visible-xs navbar-fixed-top">
  <nav class="navbar--mobile">
    <a class="booking-brand" href="{{route('home')}}" title="Working at Booking.com"><img class="navbar-header__logo" src="{{asset('images/logo.svg')}}" alt="Booking.com logo"></a>
    <ul class="nav--mobile">
      <a href="{{route('home')}}" title="Working at Booking.com"><img src="{{asset('images/logo.svg')}}" width="50%" class="logo--mobile img-responsive center-block" /></a>
      <li><a href="{{route('our-story')}}">@lang('messages.navigation.about_us')</a></li>
      <li><a href="{{route('how-we-hire')}}">@lang('messages.navigation.how_we_hire')</a></li>
      {{--<li>--}}
        {{--<a href="#area" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="area" class="js-dropdown-toggle dropdown-toggle collapsed">@lang('messages.navigation.how_we_hire')</a>--}}
        {{--<div id="area" class="collapse">--}}
          {{--<ul class="sub-nav--mobile">--}}
            {{--<li><a href="#">@lang('messages.subnav_teams.business')</a></li>--}}
            {{--<li><a href="#">@lang('messages.subnav_teams.content')</a></li>--}}
            {{--<li><a href="#">@lang('messages.subnav_teams.client')</a></li>--}}
            {{--<li><a href="#">@lang('messages.subnav_teams.finance')</a></li>--}}
            {{--<li><a href="#">@lang('messages.subnav_teams.leader')</a></li>--}}
            {{--<li><a href="#">@lang('messages.subnav_teams.marketing')</a></li>--}}
            {{--<li><a href="#">@lang('messages.subnav_teams.data')</a></li>--}}
            {{--<li><a href="#">@lang('messages.subnav_teams.product')</a></li>--}}
            {{--<li><a href="#">@lang('messages.subnav_teams.hr')</a></li>--}}
            {{--<li><a href="#">@lang('messages.subnav_teams.support')</a></li>--}}
            {{--<li><a href="#">@lang('messages.subnav_teams.potential')</a></li>--}}
            {{--<!-- <li><a href="#"></a></li> -->--}}
            {{--</ul>--}}
            {{--</div>--}}
            {{--</li>--}}
            <li><a href="{{route('jobs')}}">@lang('messages.navigation.openings')</a></li>
          </ul>
        </nav>
        <div class="nav--mobile-overlay">
          <span></span>
        </div>
        <div class="nav--mobile-content">
          <span></span>
        </div>
        <button class="hamburger hamburger--slider nav--mobile-trigger" type="button"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button>
      </div>
