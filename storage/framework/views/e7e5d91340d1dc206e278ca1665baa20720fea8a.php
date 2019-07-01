<?php $__env->startSection('meta'); ?>
  <title>Dashboard » CasualStar</title> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

  <div data-ng-controller="DashboardController">
    <section class="browse" data-ng-init="filtersSet=<?php echo e($filters); ?>">
    <!--<section class="browse">-->
	<div class="wrap">
	<div class="bar">
		<input data-ng-model="userText" name="userText" data-ng-change="filterUsers()" ng-model-options="{updateOn: 'default change',debounce: {'default': 0,'change': 0}}" placeholder="Search by username" type="text" class="form-control search"  />
		<!--<span class="input-group-btn">
				<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search"></span>
				</button>
		</span>-->
	</div>
	</div>
      <div class="wrap"> 
        <h1><?php echo e(Lang::get('messages.browseMembers')); ?></h1>
        <button class="options-toggle">More Search Options <i class="ion-arrow-down-b"></i></button>
        <div class="options-container">
          <div class="options">  
            <form>
              <div class="block-flex wrap-flex vertical-center-flex option-row">
           <!--      <div class="form-group check-group">
                  <input name="gender_filter1" data-ng-change="filterUsers()" data-ng-model="genderMale" id="gender_filter1" type="checkbox">
                  <label for="gender_filter1" ><span><?php echo e(Lang::get('messages.male')); ?></span></label><br>
                </div>
                <div class="form-group check-group">
                  <input name="gender_filter2" data-ng-change="filterUsers()" data-ng-model="genderFemale" id="gender_filter2" type="checkbox">
                  <label for="gender_filter2" ><span><?php echo e(Lang::get('messages.female')); ?></span></label> 
                </div> --> 
                <div class="form-group images-only"> 
                  <input data-ng-change="filterUsers()" data-ng-model="withImagesOnly" name="withImagesOnly" id="image_filter" type="checkbox" value="1">
                  <label for="image_filter"><span></span><?php echo e(Lang::get('messages.withImagesOnly')); ?></label>
                </div> 
                <div class="form-group check-group online-now">
                  <input data-ng-change="filterUsers()" data-ng-model="onlineNow" name="online_filter" id="online_filter" type="checkbox">
                  <label for="online_filter"><span></span><?php echo e(Lang::get('messages.onlineNow')); ?></label>
                </div>
                <div class="form-group age-group range-group first-age-group block-flex wrap-flex vertical-center-flex">
                  <label><?php echo e(Lang::get('messages.minAge')); ?></label>
                  <input data-ng-model="minAge" name="minAge" onkeypress="return event.charCode >= 48 && event.charCode <= 57" data-ng-blur="filterUsers()" data-ng-change="filterUsers()" min="18" maxlength="3" max="100" type="text" class="form-control">
                </div>
                <div class="form-group age-group range-group block-flex wrap-flex vertical-center-flex">
                  <label><?php echo e(Lang::get('messages.maxAge')); ?></label>
                  <input data-ng-model="maxAge" name="maxAge" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="3" min="18" max="100" data-ng-blur="filterUsers()" data-ng-change="filterUsers()" type="text" class="form-control">
                </div>
              </div>
              <div class="block-flex wrap-flex vertical-center-flex range-row_custom"> 
                <div class="form-group _custom_one range-group block-flex wrap-flex vertical-center-flex" >
                  <label><?php echo e(Lang::get('messages.lookingFor')); ?></label>
                  <ui-select multiple ng-model="results.selected" theme="bootstrap">
                    <ui-select-match name="search" placeholder="<?php echo e(Lang::get('messages.selectInterests')); ?>">
                      <button type="button">[[$item.name]]</button>
                    </ui-select-match>
                    <ui-select-choices repeat="result in results" refresh="searchInterests($select.search)" refresh-delay="500">
                      <div class="result">
                        <button type="button" ng-bind-html="result.name | highlight: $select.search">[[$select.selected.name]]</button>
                      </div>
                    </ui-select-choices>
                  </ui-select>
                </div>
                <div class="form-group _custom_two range-group range-group block-flex wrap-flex vertical-center-flex" ng-show="getToggle()">
                  <label><?php echo e(Lang::get('messages.distance')); ?></label>
                  <input type="range" min="1" max="1000" data-ng-model="distance" data-ng-change="filterUsers()" data-ng-model-options='{ debounce: 300 }'>
                </div>
                <div class="form-group _custom_three range-group range-group block-flex wrap-flex vertical-center-flex" ng-show="getToggle()">
                  <input type="text" data-ng-model="distance" id="distance" readonly="readonly" class="form-control"><span>miles</span>
                </div>
			    <div class="form-group _custom_four images-only ">
                  <input data-ng-change="filterUsers()" data-ng-model="withAllGender" name="withAllGender" id="gen_filter" type="checkbox" value="1" ng-checked="getCheckedTrue()" >
                  <label for="gen_filter"><span></span>WorldWide</label>
                </div>

              </div>
            </form>
          </div>
          <div class="block-flex wrap-flex vertical-center-flex options-bottom">
            <div class="form-group order-group">
              <label class="title">ORDER BY </label>
              <input name="sortBy" data-ng-change="filterUsers()" data-ng-model="sortBy" id="sortByNewest" type="radio" value="created_at">
              <label for="sortByNewest"><span></span>New users</label>
              <input name="sortBy" data-ng-change="filterUsers()" data-ng-model="sortBy" id="sortByDistance" type="radio" value="distance">
              <label for="sortByDistance"><span></span>Closest</label>
            </div>
            <button class="options-toggle bottom">OK <i class="ion-checkmark"></i></button>
          </div>
        </div>
        
        <div class="browse-members">
          <div class="loader" data-ng-hide="!applyingFilters">
            <div class="spinner">
              <img src="img/ring.gif" alt="loader" /> 
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h3 class="explanation" data-ng-if="totalBrowse == 0"><?php echo e(Lang::get('messages.noMatchingUsers')); ?></h3>
            </div>
            
            <div class="col-lg-3 col-md-3 col-xs-4" data-ng-repeat="user in users">
              <div data-ng-if="totalBrowse > 0" class="member">
                <div class="image">
                  <div data-ng-hide="!user.online" class="online-indicator"></div>
                  <a href="/users/[[user.username]]">
                    <img data-ng-src="[[getUserPhotoPreviewUrl(user)]]" alt="[[user.username]]" />
                  </a>
                </div><!--
				<?php if(Auth()->user()->title!=="ADMIN"): ?>
				<div class="col-md-3 col-lg-3 col-sm-3 col-xs-3 col-md-offset-5" ng-if="user.verify_check == 'VERIFIED'">
				  <i class="fa fa-check edit-button" aria-hidden="true">Verified</i>
				</div>
				<?php endif; ?>-->
				
				<div class="clearfix"></div>
                <h4><span>[[user.username]]</span><!--<img ng-if="[[user.verify_check]] == 'VERIFIED'" class="img-valign" src="[[getVerifySymbolUrl()]]" alt="" />--></h4>
                <p>[[user.age]] <?php echo e(Lang::get('messages.yearsOld')); ?></p>
                <p data-ng-if="user.distance > 0">[[user.distance]] miles away</p>
                <p data-ng-if="user.distance == 0">near you</p>
                <p><i class="ion-ios-location"></i> [[getLocation(user.location)]]</p>
                <a href="/users/[[user.username]]" class="profile-link"><?php echo e(Lang::get('messages.seeProfile')); ?> <i class="ion-arrow-right-c"></i></a>
              </div>
            </div>
          </div>
          
          <nav>
            <paging
            class="small pagination"
            page="pageBrowse" 
            page-size="perPageBrowse" 
            total="totalBrowse"
            paging-action="changePageBrowse(page, pageSize, total)">
            </paging>
          </nav>
          
        </div>
      </div>
    </section>
    
    <section class="rec-members fav-members">
      <div class="wrap">
        <h3 data-ng-if="favorites.length > 0"><?php echo e(Lang::get('messages.yourFavoriteUsers')); ?></h3>
        <div data-ng-if="favorites.length > 0" class="row">
          <div class="col-lg-3 col-md-3 col-xs-4"  data-ng-repeat="user in favorites">
            <div class="member">
              <div class="image">
                <div data-ng-hide="!user.online" class="online-indicator"></div>
                <a href="/users/[[user.username]]">
                  <img data-ng-src="[[getUserPhotoPreviewUrl(user)]]" alt="[[user.username]]" />
                </a>
              </div>
              <h4>[[user.username]]</h4> 
                <p>[[user.age]] <?php echo e(Lang::get('messages.yearsOld')); ?></p>
                <p data-ng-if="user.distance > 0">[[user.distance]] miles away</p>
                <p data-ng-if="user.distance == 0">near you</p>
                <p><i class="ion-ios-location"></i> [[getLocation(user.location)]]</p>
              <!-- <p>[[user.description]]</p> -->
              <a href="/users/[[user.username]]" class="profile-link"><?php echo e(Lang::get('messages.seeProfile')); ?> <i class="ion-arrow-right-c"></i></a>
              <button type="button" class="edit-button" mwl-confirm="" title="<?php echo e(Lang::get('messages.removeFavorite')); ?>" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="destroyFavorite(user)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="ion-trash-a"></i></button>
            </div>
          </div>
        </div>
        <h3 data-ng-if="favorites.length == 0"><?php echo e(Lang::get('messages.noFavoriteUsers')); ?></h3>
        <p class="explanation" data-ng-if="favorites.length == 0">Browse profiles and use the "Favourite" button on their page to save them to, your "Favourites" list.</p>
        <nav>
          <paging
            class="small pagination"
            page="pageFavorites" 
            page-size="perPageFavorites" 
            total="totalFavorites"
            paging-action="changePageFavorites(page, pageSize, total)">
            </paging>
        </nav>
        
      </div>
    </section>
    
    <!--Female Notice--->
    <div class="wrap" data-ng-if="user.gender == 'female'">
      <div class="highlight">
