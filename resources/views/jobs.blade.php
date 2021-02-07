@extends('layouts.main')
@section('content')
<header>
	@include('partials.primary_nav')
	@include('partials.mobile_nav')
	@if($data['jobs_competition_amount']>0)
	<div class="alert alert-default alert-dismissible alert--jobs" role="alert">

		<button type="button" class="close close--jobs js-close--jobs" data-dismiss="alert" aria-label="Close">
			<i class="booking-close fa-times--close" aria-hidden="true"></i>
		</button>

		{!! trans_choice('messages.jobs.notification', $data['jobs_competition_amount'], ['competition_amount' => $data['jobs_competition_amount']]) !!}

	</div>
	@endif
</header>
<div class="container-fluid u-light-blue-bg">
	<div class="container">
		<div class="row row-intro-jobs">
			<div class="col-md-10 col-md-offset-1 text-center">
				<h1>{!! trans('messages.jobs.title', ['opening_jobs_amount' => $data['opening_jobs_amount']]) !!}</h1>
			</div>
		</div>
		@include('partials.job_search_openings')
		<div class="row">
			<div class="col-md-10 col-md-offset-1 u-equalHMVWrap u-eqWrap">
				@if($errors)

				<div>
					@if(isset($validationErrors))
					{{ implode('<br>', $validationErrors->all()) }}
					@else
					{{ $feedback }}
					@endif
				</div>

				@else

				@include('partials.job_search_results')

				<div class="js-loadmore-loading is-hidden u-equalHMVWrap u-eqWrap u-p-0"></div>
				@endif

			</div>
		</div>

		@if($hasMore)
		<div class="row loadmore">
			<div class="col-md-10 col-md-offset-1 text-center">
				<button class="btn btn-booking-default--blue js-loadmore-btn">@lang('messages.jobs.more')</button>
			</div>
		</div>
		@endif

	</div>
</div>
@endsection
