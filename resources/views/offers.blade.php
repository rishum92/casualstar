<?php //echo "<pre>";print_r($notification_data);die; ?>
@extends('layouts.master')

@section('style')
  <link href="{{ URL::asset('css/supersubs.css') }}" rel="stylesheet">
@endsection

@section('meta')
  <title>Super Subs » CasualStar</title> 
@endsection

@section('content')

<?php date_default_timezone_set("GMT");?>
 @if(Auth::user()->gender == 'male')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>  

 <!-- mal start -->
<div data-ng-controller="SuperSubsController">
    <div class="wrap">
      <div class="highlight">
       <center> Post an Offer with a generous amount for any relevant desire you may have for a female to fulfil. Interest you receive for your Offers can eventually gain you access to ALL Private Galleries.</center>
       <hr/>
       <div class="row">
         <div class="col-md-12">
           <div class="col-md-2">
            <form method="post" action="{{url('offerpost')}}" autocomplete="off">
               <!-- <div class="usd_offer">USD</div>  -->
             <select class="form-control" name="currency" required>
               <option value="">Select Currency</option>
               <option value="A$">AUD</option>
               <option value="BHD">BHD</option>
               <option value="C$">CAD</option>
               <option value="¥">CNH</option>
               <option value="SFr.">CHF</option>
               <option value="€">EUR</option>
               <option value="£">GBP</option>
               <option value="円">JPY</option>
               <option value="JOD">JOD</option>
               <option value="KYD">KYD</option>
               <option value="KD">KWD</option>
               <option value="NZD">NZD</option>
               <option value="OMR">OMR</option>
               <option value="kr">SEK</option>
               <option value="$">USD</option>
               <option value="R">ZAR</option>
             </select>
           </div>
           <div class="col-md-3">
              
             <div class="form-group">
               {{csrf_field()}}
               <input type="hidden" name="hiddenname" id="hiddenid">
               <input type="text" id="myField"  maxlength="8"  pattern="^[\d,]+$"  class="form-control" required="required" name="offerrate" placeholder="1,054"/>
             </div>

            </div>
            <div class="col-md-5">
              <div class="form-group ">
                <input type="text" class="form-control" maxlength="100" minlength="10" required="required" name="offerdetails"  placeholder="I would like to help with your bills."/>
                <p class="info_icon">
                <a href="#" data-toggle="tooltip" data-placement="bottom" data-html="true" title="<div style='width:180px;'>Use this box to briefly detail your desire for which you want a Femdom to fulfil. Examples: I desire a custom video of female in shower. Or, I wish to be owned. Or, I would like to help with your bills.etc</div>">
                  <i class="fa fa-info-circle"></i>
                </a>
                <script>
                  $(document).ready(function(){
                  $('[data-toggle="tooltip"]').tooltip();   
                  });
                </script>
                </p>
              </div>
            </div>
            <div class="col-md-2">
             <div>
               <div class="form-group">
                 <button type="submit" class="btn btn-default btn_offer"><i class="fa fa-paper-plane"></i> Post</button>
               </div>
             </div>
           </div>
         </div>
      </div>
    </div>
  </div>
  
  <!-- male end -->
  @else
   <!-- femal start -->
    <div data-ng-controller="SuperSubsController">
    <div class="wrap">
      <div class="highlight">
       <center>Click the interested button to let the ad poster know you’re interested. If
