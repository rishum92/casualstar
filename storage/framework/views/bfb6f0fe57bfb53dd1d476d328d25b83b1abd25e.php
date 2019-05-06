<ul class="profil_ul">
<?php if($competitionuser->isEmpty()): ?>
  <div class = "no_competition_found">
    There is currently no active competition.
  </div><br><br>
<?php else: ?>
<?php $vote_rank = 0; $temp_vote = 0; ?>
<?php foreach($competitionuser as $user): ?>
   <?php //echo '<pre>';print_r($user);die;?>
    <li>
      <?php if(!Auth::user()): ?>
        <div class="wrap_profile" onclick = 'newwin()'>
            <?php if($temp_vote != $user->total_votes)
                {
                    $vote_rank++;
                    $temp_vote = $user->total_votes;
                }
            ?>  

              <?php if($vote_rank == 1){ ?>
                      <div class="first_place"><?php echo $vote_rank; ?><sup>st</sup></div>
                      <div class = "first_place_amount">
                        Wins:$<input type ="text" value ="<?php echo e($user->vote_prize->vote_amount); ?>" class="edit_amount" readonly = "true">
                      </div>
                        <?php }
                   else if($vote_rank == 2){ ?>
                      <div class = "second_place"><?php echo $vote_rank; ?><sup>nd</sup></div>
                      <div class="second_place_amount">
                        Wins:$<input type ="text" value ="50" class="edit_amount" readonly = "true">
                      </div>
                    <?php }
                    else if($vote_rank == 3){ ?>
                      <div class = "third_place"><?php echo $vote_rank; ?><sup>rd</sup></div>
                      <div class="third_place_amount">
                        Wins:$<input type ="text" value ="25" class="edit_amount" readonly = "true">
                      </div>
                    <?php }
                    else{ ?>
                        <div class = "fourth_place">
                          <?php echo "#".$vote_rank; ?>
                        </div> 
                <?php } ?>
          <div class="img-pro">
            <img src="<?php echo e(URL::asset('img/competition_user/'.$user->username.'/previews/'.$user->user_profile)); ?>"><br/>
          </div>
          <div class="profile_content">
            <h1>
              <a> <?php echo e($user->username); ?></a>
            </h1>
            <p>44 - High Wycombe, Bucking-hamshire</p>
            <div class="like_block" >
              <div id="increase_vote_<?php echo e($user->user_id); ?>"><i class="fa fa-heart"></i><?php echo e($user->total_votes); ?></div>
              <div id="increase_vote_ajax_<?php echo e($user->user_id); ?>" style="display:none;"><i class="fa fa-heart"></i></div>
            </div>
            <div class="wrap_btn">
              <button class="page_btn" type="button">
                <i class="fa fa-heart"></i> Vote Me
              </button>
              <button class="page_btn" type="button">
                <i class="fa fa-comments"></i> Comments
              </button>
            </div>
            <div class="comment_count">
              <?php echo e($user->total_comment); ?>

            </div>
            <div>
             <i onclick = "deleteconfirmation(<?php echo e($user->competition_id); ?>)" class = "fa fa-trash trash_btn"></i>
            </div>
          </div>
        </div>
      <?php else: ?>
      <div ng-controller = "UserCompetitionController">
        <div class="wrap_profile">
                <?php if($temp_vote != $user->total_votes)
                {
                    $vote_rank++;
                    $temp_vote = $user->total_votes;
                }
        ?>  

              <?php if($vote_rank == 1){ ?>
                      <div class="first_place"><?php echo $vote_rank; ?><sup>st</sup></div>
                      <?php if(Auth::user()->username == 'Admin'): ?>
                      <div class = "first_place_amount" id="first_place_amount">
                        <input type="hidden" name="hidden_user_id" id = "hidden_user_id" value = "<?php echo e($user->user_id); ?>">
                            Wins:$<input type ="text" value ="<?php echo e($user->vote_prize->vote_amount); ?>" onblur="firstplace_amount_fun(<?php echo e($user->user_id); ?>)" id = "firstplace_amount_<?php echo e($user->user_id); ?>"  class="edit_amount">
                      </div>
                      <!-- <div class = "first_place_amount" id="firstplace_amount_ajax_<?php echo e($user->user_id); ?>" style="display:none;">
                      </div> -->
                      <?php else: ?>
                      <div class = "first_place_amount">
                        Wins:$<input type ="text" value ="<?php echo e($user->vote_prize->vote_amount); ?>" class="edit_amount" readonly = "true">
                      </div>
                      <?php endif; ?>
                        <?php }
                   else if($vote_rank == 2){ ?>
                      <div class = "second_place"><?php echo $vote_rank; ?><sup>nd</sup></div>
                      <div class="second_place_amount">
                        Wins:$<input type ="text" value ="50" class="edit_amount" readonly = "true">
                      </div>
                    <?php }
                    else if($vote_rank == 3){ ?>
                      <div class = "third_place"><?php echo $vote_rank; ?><sup>rd</sup></div>
                      <div class="third_place_amount">
                        Wins:$<input type ="text" value ="25" class="edit_amount" readonly = "true">
                      </div>
                    <?php }
                    else{ ?>
                        <div class = "fourth_place">
                          <?php echo "#".$vote_rank; ?>
                        </div> 
                <?php } ?>
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
            <div class="like_block" >
              <div id="increase_vote_<?php echo e($user->user_id); ?>"><i class="fa fa-heart"></i><?php echo e($user->total_votes); ?></div>
              <div id="increase_vote_ajax_<?php echo e($user->user_id); ?>" style="display:none;"><i class="fa fa-heart"></i></div>
            </div>
            <div class="wrap_btn">
              <?php if($total_voters_count < 3 && !in_array ($user->user_id, $voter_count) && Auth::user()->id != $user->user_id || Auth::user()->username == 'Admin' && date('d/m/Y') != $showdate): ?>
                <button class="page_btn" type="button" onclick="confirm_vote_popup(<?php echo e($user->competition_id); ?>,<?php echo e($user->user_id); ?>,'<?php echo e($user->username); ?>')">
                  <i class="fa fa-heart"></i> Vote Me
                </button>
              <?php else: ?>
                <button class="page_btn" type="button" disabled>
                  <i class="fa fa-heart"></i> Vote Me
                </button>
              <?php endif; ?>
              
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