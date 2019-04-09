<ul class = "profil_ul" ng-controller="UserCompetitionController">
  <span ng-repeat="users in competition_user">
    <li ng-repeat="comp in users">
      <?php if(Auth::user()): ?>
       <div class="wrap_profile">
          <div class="img-pro" lightgallery data-src="[[getPhotoUrl(comp.user_profile)]]">
            <a href="[[getPhotoUrl(comp.user_profile)]]" class="lightGallery">
              <img ng-if="[[getPhotoPreviewUrl(comp.user_profile != '')]]" data-ng-src="[[getPhotoPreviewUrl(comp.user_profile)]]"/>
            </a>
          </div>
          <div class="profile_content">
            <h1>
              <a href="/users/[[comp.username]]">
                [[comp.username]]
              </a>
            </h1>
            <p>   
              44 - High Wycombe, Bucking-hamshire
            </p>
            <div class="like_block">
              <i class="fa fa-heart"></i> 
                [[comp.total_votes]]
            </div>
            <div class="wrap_btn">
              <?php echo $__env->make('modals.vote_popup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <input type="hidden" name="competition_userid" id="competition_userid" value="[[comp.user_id]]">
              <input type="hidden" name="modalcompetitionid" id="modalcompetitionid" value="[[comp.competition_id]]">
              <button class="page_btn" type="button" data-ng-click="openModal('vote_popup')">
                <i class="fa fa-heart"></i> Vote Me
              </button>
              <?php echo $__env->make('modals.commentcompetition', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <button ng-controller = "UserCompetitionController" ng-click="viewThisPhoto([[comp.user_id]])"
              class="page_btn" type="button"><i class="fa fa-comments"></i>Comments
              </button>
            </div>
            <?php if(Auth::user()->username == 'Admin'): ?> 
            <div style="margin-top: 232px; margin-right: -13px;">
              <i ng-click = "deleteconfirmation([[comp.competition_id]])" style="float:right; color:#d61857;" class = "fa fa-trash"></i>
            <?php endif; ?>
            </div> 
          </div>
        </div>
      <?php else: ?>
        <div class="wrap_profile" onclick = 'newwin()'>
          <div class="img-pro">
            <img data-ng-src="[[getPhotoUrl(comp.user_profile)]]"><br/>
          </div>
          <div class="profile_content">
            <h1>
              <a>[[comp.username]]</a>
            </h1>
            <p>44 - High Wycombe, Bucking-hamshire</p>
            <div class="like_block"><i class="fa fa-heart"></i> 
              [[comp.total_votes]]
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
      <?php endif; ?>
    </li>
  </span>
</ul>
<div>
<?php echo e($competitionuser->links()); ?>

</div>