they wish to, they will contact you to discuss your offer in more detail if necessary. Only the
first 10 interests will be logged for each Offer.</center>
     </div>
  </div>
   <!-- femal end -->
    @endif
    <div class="wrap">
       <div class="row">
         <div class="col-md-12">
           <?php //echo "<pre>"; print_r($offerpost);die; ?> 
            @foreach($offerpost as $offers)
             <div class="col-md-6 offer_container_grid">
              
                @if(in_array($offers->post_id, $user_posts))
                  <div class="offer_content_shadow2  offer_cont_shadow">
                @else
                  <div class="offer_cont_shadow offer_content_shadow_default">
                @endif 

                    <div class="offer_left">
                      <a href="{{url('users/'.$offers->username)}}">
                        @if($offers->img == '')
                        <img src="img/male.jpg" class="offer_pro_pic" />
                        @else
                        <img src="img/users/{{$offers->username}}/previews/{{$offers->img}}" class="offer_pro_pic" />
                        @endif
                      </a>
                      <h3>
                        <a href="{{url('users/'.$offers->username)}}"><span>{{$offers->username}}</span>
                        </a>
                      </h3>
                    </div>
                    <div class="offer_right">
                      <h3><span>{{$offers->currency}}{{$offers->offer_rate}}</span></h3>
                    </div> 
                    <div class="offer_detailes_box">
                      <p>
                        {{$offers->offer_details}}
                      </p>
                    </div>
                    <br/>
                    @if(Auth::user()->gender == 'male')
                       <button type="button" disabled class="btn btn-default btn_interested">
                         <i class="fa fa-thumbs-up"></i> Interested
                       </button>
                    @else

                      @if($offers->intrest_count < 10)
                        <a href="{{url('interested/'.$offers->post_id. '/' . $offers->id)}}">
                          <button type="submit" class="btn btn-default btn_interested">
                          <i class="fa fa-thumbs-up" ></i> Interested
                          </button>
                        </a>
                      @else
                       <a href="#">
                       <button type="submit" disabled class="btn btn-default btn_interested">
                         <i class="fa fa-thumbs-up"></i> Interested
                       </button>
                       </a>
                      @endif
                    @endif
                 
                    <!-- popup call -->
                      <span class="viewOffers cursor-pointer" onclick="interestedcount(<?php echo $offers->post_id; ?>)">{{$offers->intrest_count}}</span>
                    <!-- pop call close -->  
                      
                      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.js"></script>
                      @if($offers->intrest_count < 10)
                        <span class="post_remaining" id="clock{{$offers->post_id}}"></span>
                        <span class="post_remaining">
                        <?php 
                          $date_a = new DateTime(date("F j, Y, H:i:s"));
                          $date_b = new DateTime($offers->offer_post_date);
                          $interval = date_diff($date_a,$date_b);
                          $stop_date = date('Y-m-d H:i:s', strtotime($offers->offer_post_date . ' +1 day'));
                        
                          $interval_days = $interval->format('%a');
                          //rint_r($interval_days);
                          if ($interval_days > 0) 
                          {
                            echo '<font style="color:red;">Closed</font>';
                            // echo "<script>$('#interested_btn{{$offers->post_id}}').attr('disabled','true'); </script>";
                          }
                          else
                          {
                        ?>
                          <script type="text/javascript">
                          $('#clock{{$offers->post_id}}').countdown("{{$stop_date}}", function(event) 
                          { 
                            
                            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                            var totalMins = event.strftime('%M');
                            var totalSecs = event.strftime('%S');
                            if(totalHours < 12)
                            {
                              console.log('greet12');
                              $(this).css("color", "red").html();
                            }
                            if(totalHours==0 && totalMins==0 && totalSecs==0)
                            {
                              $(this).html('<font style="color:red;">Closed</font>');
                              // $("#interested_btn{{$offers->post_id}}").attr("disabled","true");
                          }
                            else {
                              $(this).html(event.strftime(totalHours + ' : %M : %S Remaining'));
                            }
                          });
                        </script>
                        <?php
                          }  
                        ?>
                        </span>
                        
                      @else
                       <span class="post_closed">Closed</span>
                      @endif 
                      <br/><br/>
                    <span class="offer_id">Id: #{{$offers->post_id}}</span>
                     @if($offers->user_id == Auth::user()->id OR Auth::user()->username == 'Admin')
                      <a onclick = "delete_confirmation({{$offers->post_id}})"><span class="fa fa-trash offer_delete"></span></a>
                     @endif 
                  </div> 
                  
               </div>
               <!--Delete Confirmation Start-->
               <script>
              function delete_confirmation(post_id) {
               $('#delete_confirmation_popup').modal('show');
               $('#post_id').val(post_id);
              }
              </script>
              <!--Delete Confirmation Popup Close-->
              <div class="modal fade" id="delete_confirmation_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to delete this post?
                    </div>
                    <input type="hidden" name="post_id" id="post_id">
                    <div class="modal-footer">
                      <button class="btn btn-primary" data-dismiss="modal" id="confirm_delete">Yes</button>
                      <button class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                  </div>
                </div>
              </div>
            <!--Delete Confirmation Popup End-->
            <!--Delete Confirmation PopupAjax Start-->
            <script>
              $("#confirm_delete").click(function() {
                var post_id = $("#post_id").val();
                  $.ajax({
                    type: 'GET',
                    url: 'delete/'+post_id,
                    success:function(data)
                    {
                      location.reload();
                    }
                  });
                });
            </script>
            <!--Delete Confirmation PopupAjax Close-->

              <!-- popup  Modal start -->
              <div class="modal fade" id="popupmodal" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Interested Users</h4>
                    </div>
                    <div class="modal-body" id="interested_model_id"></div>
                    <div class="modal-footer">
                      <button type="button" id="refreshdata" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  
                </div>
              </div>
              <!-- popup modal close--> 
              
              @endforeach
         
            
            <!-- pagination start -->
            <div class="col-md-12">
             <center> {{ $offerpost->links() }} </center>
            </div> 
            <!-- pagination close -->
            
             <div class="col-md-12">
               <div class="footer_data">
                <p>
                  <strong>NOTE :</strong> 
                   Generous subs earn points for their Offers and our way of encouraging more of that generous behaviour is to reward them with 1 day of free Private Gallery Access (PGa) throughout the website. This is only done once a sub earns enough Private Gallery Points (PGP).
                 </p>
               </div>
             </div>
             
         </div>
       </div>
       <br/>
      
      @if(Auth::user()->gender == 'male')
       <?php  //echo "<pre>";print_r($myofferpost);die;  ?>
       <!-- my offer post start -->

       <div class="row">
          <h1 class="my_offer_post">My offer post</h1>
          @if(empty($myofferpost->all()))
            <p class="female_subpage_title">
              You currently have no closed or active Offers, Click Here (link to offers page) to Post an Offer today. The more interests you get, the faster you will achieve the PGa badge for your 24 hours access to ALL private galleries.
            </p>
          @elseif(Auth::user()->gender == 'female')
            <p class="female_subpage_title">
              Below are the Offers that you have shown interest in.
            </p>
          @endif
           <div class="col-md-12">
            @foreach($myofferpost as $myoffer)
            <div class="col-md-6 offer_container_grid">
              <div class="offer_cont_shadow">
                 <div class="offer_left">
                    <a href="{{url('users/'.Auth::user()->username)}}">
                    <img src="{{'img/users/'.Auth::user()->username.'/previews/'.Auth::user()->img}}" class="offer_pro_pic" />
                    </a>
                    <h3>
                      <a href="{{url('users/'.Auth::user()->username)}}"><span>{{Auth::user()->username}}</span>
                      </a>
                    </h3>
                 </div>
                  <div class="offer_right">
                    <h3><span>{{$myoffer->currency}}{{$offers->offer_rate}}</span></h3>
                  </div> 
                  <div class="offer_detailes_box">
                    <p>
                      {{$myoffer->offer_details}}
                    </p>
                  </div>
                  <br/>
                  <button type="button" disabled class="btn btn-default btn_interested">
                         <i class="fa fa-thumbs-up"></i> Interested
                  </button>
                  <span class="viewOffers cursor-pointer" onclick="myofferinterestedcount(<?php echo $myoffer->id; ?>)">
                      {{$myoffer->intrest_count}}
                  </span>
                    <span class="post_remaining" id="clockbottom{{$myoffer->id}}"></span>
                        <span class="post_remaining">
                        <?php 
                            $date_a = new DateTime(date("F j, Y, H:i:s"));
                            $date_b = new DateTime($myoffer->created_at);
                            $interval = date_diff($date_a,$date_b);
                            $stop_date = date('Y-m-d H:i:s', strtotime($myoffer->created_at . ' +1 day'));
                        
                            $interval_days = $interval->format('%a');
                            if ($interval_days > 0) 
                            {
                                echo '<font style="color:red;">Closed</font>';
                            }
                          else
                          {
                        ?>
                        <script type="text/javascript">
                        $('#clockbottom{{$myoffer->id}}').countdown("{{$stop_date}}", function(event) 
                        { 
                            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                            var totalMins = event.strftime('%M');
                            var totalSecs = event.strftime('%S');
                            if(totalHours < 12)
                            {
                              console.log('greet12');
                              $(this).css("color", "red").html();
                            }
                            if(totalHours==0 && totalMins==0 && totalSecs==0)
                              $(this).html('<font style="color:red;">Closed</font>');
                            else
                              $(this).html(event.strftime(totalHours + ' : %M : %S Remaining'));
                        });
                        </script>
                        <?php
                          }  
                        ?>
                        </span>
                  <br/><br/>
                  <span class="offer_id">Id: #{{$myoffer->id}}</span>
                  <div class="post_delete_date">
                    <a href="#">
                      <span >
                        <?php
                          echo date("H:i ",strtotime($myoffer->created_at));
                          echo date("d/m/Y", strtotime($myoffer->created_at) ); ?>
                      </span>
                    </a> &nbsp;
                    <a onclick = "delete_myoffer({{$myoffer->id}})">
                      <span><i class="fa fa-trash"></i></span>
                    </a>
                </div>
                </div>
            </div>
             <!--Delete Myoffer Confirmation Start-->
               <script>
              function delete_myoffer(id) {
               $('#delete_myoffer_popup').modal('show');
               $('#offer_id').val(id);
              }
              </script>
              <!--Delete Myoffer Confirmation Popup Start-->
              <div class="modal fade" id="delete_myoffer_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to delete this offer?
                    </div>
                    <input type="hidden" name="offer_id" id="offer_id">
                    <div class="modal-footer">
                      <button class="btn btn-primary" data-dismiss="modal" id="confirm_offer">Yes</button>
                      <button class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                  </div>
                </div>
              </div>
            <!--Delete Myoffer Confirmation Popup End-->
            <!--Delete Myoffer Confirmation PopupAjax Start-->
            <script>
              $("#confirm_offer").click(function() {
                var offer_id = $("#offer_id").val();
                  $.ajax({
                  type: 'GET',
                  url: 'deletemyoffer/'+offer_id,
                  success:function(data)
                  {
                    location.reload();
                  }
                });
              });
            </script>
            <!--Delete Myoffer Confirmation PopupAjax Close-->
            <!--Delete Myoffer Confirmation Close-->


            @endforeach

            <div class="col-md-12">
                <center> {{ $myofferpost->links() }} </center>
            </div>

            <!-- popup my offer post start -->
            <div class="modal fade" id="myofferpost" role="dialog">
              <div class="modal-dialog">
              <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">My offer post</h4>
                    </div>
                    <div class="modal-body" id="myoffer_interested_model_id">
                      
                    </div>
                    <div class="modal-footer">
                      <button type="button" id="refreshdata" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
            </div>
            <!-- popup my offer post close -->

          </div>
        </div>
       <!-- my offer post close -->
      @else
       <?php // echo "<pre>";print_r($myofferpostinterested->all());die; ?>
        <div class="row">
          <h1 class="my_offer_post">Logged interests</h1>
          @if(empty($myofferpostinterested->all()))
            <p class="female_subpage_title">
              Sorry, you currently have no logged interests.
            </p>
          @else
            <p class="female_subpage_title">
              Below are the Offers that you have shown interest in.
            </p>
          @endif
        <div class="col-md-12">
          <?php //echo "<pre>";print_r($myofferpostinterested);die; ?>
          @foreach($myofferpostinterested as $interested)
          <div class="col-md-6 offer_container_grid">
            <div class="offer_cont_shadow">
                <div class="offer_left">
                    @if($interested->img == '')
                      <img src="img/male.jpg" class="offer_pro_pic" />
                    @else
                      <img src="img/users/{{$interested->username}}/previews/{{$interested->img}}" class="offer_pro_pic" />
                    @endif
                    <h3><span>{{$interested->username}}</span></h3>
                </div>
                <div class="offer_right">
                  <h3><span>{{$interested->currency}}{{$interested->offer_rate}}</span></h3>
                </div> 
                <div class="offer_detailes_box">
                  <p>
                    {{$interested->offer_details}}
                  </p>
                </div>
                <br/>
                <button type="button" disabled class="btn btn-default btn_interested">
                       <i class="fa fa-thumbs-up"></i> Interested
                </button>
                  <span class="viewOffers cursor-pointer" onclick="my_logged_interested(<?php echo $interested->id; ?>)">
                      {{$interested->intrest_count}}
                  </span> 
                 <!--  <span data-toggle="modal" data-target="#logged_interested">
                      10
                  </span> -->

                <span class="post_remaining" id="clock_loged_interest{{$interested->id}}"></span>

                <span class="post_remaining">
                   <?php 
                          $date_a = new DateTime(date("F j, Y, H:i:s"));
                          $date_b = new DateTime($interested->created_at);
                          $interval = date_diff($date_a,$date_b);
                          $stop_date = date('Y-m-d H:i:s', strtotime($interested->created_at . ' +1 day'));
                        
                          $interval_days = $interval->format('%a');
                          if ($interval_days > 0) 
                          {
                            echo '<font style="color:red;">Closed</font>';
                          }
                          else
                          {
                        ?>
                          <script type="text/javascript">
                          $('#clock_loged_interest{{$interested->id}}').countdown("{{$stop_date}}", function(event) 
                          { 
                            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                            var totalMins = event.strftime('%M');
                            var totalSecs = event.strftime('%S');
                            if(totalHours < 12)
                            {
                              console.log('greet12');
                              $(this).css("color", "red").html();
                            }
                            if(totalHours==0 && totalMins==0 && totalSecs==0)
                              $(this).html('<font style="color:red;">Closed</font>');
                            else
                              $(this).html(event.strftime(totalHours + ' : %M : %S Remaining'));
                          });
                        </script>
                        <?php
                          }  
                        ?>
                </span>
                <br/><br/>
                <span class="offer_id" style="float:left;">Id: #{{$interested->id}}</span>
                <div class="post_delete_date">
                    <a href="#">
                      <span >
                        <?php
                          echo date("H:i ",strtotime($interested->created_at));
                          echo date("d/m/Y", strtotime($interested->created_at) ); ?>
                      </span>
                    </a> &nbsp; 
                    <a onclick = "delete_loggedoffer({{$interested->id}})">
                      <span><i class="fa fa-trash"></i></span>
                    </a>
                </div>
            </div>
          </div>
          <!--Delete Logged Offer Start-->
          <script>
            function delete_loggedoffer(id) {
            $('#delete_loggedoffer_popup').modal('show');
            $('#logged_interest_id').val(id);
              }
          </script>
              <!--Delete Myoffer Confirmation Popup Start-->
              <div class="modal fade" id="delete_loggedoffer_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to delete this interested offer?
                    </div>
                    <input type="hidden" name="logged_interest_id" id="logged_interest_id">
                    <div class="modal-footer">
                      <button class="btn btn-primary" data-dismiss="modal" id="confirm_offer">Yes</button>
                      <button class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                  </div>
                </div>
              </div>
            <!--Delete Myoffer Confirmation Popup End-->
            <!--Delete Myoffer Confirmation PopupAjax Start-->
            <script>
              $("#confirm_offer").click(function() {
                var logged_interest_id = $("#logged_interest_id").val();
                  $.ajax({
                  type: 'GET',
                  url: 'delete_logged_interest/'+logged_interest_id,
                  success:function(data)
                  {
                    location.reload();
                  }
                });
              });
            </script>
            <!--Delete Myoffer Confirmation PopupAjax Close-->
            <!--Delete Logged Offer Start-->

          @endforeach
        </div>
        <!-- popup my offer post start -->
            <div class="modal fade" id="logged_interested" role="dialog">
              <div class="modal-dialog">
              <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Logged interested</h4>
                    </div>
                    <div class="modal-body" id="my_logged_interested">
                      
                    </div>
                    <div class="modal-footer">
                      <button type="button" id="refreshdata" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
            </div>
            <!-- popup my offer post close -->
            <!-- pagination start -->
              <div class="col-md-12">
                <center> {{ $myofferpostinterested->links() }} </center>
              </div> 
            <!-- pagination close -->
        
          <div class="col-md-12">
               <div class="footer_data">
                <p style="text-align:center;">
                  <strong>NOTE :</strong> 
                   if there was an ad that you can no longer see, it may be because the ad creator has deleted the offer.
                 </p>
               </div>
             </div>
       </div>
      @endif
    <!-- <div class="wrap" ng-if="$parent.user.gender == 'female' && $parent.user.verify_check != 'VERIFIED'">
      <div>
       <center><h4>Verified users only:</h4> This page has some of the most generous subs within our site, therefore it is only accessible to genuine Femdoms who have been checked and verified by the Casualstar team. Click the button bellow and complete your verifiction today within minutes, its super quick and easy.
        <br>
        <br>
        <div class="add-gallery-photo ng-scope" style="background:transparent;">
          <a href="/verify"><button type="button">Apply for Verification now</button></a></center>
        </div>
      </div>
    </div>
  </div> -->
<button onclick="scrollToTop()" id="scrollToTopButton"><i class="ion-arrow-up-a"></i></button>

<script type="text/javascript">
  window.onscroll = function() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
      $('#scrollToTopButton').fadeIn();
    } else {
      $('#scrollToTopButton').fadeOut();
    }
  };

  function scrollToTop() {
    $('html,body').animate({scrollTop: 0}, 300);
  }

  document.getElementById('myField').addEventListener('input', event =>
    event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || '').toLocaleString('en-US')
  );
</script>

@endsection