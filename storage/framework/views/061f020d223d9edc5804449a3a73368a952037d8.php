<?php $__env->startSection('meta'); ?>
  <title>Explore | CasualStar</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="explore-gallery">
	<div class="wrap" ng-controller="ExploreController">
		<div class="banner-wrap" ng-if="bannerAd">
			<div class="components-wrap">
				<div class="slick-wrap" ng-if="bannerAd">
					<slick id="slick" settings="slickConfig" ng-if="bannerAd.type == 'images'">
						<div class="slide-wrap" ng-repeat="(key, image) in bannerAd.banner_ad_resources" >
							<img ng-src="/banner-ads-resources/images/[[image.resource]]">
						</div>
					</slick>
					<div class="iframe-wrap" ng-if="bannerAd.type == 'video'" >
						<iframe width="100%" height="100%" ng-src="[[bannerAd.banner_ad_resources[0].resource + '?autoplay=0&mute=0&enablejsapi=1&controls=0&loop=1&modestbranding=1' | trusted]]" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
				</div>
				<div class="banner-user-info" ng-if="bannerAd">
					<a href="users/[[bannerAd.user.username]]">
						<img ng-src="[[getUserPhotoPreviewUrl(bannerAd.user)]]">
						<span>[[bannerAd.user.username]]</span>
					</a>
				</div>
			</div>
		</div>
		<div class="add-gallery-photo no-bg">
			<a href="/banner-ads"><button type="button"><i class="fa fa-star"></i> Feature on the Banner</button></a>
		</div>
		<div class="block-flex wrap-flex" id="explorePhotos" infinite-scroll="paging()" infinite-scroll-disabled="isLoading" infinite-scroll-distance="1">
		  <div class="photo" data-ng-repeat="photo in photos"> 
	      <img ng-src="[[getPhotoPreviewUrl(photo)]]" alt="[[photo.title]]" data-ng-click="viewThisPhoto(photo)" />
		    <div class="controls">
	    		<?php if(Auth::check() && Auth::user()->title == 'ADMIN'): ?>
		      	<button type="button" class="edit-button" mwl-confirm="" title="<?php echo e(Lang::get('messages.removePhoto')); ?>" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="deletePhoto(photo)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="ion-trash-a"></i></button>
		      <?php endif; ?>
		    </div>
		  </div>
		</div>
	  <?php echo $__env->make('modals.viewPhoto', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>