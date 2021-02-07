<div class="modal fade" id="weChatQR" tabindex="-1" role="dialog" aria-labelledby="weChatQR">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-content--wechatqr hidden-xs">
      <div class="modal-header modal-header--wechatqr">

        <button type="button" class="close close--jobs close--wechatqr" data-dismiss="modal" aria-label="Close">
    			<i class="booking-close fa-times--close" aria-hidden="true"></i>
    		</button>

        <h4 class="modal-title modal-title--wechatqr" id="weChatQR">
          @lang('messages.footer.follow_wechat')
        </h4>

      </div>
      <div class="modal-body">
        <img class="center-block img-responsive" src="{{asset('images/social/social-wechat--qr-code.jpg')}}">
      </div>
    </div>
    <div class="modal-content modal-content--wechatqr visible-xs">
      <div class="modal-header modal-header--wechatqr">

        <button type="button" class="close close--jobs close--wechatqr" data-dismiss="modal" aria-label="Close">
    			<i class="booking-close fa-times--close" aria-hidden="true"></i>
    		</button>

        <h4 class="modal-title modal-title--wechatqr"
        id="weChatQRMobile">
          @lang('messages.footer.follow_wechat')
        </h4>
      </div>
      <div class="modal-body">
        <img class="center-block img-responsive" src="{{asset('images/social/social-wechat--follow-instructions.jpg')}}">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <ol class="ol-default">
                <li><p>@lang('messages.footer.follow_wechat_step_1')</p></li>
                <li><p>@lang('messages.footer.follow_wechat_step_2')</p></li>
              </ol>
            </div>
          </div>
        </div>
        <a href="#" role="button" class="btn-booking-default--blue btn-booking-default--blue--wechatqr"
        target="_blank">@lang('messages.footer.follow_wechat_note_2')</a>
      </div>
    </div>
  </div>
</div>
