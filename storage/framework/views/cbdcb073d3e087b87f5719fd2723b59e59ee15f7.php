<?php //echo "<pre>";print_r($notification_data);die; ?>


<?php $__env->startSection('style'); ?>
  <link href="<?php echo e(URL::asset('css/supersubs.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>
  <title>Super Subs » CasualStar</title> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php date_default_timezone_set("Asia/Kolkata"); ?>
 <?php if(Auth::user()->gender == 'male'): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.js"></script>   

 <!-- mal start -->
<div data-ng-controller="SuperSubsController">
    <div class="wrap">
      <div class="highlight">
       <center> Post Offer with a generous amount for any relevant desire you may have for a female to fulfil.interest you receive for your offers can eventually gain you access to ALL Private Galleries.</center>
       <hr/>
       <div class="row">
         <div class="col-md-12">
           <div class="col-md-2">
            <form method="post" action="<?php echo e(url('offerpost')); ?>" autocomplete="off">
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
               <?php echo e(csrf_field()); ?>

               <input type="hidden" name="hiddenname" id="hiddenid">
               <input type="text" id="myField"  maxlength="8"  pattern="^[\d,]+$"  class="form-control" required="required" name="offerrate" placeholder="1,054"/>
             </div>

           </div>
           <div class="col-md-5">
             <div class="form-group ">
               <input type="text" class="form-control" maxlength="100" minlength="10" required="required" name="offerdetails"  placeholder="I would like to help with your bills."/>
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
  <?php else: ?>
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
    <?php endif; ?>
    <div class="wrap">
       <div class="row">
         <div class="col-md-12">
           <?php // echo "<pre>"; print_r($offerpost);die;?> 
            <?php foreach($offerpost as $offers): ?>
             <div class="col-md-6 offer_container_grid">
              
                <?php if(in_array($offers->post_id, $user_posts)): ?>
                  <div class=" offer_content_shadow2  offer_cont_shadow">
                <?php else: ?>
                  <div class="offer_cont_shadow">
                <?php endif; ?> 

                    <div class="offer_left">
                      <a href="<?php echo e(url('users/'.$offers->username)); ?>">
                        <?php if($offers->img == ''): ?>
                        <img src="img/59ce3646d240c.png" class="offer_pro_pic" />
                        <?php else: ?>
                        <img src="img/<?php echo e($offers->img); ?>" class="offer_pro_pic" />
                        <?php endif; ?>
                      </a>
                      <h3>
                        <a href="<?php echo e(url('users/'.$offers->username)); ?>"><span><?php echo e($offers->username); ?></span>
                        </a>
                      </h3>
                    </div>
                     <div class="offer_right">
                        <h3><span><?php echo e($offers->currency); ?><?php echo e($offers->offer_rate); ?></span></h3>
                     </div> 
                     <div class="offer_detailes_box">
                       <p>
                           <?php echo e($offers->offer_details); ?>

                       </p>
                     </div>
                      <br/>
                     <?php if(Auth::user()->gender == 'male'): ?>
                       <button type="button" disabled class="btn btn-default btn_interested">
                         <i class="fa fa-thumbs-up"></i> Interested
                       </button>
                     <?php else: ?>

                      <?php if($offers->intrest_count < 10): ?>
                       <a href="<?php echo e(url('intrested/'.$offers->post_id)); ?>">
                       <button type="submit" class="btn btn-default btn_interested">
                         <i class="fa fa-thumbs-up"></i> Interested
                       </button>
                       </a>
                       <?php else: ?>
                       <a href="#">
                       <button type="submit" disabled class="btn btn-default btn_interested">
                         <i class="fa fa-thumbs-up"></i> Interested
                       </button>
                       </a>
                       <?php endif; ?>
                     <?php endif; ?>
                 
                     <!-- popup call -->
                      
                      <span class="viewOffers cursor-pointer" onclick="interestedcount(<?php echo $offers->post_id; ?>)"><?php echo e($offers->intrest_count); ?></span>
                    <!-- pop call close -->  
                   
                      
                      <?php if($offers->intrest_count < 10): ?>
                        <span class="post_remaining" id="clock<?php echo e($offers->post_id); ?>"></span>
                        <span class="post_remaining">
                        <?php 
                          $date_a = new DateTime(date("F j, Y, H:i:s"));
                          $date_b = new DateTime($offers->offer_post_date);
                          $interval = date_diff($date_a,$date_b);
                          $stop_date = date('Y-m-d H:i:s', strtotime($offers->offer_post_date . ' +1 day'));
                        
                          $interval_days = $interval->format('%a');
                          if ($interval_days > 0) 
                          {
                            echo '<font style="color:red;">Closed</font>';
                          }
                          else
                          {
                        ?>
                          <script type="text/javascript">
                          $('#clock<?php echo e($offers->post_id); ?>').countdown("<?php echo e($stop_date); ?>", function(event) 
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
                        
                      <?php else: ?>
                       <span class="post_remaining">Close</span>
                      <?php endif; ?> 
                      <br/><br/>
                      
                    

                     <span class="offer_id">Id: #<?php echo e($offers->post_id); ?></span>
                     <?php if(Auth::user()->gender == 'male' OR Auth::user()->username == 'Admin'): ?>
                      <a href="<?php echo e(url('delete/'.$offers->post_id )); ?>"><span class="fa fa-trash offer_delete"></span></a>
                     <?php endif; ?> 
                  </div> 
                  
               </div>

              <!-- popup  Modal start -->
              <div class="modal fade" id="popupmodal" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Intrested Users</h4>
                    </div>
                    <div class="modal-body" id="interested_model_id"></div>
                    <div class="modal-footer">
                      <button type="button" id="refreshdata" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  
                </div>
              </div>
              <!-- popup modal close--> 
              <?php endforeach; ?>
         
            
            <!-- pagination start -->
            <div class="col-md-12">
             <center> <?php echo e($offerpost->links()); ?> </center>
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
      
      <?php if(Auth::user()->gender == 'male'): ?>
       <?php //echo "<pre>";print_r($myofferpost);die;  ?>
       <!-- my offer post start -->

       <div class="row">
          <h1 class="my_offer_post">My offer post</h1>
          <?php if(empty($myofferpost)): ?>
            <p class="female_subpage_title">
              You currently have no closed or active Offers, Click Here (link to offers page) to Post an Offer today. The more interests you get, the faster you will achieve the PGa badge for your 24 hours access to ALL private galleries.
            </p>
          <?php else: ?>
            <p class="female_subpage_title">
              Below are the Offers that you have shown interest in.
            </p>
          <?php endif; ?>
           <div class="col-md-12">
            <?php foreach($myofferpost as $myoffer): ?>
            <div class="col-md-6 offer_container_grid">
              <div class="offer_cont_shadow">
                 <div class="offer_left">
                    <a href="<?php echo e(url('users/'.$offers->username)); ?>">
                    <?php if($offers->img == ''): ?>
                      <img src="img/59ce3646d240c.png" class="offer_pro_pic" />
                      <?php else: ?>
                      <img src="img/<?php echo e($offers->img); ?>" class="offer_pro_pic" />
                    <?php endif; ?>
                    </a>
                    <h3>
                      <a href="<?php echo e(url('users/'.$offers->username)); ?>"><span><?php echo e($offers->username); ?></span>
                      </a>
                    </h3>
                 </div>
                  <div class="offer_right">
                    <h3><span><?php echo e($myoffer->currency); ?><?php echo e($offers->offer_rate); ?></span></h3>
                  </div> 
                  <div class="offer_detailes_box">
                    <p>
                      <?php echo e($myoffer->offer_details); ?>

                    </p>
                  </div>
                  <br/>
                  <button type="button" disabled class="btn btn-default btn_interested">
                         <i class="fa fa-thumbs-up"></i> Interested
                  </button>
                  <span class="viewOffers cursor-pointer" onclick="myofferinterestedcount(<?php echo $myoffer->id; ?>)">
                      <?php echo e($myoffer->intrest_count); ?>

                  </span>
                    <span class="post_remaining" id="clockbottom<?php echo e($myoffer->id); ?>"></span>
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
                          $('#clockbottom<?php echo e($myoffer->id); ?>').countdown("<?php echo e($stop_date); ?>", function(event) 
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
                  <span class="offer_id">Id: #<?php echo e($myoffer->id); ?></span>
                  <div class="post_delete_date">
                    <a href="#">
                      <span >
                        <?php echo date("d/m/Y", strtotime($myoffer->created_at) ); ?>
                      </span>
                    </a> &nbsp; 
                    <a href="<?php echo e(url('deletemyoffer/'.$myoffer->id)); ?>">
                      <span><i class="fa fa-trash"></i></span>
                    </a>
                </div>
                </div>
            </div>

            

            

            <?php endforeach; ?>

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
      <?php else: ?>
        <div class="row">
          <h1 class="my_offer_post">Logged interests</h1>
          <p class="female_subpage_title">
            Below are the Offers that you have shown interest in.
          </p> 
        <div class="col-md-12">
          <div class="col-md-6 offer_container_grid">
             <div class="offer_cont_shadow">
                 <div class="offer_left">
                    <?php if($offers->img == ''): ?>
                      <img src="img/59ce3646d240c.png" class="offer_pro_pic" />
                    <?php else: ?>
                      <img src="img/<?php echo e($offers->img); ?>" class="offer_pro_pic" />
                    <?php endif; ?>
                    <h3><span>Admin</span></h3>
                 </div>
                  <div class="offer_right">
                    <h3><span>$2000</span></h3>
                  </div> 
                  <div class="offer_detailes_box">
                    <p>
                      this is offer detailes
                    </p>
                  </div>
                  <br/>
                  <button type="button" class="btn btn-default btn_interested">
                         <i class="fa fa-thumbs-up"></i> Interested
                  </button>
                  <span class="viewOffers cursor-pointer" data-toggle="modal" data-target="#myofferpost">
                      10
                  </span>
                  <span class="post_remaining">
                     00:00:00
                  </span>
                  <br/><br/>
                  <span class="offer_id" style="float:left;">Id: #12</span>
                  <div class="post_delete_date">
                    <a href="#">
                      <span >14/03/2019</span>
                    </a> &nbsp; 
                    <a href="#">
                      <span><i class="fa fa-trash"></i></span>
                    </a>
                </div>
                </div>
              </div>
          <div class="col-md-6 offer_container_grid">
             <div class="offer_cont_shadow">
                 <div class="offer_left">
                    <img src="img/59ce3646d240c.png" class="offer_pro_pic" />
                    <h3><span>Admin</span></h3>
                 </div>
                  <div class="offer_right">
                    <h3><span>$2000</span></h3>
                  </div> 
                  <div class="offer_detailes_box">
                    <p>
                      this is offer detailes
                    </p>
                  </div>
                  <br/>
                  <button type="button" class="btn btn-default btn_interested">
                         <i class="fa fa-thumbs-up"></i> Interested
                  </button>
                  <span class="viewOffers cursor-pointer" data-toggle="modal" data-target="#myofferpost">
                      10
                  </span>
                  <span class="post_remaining">
                     00:00:00
                  </span>
                  <br/><br/>
                  <span class="offer_id" style="float:left;">Id: #12</span>
                  <div class="post_delete_date">
                    <a href="#">
                      <span >14/03/2019</span>
                    </a> &nbsp; 
                    <a href="#">
                      <span><i class="fa fa-trash"></i></span>
                    </a>
                </div>
                </div>
              </div>
        </div>
        <!-- popup Logged interests start -->
            
        <!-- popup Logged interests close -->

        <!-- pagination start -->
          <center>
            <ul class="pagination">
              <li><a href="#">1</a></li>
              <li class="active"><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
            </ul>
          </center>
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
      <?php endif; ?>


    </div>
    <div class="block-flex wrap-flex" id="supersubs" infinite-scroll="paging()" infinite-scroll-disabled="isLoading" infinite-scroll-distance="1">
      <div class="sub" data-ng-repeat="supersub in supersubs">
        <div class="left">
          <a href="/users/[[supersub.username]]">
            <img ng-src="[[getUserPhotoPreviewUrl(supersub)]]" alt="[[supersub.username]]" />
          </a>
        </div>
        <div class="right">
          <h3>
            <div class="stat status" style="display:inline-block" ng-if="supersub.online">
              <span class="indicator active"></span>
            </div>
            <a href="/users/[[supersub.username]]">[[supersub.username]]</a>
          </h3>
       <!-- <p>Estimated tributes: <span>[[formatTributes(supersub)]]</span></p> -->
          <!-- <p ng-if="supersub.last_login != null && supersub.last_login != ''">Last login: <span>[[supersub.last_login.lastLogin]]</span></p> -->
          <h3><span>[[supersub.location]]</span></h3> 
          <p ng-if="supersub.description != null && supersub.description != ''"> <span>[[supersub.description]]</span></p>
        </div>
      </div>
    </div>

    <div class="wrap" ng-if="$parent.user.gender == 'female' && $parent.user.verify_check != 'VERIFIED'">
      <div>
       <center><h4>Verified users only:</h4> This page has some of the most generous subs within our site, therefore it is only accessible to genuine Femdoms who have been checked and verified by the Casualstar team. Click the button bellow and complete your verifiction today within minutes, its super quick and easy.
        <br>
        <br>
        <div class="add-gallery-photo ng-scope" style="background:transparent;">
          <a href="/verify"><button type="button">Apply for Verification now</button></a></center>
        </div>
      </div>
    </div>
  </div>



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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>