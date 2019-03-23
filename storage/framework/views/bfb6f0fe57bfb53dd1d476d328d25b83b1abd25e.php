<ul class="profil_ul">
  <?php //echo"<pre>"; print_r($competitionuser); //die; ?>
  <?php if(empty($competitionuser)): ?> 
  <div style = "font-style: 20px;">
      There is currently no active competitions.
  </div>
  <?php else: ?>
  <?php foreach($competitionuser as $user): ?>

  <?php //echo"<pre>"; print_r($user); //die; ?>
      <li>
          <?php if(!Auth::user()): ?>
              <div class="wrap_profile" onclick = 'newwin()'>
                <div class="img-pro">
                    <img src="<?php echo e(URL::asset('img/competition_user/'.$user->username.'/previews/'.$user->user_profile)); ?>"><br/>
                </div>
                <div class="profile_content">
                    <h1><a> <?php echo e($user->username); ?></a></h1>
              
                    <p>44 - High Wycombe, Bucking-hamshire</p>
                    <div class="like_block"><i class="fa fa-heart"></i> <?php echo e($user->total_votes); ?>

                    </div>
                    <div class="wrap_btn">
                        <button class="page_btn" type="button">
                            <i class="fa fa-heart"></i> Vote Me
                        </button>
                    <div>
                        <button class="page_btn" type="button"><i class="fa fa-comments"></i> Comments
                        </button>
                    </div> 
                  </div>
              </div>
          <?php else: ?>
            <div ng-controller = "UserCompetitionController"> 
              <div class="wrap_profile">
                 <?php if($user->total_votes > 100): ?>
                    <div class="first_place">
                     1<sup>st</sup>
                    </div>
                    <div class = "first_place_amount">
                      Wins:$100
                    </div>
                    <?php elseif($user->total_votes > 75): ?>
                    <div class = "second_place">
                      2<sup>nd</sup>
                    </div>
                    <div class="second_place_amount">
                      Wins:$50
                    </div>
                    <?php elseif($user->total_votes > 25): ?>
                    <div class="third_place">
                      3<sup>rd</sup>
                    </div>
                    <div class ="third_place_amount">
                      Wins:$25
                    </div>
                    <?php else: ?>
                    <div class = "fourth_place">
                      #<?php echo e($user->competition_id); ?>

                    </div>
                    <?php if(Auth::user()->username == 'Admin'): ?>
                    <div class ="fourth_place_amount">
                      <input type="hidden" name="hidden_user_id" id = "hidden_user_id" value = "<?php echo e($user->user_id); ?>">
                      <input type ="text" value ="Wins:$25" id = "amount_edit" class="edit_amount">
                    </div>
                    <?php else: ?>
                    <div class ="fourth_place_amount">
                      <input type ="text" value ="Wins:$25" class="edit_amount" readonly>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php //echo '<pre>';print_r($user);//exit;?>
                    <div class="img-pro">
                       <img  onclick = 'imagemodal(<?php echo e($user->user_id); ?>)' src="<?php echo e(URL::asset('img/competition_user/'.$user->username.'/previews/'.$user->user_profile)); ?>">
                        <br/>
                    </div>
                    <div class="profile_content">
                        <h1>
                          <a href = "<?php echo e((url('/'))); ?>">
                            <?php echo e($user->username); ?>

                          </a>
                        </h1>
                  
                        <p>44 - High Wycombe, Bucking-hamshire</p>
                        <div class="like_block">
                          <i class="fa fa-heart"></i>
                           <?php echo e($user->total_votes); ?>

                        </div>
                        <div class="wrap_btn">
                          <?php //echo count($voter_count);exit;?>
                          <?php if(count($voter_count) < 2 || !in_array ($user->user_id, $voter_count)): ?>
                            <button class="page_btn" type="button" onclick="confirm_vote_popup(<?php echo e($user->competition_id); ?>,<?php echo e($user->user_id); ?>)">
                                <i class="fa fa-heart"></i> Vote Me
                            </button>
                          <?php else: ?>
                            <button class="page_btn" type="button" disabled>
                                <i class="fa fa-heart"></i> Vote Me
                            </button>
                          <?php endif; ?>
                        
                          <?php echo $__env->make('modals.commentcompetition', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                          <button 
                          data-ng-click="viewThisPhoto(<?php echo e($user->user_id); ?>)"
                          class="page_btn" type="button"><i class="fa fa-comments"></i>Comments
                          </button>
                        </div>
                        <?php if($user->user_id == Auth::user()->id || Auth::user()->username == 'Admin'): ?> 
                      <div>
                        <i  onclick = "deleteconfirmation(<?php echo e($user->competition_id); ?>)" style="float:right; color:grey;" class = "fa fa-trash"></i>
                      </div>
                    <?php endif; ?> 
                    </div>
                    
                <?php endif; ?>
      </li>
  <?php endforeach; ?>
  <?php endif; ?>
</ul>
<div>
    <?php echo e($competitionuser->links()); ?>

</div>