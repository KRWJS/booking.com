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
      <div class="col-md-5 col-md-offset-1 col-sm-6 col-xs-6 col-apply col-apply--stepTwo u-mr-20">
        <p>@lang('messages.job_apply.first.1st')</p>
        <h3>@lang('messages.job_apply.first.personal')</h3>
      </div>
      <div class="col-md-5 col-sm-6 col-xs-6 col-apply col-apply--stepOne u-mr-0">
        <p>@lang('messages.job_apply.second.2st')</p>
        <h3>@lang('messages.job_apply.second.question')</h3>
      </div>
    </div>


    {{ Form::open(array('route' => 'jobs-apply-complete','data-toggle'=>'validator', 'role' => 'form')) }}
    {{Form::hidden("apply_id",$apply->id)}}

    <div class="container u-p-0">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 col-md-offset-1--input col-sm-12 col-xs-12 u-p-0">

          @foreach ($questions as $num => $item)

          <div class="form-group">
            @if($item->type == 'input_text')
              <label for="linkedinProfile" class="control-label">{{$item->question}} <sup>*</sup></label>
              @if($item->question == 'LinkedIn Profile' && $apply->linkedin_url != "")
                {{Form::text("$item->name",$apply->linkedin_url,array('class'=>'default-input form-control','required'=>'required','data-error'=>trans("messages.validation.question_text")))}}
              @else  
                {{Form::text("$item->name",null,array('class'=>'default-input form-control','required'=>'required','data-error'=>trans("messages.validation.question_text")))}}
              @endif
            @elseif($item->type == 'boolean')
              <label for="linkedinProfile" class="control-label">{{$item->question}} <sup>*</sup></label>
              <div class="radio">
              <label>
               <input type="radio" name="{{$item->name}}" id="{{$item->name}}" value="1" data-error="@lang('messages.validation.question_boolean')" required>  @lang('messages.job_apply.yes')
              </label>
            </div>
              <div class="radio">
              <label>
              <input type="radio" name="{{$item->name}}" id="{{$item->name}}" value="0" data-error="@lang('messages.validation.question_boolean')" required>  @lang('messages.job_apply.no')
              </label>
            </div>
            @elseif($item->type == 'multi_value_single_select')

            <div class="form-group form-group--select u-mt-0 u-t-60">
              <label for="linkedinProfile" class="control-label">{{$item->question}} <sup>*</sup></label>
              <select id="{{$item->name}}" name="{{$item->name}}" data-error="@lang('messages.validation.question_single')" required>
                <option value="" selected></option>
                @foreach($item->answers()->orderBy('answer')->get() as $QA)
                <option value="{{$QA->answer}}">{{$QA->label}}</option>
                @endforeach
              </select>
              <div class="help-block with-errors"></div>
            </div>

            @elseif($item->type == 'multi_value_multi_select')
              <label for="linkedinProfile" class="control-label">{{$item->question}} <sup>*</sup></label>

              <div class="checkbox checkbox--inline">
                @foreach($item->answers()->orderBy('answer')->get() as $qidx => $QA)
                <input type="checkbox" name="{{$item->name}}[]" id="answers_cb_{{$qidx}}" class="answers" value="{{$QA->answer}}" >  <label for="answers_cb_{{$qidx}}" class="animated-check">{{$QA->label}}</label>
                @endforeach
              </div>

            @elseif($item->type == 'textarea')
              <label for="linkedinProfile" class="control-label">{{$item->question}} <sup>*</sup></label>

              {{Form::textarea("$item->name",null,array('class'=>'default-input form-control','required'=>'required','data-error'=>trans('messages.validation.question_text')))}}


            @endif
            <div class="help-block with-errors"></div>
          </div>


          @endforeach

          <button type="submit" class="btn btn-booking-default--blue btn-apply-submit">@lang('messages.job_apply.submit')</button>

        </div>
      </div>

    </div>

    {{ Form::close() }}


  </div>
</div>

</div>
</div>
</div>
@endsection
