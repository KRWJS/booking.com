<!DOCTYPE html>
<html lang="zh" prefix="og: http://ogp.me/ns#">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @section('opengraph-tags')@show
  <title>Booking.com China Careers</title>
  <link rel="icon" type="image/x-icon" href="/images/favicon.png" />
  <link href="/css/main.min.css" rel="stylesheet">
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  @yield('content')
  <div class="container-fluid default-upper-footer">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h4>@lang('messages.footer.follow_us')</h4>
          <ul class="list-inline list-inline__social-media--footer">
            <li><a href="https://www.linkedin.com/company-beta/11348?pathWildcard=11348" target="_blank"><i class="booking-linkedin" aria-hidden="true"></i></a></li>
            <li><a href="http://weibo.com/bookingcom" target="_blank"><i class="booking-weibo" aria-hidden="true"></i></a></li>
            <li><a data-toggle="modal" data-target="#weChatQR"><i class="booking-wechat" aria-hidden="true"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid default-lower-footer">
    <div class="container">
      <div class="row u-vcenter hidden-xs">
        <div class="col-md-4 text-left">
          <p>@lang('messages.footer.copyright', ["current_year" => date("Y")])&nbsp;&nbsp;&nbsp;&nbsp;沪ICP备17017214号-1</p>
        </div>
        <div class="col-md-8 text-right">
          <ul class="list-inline">
            <li>@if (App::isLocale('en'))<a href="https://www.booking.com/content/terms.en-gb.html" target="_blank">@lang('messages.footer.terms')</a>@else<a href="https://www.booking.com/content/terms.zh-cn.html" target="_blank">@lang('messages.footer.terms')</a>@endif</li>
            <li>@if (App::isLocale('en'))<a href="https://www.booking.com/content/privacy.en-gb.html" target="_blank">@lang('messages.footer.privacy')</a>@else<a href="https://www.booking.com/content/privacy.zh-cn.html" target="_blank">@lang('messages.footer.privacy')</a>@endif</li>
            <li>@if (App::isLocale('en'))<a href="https://www.booking.com/content/about.en-gb.html" target="_blank">@lang('messages.footer.about_booking')</a>@else<a href="https://www.booking.com/content/about.zh-cn.html" target="_blank">@lang('messages.footer.about_booking')</a>@endif</li>
            <li>@if (App::isLocale('en'))<a href="http://www.pricelinegroup.com/about/" target="_blank">@lang('messages.footer.about_priceline')</a>@else<a href="http://www.pricelinegroup.com/about/" target="_blank">@lang('messages.footer.about_priceline')</a>@endif</li>
          </ul>
        </div>
      </div>
      <div class="row visible-xs">
        <div class="col-xs-12 text-left u-p-0">
          <p>@lang('messages.footer.copyright', ["current_year" => date("Y")])&nbsp;&nbsp;&nbsp;&nbsp;沪ICP备17017214号-1 </p>
        </div>
        <div class="col-xs-12 text-left u-p-0">
          <ul class="list-inline">
            <li class="u-mtb-5">@if (App::isLocale('en'))<a href="https://www.booking.com/content/terms.html" target="_blank">@lang('messages.footer.terms')</a>@else<a href="https://www.booking.com/content/terms.zh-cn.html" target="_blank">@lang('messages.footer.terms')</a>@endif</li>
            <li class="u-mtb-5">@if (App::isLocale('en'))<a href="https://www.booking.com/content/privacy.en-gb.html" target="_blank">@lang('messages.footer.privacy')</a>@else<a href="https://www.booking.com/content/privacy.zh-cn.html" target="_blank">@lang('messages.footer.privacy')</a>@endif</li>
            <li class="u-mtb-5">@if (App::isLocale('en'))<a href="https://www.booking.com/content/about.en-gb.html" target="_blank">@lang('messages.footer.about_booking')</a>@else<a href="https://www.booking.com/content/about.zh-cn.html" target="_blank">@lang('messages.footer.about_booking')</a>@endif</li>
            <li class="u-mtb-5">@if (App::isLocale('en'))<a href="http://www.pricelinegroup.com/about/" target="_blank">@lang('messages.footer.about_priceline')</a>@else<a href="http://www.pricelinegroup.com/about/" target="_blank">@lang('messages.footer.about_priceline')</a>@endif</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  @include('partials.wechat_modal')

  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-75179807-2', 'auto');
    ga('send', 'pageview');

  </script>
  <script src="/js/main.min.js?v=1"></script>
  <script src="/js/modernizr.js"></script>
</body>
</html>
