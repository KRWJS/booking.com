@extends('layouts.main')
@section('opengraph-tags')
@parent
<meta property="og:title" content="{{$jobs->title}}" />
<meta property="og:description" content="" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{Request::fullUrl()}}" />
@endsection
@section('content')
<header class="header-image header-image--description">
	@include('partials.primary_nav', ['activeOnScroll' => true])
	@include('partials.mobile_nav')
</header>
<div class="container-fluid u-light-blue-bg u-p-0">
	<div class="container container-intro container-intro--cta l-standard-padding">
		<div class="row">
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 text-center container-intro-col--cta js-vacancy-fixed">
				<div class="vacancy-fixed-wrapper">
					<h1>{{$jobs->title}}</h1>
					<p><span>{!! trans('messages.cities.'.$jobs->city) !!}，{{$country}}</span> — <span>{{$jobs->entity}}</span></p>
					<a class="btn btn-booking-default--blue btn-applynow" href="{{route('jobs-apply')}}?id={{$jobs->id}}" role="button">@lang('messages.job_details.applynow')</a>
				</div>
			</div>
		</div>
	</div>
	<div class="container container-job-description hidden-sm hidden-xs">
		<div class="row">
			<div class="col-md-10 col-md-offset-1 job-description-intro">
				<p>@lang('messages.job_details.introduction')</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center job-description-image u-p-0">
				<img src="/images/jobs/jobs--full-width.jpg" class="img-responsive" width="100%" height="100%"/>
			</div>
		</div>
		<div class="row">


			<div class="col-md-10 col-md-offset-1">
				<h2>@lang('messages.job_details.description')</h2>
				<div class="job-description">
					{!!$jobs->description!!}
				</div>
			</div>
		</div>
		<div class="row job-description-social">
			<div class="col-md-12 text-center">
				<ul class="list-inline list-inline__social-media--job-description">
					<li><a data-toggle="modal" data-target="#share-vacancy-wechat-modal">
						<span class="booking-wechat-colour"></span></a></li>
						<li><a href="#" data-share-to-weibo='{"url": "{{Request::fullUrl()}}", "title": "@lang('messages.job_details.sharing_title') — {{$jobs->title}}"}'>
							<span class="booking-weibo-colour"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></a></li>
							<li><a href="#" data-share-to-linkedin='{"url": "{{Request::fullUrl()}}"}'><span class="booking-linkedin-colour"></span></a></li>
							<li><a href="mailto:?subject=@lang('messages.job_details.sharing_title')&body={{urlencode(Request::fullUrl())}}"><span class="booking-email-colour"></span></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="container container-job-description visible-sm visible-xs">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 job-description-intro">
						<p>@lang('messages.job_details.introduction')</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 text-center">
						<ul class="list-inline list-inline--read-more js-list-inline--read-more u-vcenter">
							<li><hr/></li>
							<li><a href="#jdMore" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="jdMore" class="read-more js-read-more">@lang('messages.job_details.showall')</a></li>
							<li><hr/></li>
						</ul>
					</div>
				</div>
				<div class="collapse" id="jdMore">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<h2>@lang('messages.job_details.description')</h2>
							<div class="job-description">
								{!!$jobs->description!!}
							</div>

						</div>
					</div>

	<div class="row">
		<div class="col-sm-12 text-center">
			<ul class="list-inline list-inline--read-more u-vcenter js-read-less">
				<li><hr/></li>
				<li><a href="#jdMore" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="jdMore" class="read-less">@lang('messages.job_details.retraction')</a></li>
				<li><hr/></li>
			</ul>
		</div>
	</div>
</div>
<div class="row job-description-social">
	<div class="col-md-12 text-center">
		<ul class="list-inline list-inline__social-media--job-description">
			<!-- <li><a data-toggle="modal" data-target="#share-vacancy-wechat-modal"><span class="booking-wechat-colour"></span></a></li> -->
			<li><a href="#" data-share-to-weibo='{"url": "{{Request::fullUrl()}}", "title": "@lang('messages.job_details.sharing_title') — {{$jobs->title}}"}'><span class="booking-weibo-colour"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></a></li>
			<li><a href="#" data-share-to-linkedin='{"url": "{{Request::fullUrl()}}"}'<span class="booking-linkedin-colour"></span></a></li>
			<li><a href="mailto:?subject=@lang('messages.job_details.sharing_title')&body={{urlencode(Request::fullUrl())}}"><span class="booking-email-colour"></span></a></li>
		</ul>
		<a class="btn btn-booking-default--blue btn-applynow" href="{{route('jobs-apply')}}?id={{$jobs->id}}" role="button">@lang('messages.job_details.applynow')</a>
	</div>
