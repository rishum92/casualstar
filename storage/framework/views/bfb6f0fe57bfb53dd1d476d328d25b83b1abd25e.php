<ul ng-controller="UserCompetitionController">
  <li ng-repeat="users in competition_user">
    [[users]].
    [[users[0].username]]"+"
    [[users[0].user_id]]"+"
    [[users[0].competition_id]]"+"
    [[users[0].user_profile]]"+"
    [[users[0].total_votes]]
  </li>
 </ul>  
<ul class="profil_ul">
  <li ng-repeat= "competitions in data">
      [[$index]]
      <?php if(!Auth::user()): ?>
        <div class="wrap_profile" onclick = 'newwin()' >
          <div class="img-pro">
            <img src="<?php echo e(URL::asset('img/competition_user/'.$user->username.'/previews/'.$user->user_profile)); ?>"><br/>
          </div>
          <div class="profile_content">
            <h1><a> [[competitions[0].username]]</a>
            </h1>
            <p>44 - High Wycombe, Bucking-hamshire</p>
              <div class="like_block"><i class="fa fa-heart"></i> 
                [[competitions[0].total_votes]]
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
            <div ng-if ="([[competitions[0].total_votes]] >= 100)">
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
              <div ng-if ="([[competitions[0].total_votes]] >= 75)">
                <div class = "second_place">
                  2<sup>nd</sup>
                </div>
                <div class="second_place_amount">
                  <input type ="text" value ="Wins:$50" class="edit_amount" readonly>
                </div>
              </div>
             <div ng-if ="([[competitions[0].total_votes]] >= 50)">
                <div class="third_place">
                  3<sup>rd</sup>
                </div>
                <div class ="third_place_amount">
                  <input type ="text" value ="Wins:$25" class="edit_amount" readonly>
                </div>
              </div>
              <div class="img-pro">
                <img onclick = 'imagemodal()' data-ng-src="[[getUserPhotoPreviewUrl(competitions)]]">
                <br/>
              </div>
                <div class="profile_content">
                  <h1>
                    <a href="/users/[[competitions[0].username]]">
                      [[competitions[0].username]]
                    </a>
                  </h1>
                  <p>44 - High Wycombe, Bucking-hamshire
                  </p>
                  <div class="like_block">
                    <i class="fa fa-heart"></i>
                      [[competitions[0].total_votes]]
                  </div>
                  <div class="wrap_btn">
                   
                    <button class="page_btn" type="button" onclick="confirm_vote_popup([[competitions[0].competition_id]],[[competitions[0].user_id]])">
                        <i class="fa fa-heart"></i> Vote Me
                      </button>
                   
                      <button class="page_btn" type="button" disabled>
                        <i class="fa fa-heart"></i> Vote Me
                      </button>
                   
                    <?php echo $__env->make('modals.commentcompetition', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                      <button data-ng-click="viewThisPhoto([[competitions.user_id]])"
                      class="page_btn" type="button"><i class="fa fa-comments"></i>Comments
                      </button>
                  </div>
                  <div ng-if = "[[competitions[0].user_id]] == Auth::user()->id || Auth::user()->username == 'Admin')">
                    <div>
                      <input type="hidden" name="hidden_username" id = "hidden_username" value = "[[competitions[0].username]]"> 
                      <i onclick = "deleteconfirmation([[competitions[0].competition_id]])" class = "fa fa-trash onclicktext"></i>
                    </div>
                  
                  </div>
              </div>
            <?php endif; ?>
    </li>
</ul>
