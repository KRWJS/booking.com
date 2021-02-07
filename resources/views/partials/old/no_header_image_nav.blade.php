<!--
  1.0 - Primary Navigation
        _________________________________________

        This is the main navigation bar including the mega menu dropdown.

-->


<nav class="navbar-booking navbar-booking--fixed navbar-fixed-top js-navbar-booking hidden-xs">


  <!-- Start inner navigation container -->
  <div class="container">


    <!-- Start brand -->
    <div class="navbar-header navbar-header-booking">


      <!-- Booking logo with link to homepage -->
      <a class="booking-brand" href="/" title="Working at Booking.com">Working at Booking.com</a>


    </div><!-- //Brand -->


    <!-- Start nav links menu - floated to the right -->
    <ul class="nav navbar-nav navbar-right">


      <li><a href="{{route('our-story')}}">@lang('messages.navigation.about_us')</a></li>

      <li><a href="{{route('teams')}}">@lang('messages.navigation.teams')</a></li>

      <li><a href="{{route('how-we-hire')}}">@lang('messages.navigation.how_we_hire')</a></li>

      <li><a href="{{route('jobs')}}">@lang('messages.navigation.openings')</a></li>


    </ul><!-- //Nav links menu -->


  </div><!-- //Inner navigation container -->


</nav><!-- //1.0 - Navigation -->
