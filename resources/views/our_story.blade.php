@extends('layouts.main')
@section('content')
@include('partials.primary_nav', ['activeOnScroll' => true])
@include('partials.mobile_nav')
<header class="header-image header-image--our-story">
  @include('partials.job_search')
</header>
<div class="container container-intro l-standard-padding">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h1>@lang('messages.our_story.intro.title')</h1>
      <p>@lang('messages.our_story.intro.content') </p>
    </div>
  </div>
</div>
<div class="container-fluid u-light-blue-bg carousel--story">
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="slick-slider slick-slider--story">
          <div>
            <div class="col-md-6 u-p-0">
              <img src="../images/our-story/our-story--slide-one.svg" class="img-responsive"/>
            </div>
            <div class="col-md-6 u-p-0 u-vcenter--carousel">
              <h2>@lang('messages.our_story.stories.title_1')</h2>
              <p>@lang('messages.our_story.stories.story_1')</p>
            </div>
          </div>
          <div>
            <div class="col-md-6 u-p-0">
              <img src="../images/our-story/our-story--slide-two.svg" class="img-responsive"/>
            </div>
            <div class="col-md-6 u-p-0 u-vcenter--carousel">
              <h2>@lang('messages.our_story.stories.title_2')</h2>
              <p>@lang('messages.our_story.stories.story_2')</p>
            </div>
          </div>
          <div>
            <div class="col-md-6 u-p-0">
              <img src="../images/our-story/our-story--slide-three.svg" class="img-responsive"/>
            </div>
            <div class="col-md-6 u-p-0 u-vcenter--carousel">
              <h2>@lang('messages.our_story.stories.title_3')</h2>
              <p>@lang('messages.our_story.stories.story_3')</p>
            </div>
          </div>
          <div>
            <div class="col-md-6 u-p-0">
              <img src="../images/our-story/our-story--slide-four.svg" class="img-responsive"/>
            </div>
            <div class="col-md-6 u-p-0 u-vcenter--carousel">
              <h2>@lang('messages.our_story.stories.title_4')</h2>
              <p>@lang('messages.our_story.stories.story_4')</p>
            </div>
          </div>
          <div>
            <div class="col-md-6 u-p-0">
              <img src="../images/our-story/our-story--slide-five.svg" class="img-responsive"/>
            </div>
            <div class="col-md-6 u-p-0 u-vcenter--carousel">
              <h2>@lang('messages.our_story.stories.title_5')</h2>
              <p>@lang('messages.our_story.stories.story_5')</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1 u-p-0">
        <img src="../images/our-story/our-story--full-width.jpg" class="img-responsive u-large-margin-top u-fw" width="100%" />
      </div>
    </div>
  </div>
</div>
@endsection
