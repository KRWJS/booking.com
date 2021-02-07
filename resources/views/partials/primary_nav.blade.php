<nav class="navbar-booking navbar-booking--fixed navbar-fixed-top js-navbar-booking hidden-xs @if(!isset($activeOnScroll) || !$activeOnScroll) scrolled @endif" @if(isset($activeOnScroll) && $activeOnScroll) data-fade-nav="true" @endif>
  <div class="container">
    <div class="navbar-header navbar-header-booking">
      <a class="booking-brand" href="{{route('home')}}" title="Working at Booking.com"><img class="navbar-header__logo" src="{{asset('images/logo.svg')}}" alt="Booking.com logo"></a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="{{route('our-story')}}">@lang('messages.navigation.about_us')</a></li>
      <li><a href="{{route('how-we-hire')}}">@lang('messages.navigation.how_we_hire')</a></li>
      <li><a href="{{route('jobs')}}">@lang('messages.navigation.openings')</a></li>
      
      </ul>
    </div>
  </nav>
