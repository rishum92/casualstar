<ul class="profil_ul">
  <?php if(empty($competitonsetitionuser)): ?> 
  <div style = "font-size: 30px;text-align:center;">
      There is currently no active competition.
  </div><br><br>
  <?php else: ?>
  <?php //echo"<pre>"; print_r($user); //die; ?>
    <li ng-repeat="competitons in competitonsetition_users">
      [[competitons]]
      <?php if(!Auth::user()): ?>
        <div class="wrap_profile" onclick = 'newwin()' >
          <div class="img-pro">
            <img src="<?php echo e(URL::asset('img/competitonsetition_user/'.$user->username.'/previews/'.$user->user_profile)); ?>"><br/>
          </div>
          <div class="profile_content">
            <h1><a> [[competitons.username]]</a>
            </h1>
            <p>44 - High Wycombe, Bucking-hamshire</p>
              <div class="like_block"><i class="fa fa-heart"></i> 
                [[competitons.total_votes]]
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
        <div> 
          <div class="wrap_profile">
            <div ng-if ="([[competitons.total_votes]] >= 100)">
              <div class="first_place">
                1<sup>st</sup>
              </div>
              <?php if(Auth::user()->username == 'Admin'): ?>
                <div class = "first_place_amount">
                  <input type="hidden" name="hidden_user_id" id = "hidden_user_id" value = "<?php echo e($user->user_id); ?>">
                  <input type ="text" value ="Wins:$100" id = "firstplace_amount"  class="edit_amount">
                </div>
            </div>
              <?php else: ?>
                <div class = "first_place_amount">
                  <input type ="text" value ="Wins:$100" class="edit_amount" readonly>
              <?php endif; ?>
              <div ng-if ="([[competitons.total_votes]] >= 75)">
                <div class = "second_place">
                  2<sup>nd</sup>
                </div>
                <div class="second_place_amount">
                  <input type ="text" value ="Wins:$50" class="edit_amount" readonly>
                </div>
              </div>
             <div ng-if ="([[competitons.total_votes]] >= 50)">
                <div class="third_place">
                  3<sup>rd</sup>
                </div>
                <div class ="third_place_amount">
                  <input type ="text" value ="Wins:$25" class="edit_amount" readonly>
                </div>
              </div>
              <div class="img-pro">
                <img onclick = 'imagemodal([[competitons.user_id]])' src="<?php echo e(URL::asset('img/competitonsetition_user/'.[[competitons.username]].'/previews/'.[[competitons.user_profile]])); ?>">
                <br/>
              </div>
                <div class="profile_content">
                  <h1>
                    <a href="/users/[[competitons.username]]">
                      [[competitons.username]]
                    </a>
                  </h1>
                  <p>44 - High Wycombe, Bucking-hamshire
                  </p>
                  <div class="like_block">
                    <i class="fa fa-heart"></i>
                      [[competitons.total_votes]]
                  </div>
                  <div class="wrap_btn">
                   
                    <button class="page_btn" type="button" onclick="confirm_vote_popup([[competitons.competitonsetition_id]],[[competitons.user_id]])">
                        <i class="fa fa-heart"></i> Vote Me
                      </button>
                   
                      <button class="page_btn" type="button" disabled>
                        <i class="fa fa-heart"></i> Vote Me
                      </button>
                   
                    <?php echo $__env->make('modals.commentcompetitonsetition', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                      <button data-ng-click="viewThisPhoto(<?php echo e($user->user_id); ?>)"
                      class="page_btn" type="button"><i class="fa fa-comments"></i>Comments
                      </button>
                  </div>
                  <div ng-if = "[[competitons.user_id]] == Auth::user()->id || Auth::user()->username == 'Admin')">
                    <div>
                      <input type="hidden" name="hidden_username" id = "hidden_username" value = "<?php echo e($user->username); ?>"> 
                      <i onclick = "deleteconfirmation(<?php echo e($user->competitonsetition_id); ?>)" class = "fa fa-trash onclicktext"></i>
                    </div>
                  
                  </div>
              </div>
            <?php endif; ?>
    </li>

  <?php endif; ?>
</ul>
