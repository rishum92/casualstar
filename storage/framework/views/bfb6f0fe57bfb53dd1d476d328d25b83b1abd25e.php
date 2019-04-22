<ul class="profil_ul">
<?php if(empty($competitionuser)): ?> 
  <div style = "font-size:30px;text-align:center;">
    There is currently no active competition.
  </div><br><br>

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
            <h1>
              <a> <?php echo e($user->username); ?></a>
            </h1>
            <p>44 - High Wycombe, Bucking-hamshire</p>
            <div class="like_block"><i class="fa fa-heart"></i> 
              <?php echo e($user->total_votes); ?>

            </div>
            <div class="wrap_btn">
              <button class="page_btn" type="button">
                <i class="fa fa-heart"></i> Vote Me
              </button>
              <button class="page_btn" type="button">
                <i class="fa fa-comments"></i> Comments
              </button>
            </div> 
          </div>
        </div>
      <?php else: ?>
      <div ng-controller = "UserCompetitionController">
        <div class="wrap_profile">
          <?php if($user->total_votes >= 100): ?>
          <div class="first_place">
            1<sup>st</sup>
          </div>
          <?php if(Auth::user()->username == 'Admin'): ?>
          <div class = "first_place_amount">
            <input type="hidden" name="hidden_user_id" id = "hidden_user_id" value = "<?php echo e($user->user_id); ?>">
            <input type ="text" value ="Wins:$100" id = "firstplace_amount"  class="edit_amount">
          </div>
          <?php else: ?>
          <div class = "first_place_amount">
            <input type ="text" value ="Wins:$100" class="edit_amount" readonly = "true">
          </div>
          <?php endif; ?>
          <?php elseif($user->total_votes >= 75): ?>
          <div class = "second_place">
            2<sup>nd</sup>
          </div>
          <div class="second_place_amount">
            <input type ="text" value ="Wins:$50" class="edit_amount" readonly = "true">
          </div>
          <?php elseif($user->total_votes >= 50): ?>
          <div class="third_place">
            3<sup>rd</sup>
          </div>
          <div class ="third_place_amount">
            <input type ="text" value ="Wins:$25" class="edit_amount" readonly = "true">
          </div>
          <?php elseif($user->total_votes >= 3): ?>
          <?php for($i =4; $i <= 10; $i++): ?>
               <!-- <div class = "fourth_place">
                  #<?php echo e($i); ?>

                </div> -->
          <?php endfor; ?>
          <?php endif; ?>
          <?php //echo '<pre>';print_r($user);//exit;?>
          <div class="img-pro">
            <img  onclick = 'imagemodal(<?php echo e($user->user_id); ?>)' src="<?php echo e(URL::asset('img/competition_user/'.$user->username.'/previews/'.$user->user_profile)); ?>">
            <br/>
          </div>
          <div class="profile_content">
            <h1>
              <a href = "<?php echo e((url('users/'.$user->username))); ?>">
                <?php echo e($user->username); ?>

              </a>
            </h1>
            <p>44 - High Wycombe, Bucking-hamshire</p>
            <div class="like_block">
              <i class="fa fa-heart"></i>
                <?php echo e($user->total_votes); ?>

            </div>
            <div class="wrap_btn">
            <?php //echo '<pre>';print_r($voter_count);?>
              <?php if($voter_count < 2 || !in_array ($user->user_id, $voter_count) && Auth::user()->id != $user->user_id || Auth::user()->username == 'Admin' && date('d/m/Y') != $showdate): ?>
                <button class="page_btn" type="button" onclick="confirm_vote_popup(<?php echo e($user->competition_id); ?>,<?php echo e($user->user_id); ?>)">
                  <i class="fa fa-heart"></i> Vote Me
                </button>
              <?php else: ?>
                <button class="page_btn" type="button" disabled>
                  <i class="fa fa-heart"></i> Vote Me
                </button>
              <?php endif; ?>
              <?php echo $__env->make('modals.commentcompetition', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <button onclick = "profilecomment(<?php echo e($user->user_id); ?>)"
                class="page_btn" type="button"><i class="fa fa-comments"></i>Comments
              </button>
            </div>
            <div class="comment_count">
              <?php echo e($user->total_comment); ?>

            </div>
            <?php if($user->user_id == Auth::user()->id || Auth::user()->username == 'Admin'): ?> 
              <div>
                <i onclick = "deleteconfirmation(<?php echo e($user->competition_id); ?>)" class = "fa fa-trash trash_btn"></i>
              </div>
            <?php endif; ?> 
          </div>
        </div>
      </div>
    <?php endif; ?>
  </li>
  <?php endforeach; ?>
  <?php endif; ?>
</ul>
<div>
  <?php echo e($competitionuser->links()); ?>

</div>