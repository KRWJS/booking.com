<!--
  1.1 - Secondary Navigation
        _________________________________________

        This is the secondary navigation bar including the mega menu dropdown and row of secondary links.

-->


<nav class="navbar-booking__secondary navbar-booking navbar-booking--fixed navbar-fixed-top js-navbar-booking hidden-xs">


  <!-- Start inner navigation container -->
  <div class="container">


    <!-- Start brand -->
    <div class="navbar-header navbar-header-booking">


      <!-- Booking logo with link to homepage -->
      <a class="booking-brand" href="/" title="Working at Booking.com">Working at Booking.com</a>


    </div><!-- //Brand -->


    <!-- Start nav links menu - floated to the right -->
    <ul class="nav navbar-nav navbar-right">


      <li><a href="/our-story">@lang('messages.navigation.about_us')</a></li>


      <!-- Start full width mega menu dropdown on hover -->
      <li class="dropdown navbar-booking-fw">


        <!-- Start mega menu link initialize -->
        <a href="/business">@lang('messages.navigation.teams')</a>


        <!-- Start mega menu dropdown list -->
        <ul class="dropdown-menu">


          <!-- Start mega menu dropdown list item wrapper -->
          <li>


            <!-- Start mega menu content container -->
            <div class="container navbar-booking--content">


              <!-- Start mega menu content row -->
              <div class="row">


                <!-- Start mega menu col-md-4 col-md-offset-1 -->
                <div class="col-md-4 col-md-offset-1">


                  <!-- Start mega menu links - left block -->
                  <ul class="navbar-booking--dropdown-list">


                    <li><a href="#" class="arrow-link">@lang('messages.subnav_teams.business')</a></li>
                    <li><a href="#" class="arrow-link">@lang('messages.subnav_teams.content')</a></li>
                    <li><a href="#" class="arrow-link">@lang('messages.subnav_teams.client')</a></li>
                    <li><a href="#" class="arrow-link">@lang('messages.subnav_teams.finance')</a></li>


                  </ul><!-- //Mega menu links - left block -->


                </div><!-- //Mega menu col-md-4 col-md-offset-1 -->


                <!-- Start mega menu col-md-4 -->
                <div class="col-md-4">


                  <!-- Start mega menu links - center block -->
                  <ul class="navbar-booking--dropdown-list">


                    <li><a href="#" class="arrow-link">@lang('messages.subnav_teams.leader')</a></li>
                    <li><a href="#" class="arrow-link">@lang('messages.subnav_teams.marketing')</a></li>
                    <li><a href="#" class="arrow-link">@lang('messages.subnav_teams.data')</a></li>
                    <li><a href="#" class="arrow-link">@lang('messages.subnav_teams.product')</a></li>


                  </ul><!-- //Mega menu links - center block -->


                </div><!-- //Mega menu col-md-4 -->


                <!-- Start mega menu col-md-3 (3 cols used to equal 12 in total) -->
                <div class="col-md-3">


                  <!-- Start mega menu links - right block -->
                  <ul class="navbar-booking--dropdown-list">


                    <li><a href="#" class="arrow-link">@lang('messages.subnav_teams.hr')</a></li>
                    <li><a href="#" class="arrow-link">@lang('messages.subnav_teams.support')</a></li>
                    <li><a href="#" class="arrow-link">@lang('messages.subnav_teams.potential')</a></li>
                    <!-- <li><a href="#" class="arrow-link"></a></li> -->


                  </ul><!-- //Mega menu links - right block -->


                </div><!-- //Mega menu col-md-3 -->


              </div><!-- //Mega menu content row -->


            </div><!-- //Mega menu content container -->


          </li><!-- //Mega menu dropdown list item wrapper -->


        </ul><!-- //Mega menu dropdown list -->


      </li><!-- //Full width mega menu dropdown on hover -->


      <li><a href="/jobs">@lang('messages.navigation.openings')</a></li>


    </ul><!-- //Nav links menu -->


  </div><!-- //Inner navigation container -->


</nav><!-- //1.0 - Navigation -->


<!-- Start secondary navigation -->
<nav class="navbar-booking__secondary--white navbar-fixed-top hidden-sm hidden-xs">


  <div class="row">


    <div class="col-md-2 col-md-offset-4 text-right u-p-0">


      <a href="/our-story">我们的故事</a>


    </div>


    <div class="col-md-2 text-left u-p-0">


      <a href="/how-we-hire" class="border-right active">成为缤客人</a>


    </div>


  </div>


</nav><!-- //Secondary navigation -->