</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 u-p-0 hidden-sm hidden-xs">
			<img src="/images/jobs/jobs-image--left.jpg" class="img-responsive u-fw" width="100%" height="100%"/>
		</div>
		<div class="col-md-6 u-p-0 hidden-sm hidden-xs">
			<img src="/images/jobs/jobs-image--right.jpg" class="img-responsive u-fw" width="100%" height="100%"/>
		</div>
	</div>
</div>
<div class="container container-job-description--vacancy">
	<div class="row">
		<div class="col-md-12 text-center">
			<h2>@lang('messages.job_details.relative')</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

			@foreach($relative_jobs as $rel_jobs)
			<a class="btn btn-booking-lg--white js-match-height" href="{{route('jobs-detail',['id'=>$rel_jobs->id])}}" role="button">@if(date('Y-m-d',strtotime($rel_jobs->created_at)) == date('Y-m-d'))<h4 class="ribbon ribbon--red">@lang('messages.jobs.new')</h4>@elseif($rel_jobs->apply()->count() >10)<h4 class="ribbon ribbon--orange">@lang('messages.jobs.hot')</h4>@endif <span>{{$rel_jobs->title}}</span>{{$rel_jobs->department}}
				
				<ul class="list-inline u-mt-15">
					@if($rel_jobs->flag != '')<li><img src="/images/flag-icons/{{$rel_jobs->flag}}.svg" class="flag flag--china"/></li>@endif
					<li>{!! trans('messages.cities.'.$rel_jobs->city) !!}</li>
				</ul>
				
			</a>

			@endforeach

	</div>
</div>
<div class="row">
	<div class="col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
		<a class="btn btn-booking-default--blue u-fw" href="/jobs" role="button">@lang('messages.job_details.more')</a>
	</div>
</div>
</div>
</div>
<div class="modal fade" id="share-vacancy-wechat-modal" tabindex="-1" role="dialog" aria-labelledby="share-vacancy-wechat-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content--wechatqr hidden-xs">
			<div class="modal-header modal-header--wechatqr">

				<a href="#" class="close close--wechatqr" data-dismiss="modal" aria-label="Close">
          <i class="booking-close" aria-hidden="true"></i>
        </a>

				<h4 class="modal-title modal-title--wechatqr" id="share-vacancy-wechat-modal">
					@lang('messages.job_details.social_sharing.wechat.title')
				</h4>

			</div>
			<div class="modal-body text-center">
				{!! QrCode::size(430)->generate(Request::url()) !!}
			</div>
		</div>
		<div class="modal-content modal-content--wechatqr visible-xs">
			<div class="modal-header modal-header--wechatqr">

				<a href="#" class="close close--wechatqr" data-dismiss="modal" aria-label="Close">
          <i class="booking-close" aria-hidden="true"></i>
        </a>

				<h4 class="modal-title modal-title--wechatqr" id="weChatQRMobile">
					@lang('messages.job_details.social_sharing.wechat.title')
				</h4>

			</div>
			<div class="modal-body">
				<div class="u-display-inline">
					<span class="bullet-point--ol bullet-point--wechatqr">01</span><p>@lang('messages.footer.follow_wechat_note_1')</p>
				</div>
				<div class="u-display-inline">
					<input id="weChatLink" class="input--copy" value="{{Request::url()}}">
					<button class="btn--copy" data-clipboard-target="#weChatLink"><i class="fa fa-files-o" aria-hidden="true"></i></button>
				</div>
				<div class="u-display-inline">
					<span class="bullet-point--ol bullet-point--wechatqr">02</span><p>@lang('messages.footer.follow_wechat_note_2')</p>
				</div>
				<a href="#" role="button" class="btn-booking-default--blue btn-booking-default--blue--wechatqr" target="_blank">@lang('messages.footer.follow_wechat_note_2')</a>
			</div>
		</div>
	</div>
</div>
@endsection
