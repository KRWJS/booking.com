@extends('layouts.main')
@section('content')
<header class="header-image header-image--home">
@include('partials.primary_nav', ['activeOnScroll' => true])
@include('partials.mobile_nav')
@include('partials.job_search')
</header>
<div class="container container-intro l-standard-padding l-standard-padding--home">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<h2 class="text-center">@lang('messages.404.title')</h2>
<p>@lang('messages.404.intro_1')</p>
<br />
<p>@lang('messages.404.intro_2')</p>
</div>
</div>
</div>
@endsection
