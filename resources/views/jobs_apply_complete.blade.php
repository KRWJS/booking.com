@extends('layouts.main')
@section('content')
<header>
  @include('partials.primary_nav', ['activeOnScroll' => false])
  @include('partials.mobile_nav')
</header>
<div class="container-fluid u-light-blue-bg">
  <div class="container">
    <div class="row row-intro-apply">
      <div class="col-md-10 col-md-offset-1 col-thank-you">

        @if (App::getLocale() == 'en')

        <h1 class="text-center">Thank you, we will be in touch!</h1>
        <p>Dear applicant,</p>
        <p>We are excited you decided to apply for this job. We will take your application into consideration and one of our recruiters will be in touch. Please check your spam folder for our email(s). There is a possibility our correspondence could end up there.</p>
        <p>Thank you again and best regards,</p>
        <p>The Booking.com Recruitment Team</p>
        @else
        <h1 class="text-center">谢谢您的提交，我们会尽快处理</h1>
        <p>我们很高兴你决定申请这份工作。我们会考虑你的申请，我们的HR稍后会联系你。请检查你的电子邮件。</p>
        <p>Booking.com HR团队</p>
        <p></p>

        @endif

      </div>
      <div class="col-md-10 col-md-offset-1 text-center"><a class="btn btn-booking-default--blue" href="{{Route('jobs')}}">@lang('messages.job_apply.back')</a></div>
    </div>
  </div>
</div>
</div>
@endsection
