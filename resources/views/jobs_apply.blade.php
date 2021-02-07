@extends('layouts.main')
@section('content')
<header>
  @include('partials.primary_nav', ['activeOnScroll' => false])
  @include('partials.mobile_nav')
</header>
<div class="container-fluid u-light-blue-bg">
  <div class="container">
    <div class="row row-intro-apply">
      <div class="col-md-10 col-md-offset-1 text-center">
        <h1>{{$jobs->title}}</h1>
        <p><span>{{ucfirst($jobs->city)}}, {{ucfirst($jobs->country)}}</span> — <span>{{$jobs->entity}}</span></p>
      </div>
    </div>
    <div class="row row-apply-steps">
      <div class="col-md-5 col-md-offset-1 col-sm-6 col-xs-6 col-apply col-apply--stepOne">
        <p>@lang('messages.job_apply.first.1st')</p>
        <h3>@lang('messages.job_apply.first.personal')</h3>
      </div>
      <div class="col-md-5 col-sm-6 col-xs-6 col-apply col-apply--stepTwo">
        <p>@lang('messages.job_apply.second.2st')</p>
        <h3>@lang('messages.job_apply.second.question')</h3>
      </div>
    </div>

    
    <div class="row row-apply-linkedin u-vcenter hidden-sm hidden-xs">
      <div class="col-md-5 col-md-offset-1 u-p-0 u-m-0">
        @if($linkedin['is_linkedin'] == false && $jobs->is_required_resume == 0)<a href="{{$linkedin['ln_url']}}" class="btn btn-linkedin"><span><i class="booking-linkedin" aria-hidden="true"></i></span>@lang('messages.job_apply.linkedin')</a>@endif
      </div>
      <div class="col-md-5">
        <p><sup>*</sup>@lang('messages.job_apply.required')</p>
      </div>
    </div>
    

    <div class="row row-apply-linkedin visible-sm visible-xs">
      <div class="col-sm-12 col-xs-12 u-p-0 u-m-0">
        <a href="#" class="btn btn-linkedin"><span><i class="booking-linkedin" aria-hidden="true"></i></span>@lang('messages.job_apply.linkedin')</a>
      </div>
      <div class="col-sm-12 col-xs-12 u-p-0">
        <p><sup>*</sup>@lang('messages.job_apply.required')</p>
      </div>
    </div>

    {{ Form::open(array('route' => 'jobs-apply-submit','data-toggle'=>'validator', 'files' => true, 'role' => 'form')) }}
    {{ csrf_field() }}
    {{Form::hidden('is_linkedin',$linkedin['is_linkedin'])}}
    {{Form::hidden("parent_id",$jobs->id)}}
    {{Form::hidden("job_id",$jobs->job_id)}}
    {{Form::hidden("post_id",$jobs->post_id)}}
    {{Form::hidden("is_required_coverletter",$jobs->is_required_coverletter)}}
    @if($linkedin['is_linkedin'] == true) {{Form::hidden("linkedin_url",$linkedin['resume']['publicProfileUrl'])}} @endif

    <div class="row">
      <div class="col-md-5 col-md-offset-1 col-md-offset-1--input col-sm-12 col-xs-12 u-p-0">
        <div class="form-group">
          <label for="firstName" class="control-label">
            @lang('messages.job_apply.first_name') <sup>*</sup>
          </label>

          {{Form::text("first_name",$linkedin['resume']['firstName'],array('id'=>'firstName','class'=>'default-input form-control','required'=>'required','data-required-error'=>trans('messages.validation.first_name')))}}

          <div class="help-block with-errors">
            @if ($errors->has('first_name'))
              <ul class="list-unstyled">
                <li>{{ $errors->first('first_name')}}</li>
              </ul>
            @endif            
          </div>
        </div>
      </div>
      <div class="col-md-5 col-sm-12 col-xs-12 u-p-0">
        <div class="form-group">
          <label for="lastName" class="control-label">
            @lang('messages.job_apply.last_name') <sup>*</sup>
          </label>

          {{Form::text("last_name",$linkedin['resume']['lastName'],array('id'=>'lastName','class'=>'default-input form-control','required'=>'required','data-required-error'=>trans('messages.validation.last_name')))}}

          <div class="help-block with-errors">
            @if ($errors->has('last_name'))
              <ul class="list-unstyled">
                <li>{{ $errors->first('last_name')}}</li>
              </ul>
            @endif            
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5 col-md-offset-1 col-md-offset-1--input col-sm-12 col-xs-12 u-p-0">
        <div class="form-group">
          <label for="email" class="control-label">@lang('messages.job_apply.email') <sup>*</sup></label>

          {{Form::email("email",$linkedin['resume']['emailAddress'],array('id'=>'email','class'=>'default-input form-control','required'=>'required','data-required-error'=>trans('messages.validation.email')))}}

          <div class="help-block with-errors">
            @if ($errors->has('email'))
              <ul class="list-unstyled">
                <li>{{ $errors->first('email')}}</li>
              </ul>
            @endif            

          </div>
        </div>
      </div>
      <div class="col-md-5 col-sm-12 col-xs-12 u-p-0">
        <div class="form-group">
          <label for="phone" class="control-label">@lang('messages.job_apply.mobile') <sup>*</sup></label>

          {{Form::tel("mobile",$linkedin['resume']['phoneNumbers'],array('id'=>'phone','class'=>'default-input form-control','required'=>'required','pattern'=>'*0-9','data-pattern-error'=>'Minimum of 8 digits required.','data-minlength'=>'8','data-required-error'=>trans('messages.validation.phone')))}}

          <div class="help-block with-errors">
            @if ($errors->has('mobile'))
              <ul class="list-unstyled">
                <li>{{ $errors->first('mobile')}}</li>
              </ul>
            @endif            
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3 col-md-offset-1 col-sm-12 col-xs-12 u-p-0">
        <div class="form-group">
          <label for="resume">@lang('messages.job_apply.resume') <sup>*</sup></label>
          <input type="file" name="resume" id="resume" class="custom-upload" data-multiple-caption="{count} files selected" multiple required data-required-error="@lang('messages.validation.resume')" />
          <label for="resume" class="resume-validate">
            <img src="/images/svg-icons/svg-icons--desktop.svg" width="22px" />
            <span>@lang('messages.job_apply.computer')</span>
          </label>
          <div class="help-block with-errors">
            @if ($errors->has('resume'))
              <ul class="list-unstyled">
                <li>{{ $errors->first('resume')}}</li>
              </ul>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3 col-md-offset-1 col-sm-12 col-xs-12 u-p-0">
        <div class="form-group">
          <label for="cover_letter">@lang('messages.job_apply.coverletter') @if($jobs->is_required_resume == 1) <sup>*</sup> @endif</label>
          <input type="file" name="cover_letter" id="cover_letter" class="custom-upload" data-multiple-caption="{count} files selected" multiple @if($jobs->is_required_resume == 1) required data-required-error="@lang('messages.validation.cover_letter')" @endif/>
          <label for="cover_letter" class="coverletter-validate">
            <img src="/images/svg-icons/svg-icons--desktop.svg" width="22px" />
            <span>@lang('messages.job_apply.computer')</span>
          </label>

          <div class="help-block with-errors">
            @if ($errors->has('cover_letter'))
              <ul class="list-unstyled">
                <li>{{ $errors->first('cover_letter')}}</li>
              </ul>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12 u-p-0">
        <div class="checkbox form-group">
          <input type="checkbox" name="terms" id="terms" data-error="@lang('messages.validation.term')" required>
          <label for="terms" class="animated-check">@lang('messages.job_apply.term1') <span><a href="https://workingatbooking.com/privacy-cookies/" target="_blank">@lang('messages.job_apply.term2')</a></span> <sup>*</sup></label>
          <div class="help-block with-errors"></div>
        </div>
        <button type="submit" class="btn btn-booking-default--blue btn-apply-next">@lang('messages.job_apply.next')</button>
      </div>
    </div>
    {{ Form::close() }}
  </div>
</div>
</div>
@endsection
