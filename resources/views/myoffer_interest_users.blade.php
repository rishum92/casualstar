<?php //echo '<pre>';print_r($myoffer_interested_users);exit;
foreach ($myoffer_interested_users as $myoffersusers) {
?>
<div class="row"> 
  <div class="col-md-12">
    <div> 
      @if($myoffersusers->img == '')
      <img class="view_pro_pic" src="img/59ce3646d240c.png" />
      @else
      <img class="view_pro_pic" src="img/{{ $myoffersusers->img }}" />
      @endif
    </div>
    <div class="view_users_link">
       <h3><a href="{{url('users/'.$myoffersusers->username)}}" class="view_users_link"><span>{{$myoffersusers->username}}</span></a></h3>
    </div> 
    <div class="my_offer_date"> 
      <span>{{$myoffersusers->created_at}}</span>
    </div>
    <div class="my_offer_msg">
      <span class="label label-danger cursor-pointer" onclick="$('#message_{{$myoffersusers->id}}').show();">
        <i class="fa fa-paper-plane"></i> Message
      </span>
    </div>
  </div>
  
  <div class="col-md-12" id="message_{{$myoffersusers->id}}" style="display: none;">
    <br/>
    <textarea  class="form-control"  id="offer_message_{{$myoffersusers->id}}">Hello female {{$myoffersusers->username}}, you have shown interest in my offer (offer id #{{$myoffersusers->post_id}}) and I would like to discuss it with you please…?”.
    </textarea>
    <hr/>
    
    <button type="button" class="btn btn-xs btn-default" onclick="$('#message_{{$myoffersusers->id}}').hide();">Close</button>
    <button type="button" class="btn btn-xs btn-default btn_interested" onclick="send_offer_message({{$myoffersusers->post_id}}, {{$myoffersusers->id}}); $('#message_{{$myoffersusers->id}}').hide();">Send message</button>
  </div>
</div>
<?php 
}
?>