<h2><b>NOTICE BOARD:</b></h2> 
<hr>
ALWAYS receive and confirm PAYMENT FIRST, BEFORE completing any requests for content or Services.<br/><hr/>
        
         To activate your Pay Me button, click <a href="/account-details"><b>HERE</b></a>
</br><hr/>
         Be sure to select and add your interests located on your profile page, this will increase your visibility with users sharing and searching the same interests.
</br><hr/>
<h2>Frequent Cash Prize competitions coming soon #MoreMoneyFor2019</h2>
</br><hr/>
<h3>TOP TIPS:</h3>It is good to update your photos on a regular basis. This will notify any users who have added you to their favourites list.
<br><br>
Ensure your email address is correct so you do not miss out on any possible Tributes.
</br> 
      </div>
    </div>
    
    <!--Male Notice--->
    
     <div class="wrap" data-ng-if="user.gender == 'male'">
      <div class="highlight">
<h2><b>NOTICE BOARD:</b></h2> 
<hr>
<h3>TOP TIPS:</h3>Receive the most attention by adding a profile photo and being a generous and active Sub, This will also help you to become our Number One SuperSub.
<br><br>
Add a profile picture to gain even more attention.
<p>
</br><hr>
         Be sure to select and add your interests located on your profile page, this will increase your visibility with users sharing and searching the same interests.
         </br>
</p>
<br/>
      </div>
    </div>
    
  </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>