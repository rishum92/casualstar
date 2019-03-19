<?php $__env->startSection('style'); ?>
  <link href="<?php echo e(URL::asset('css/supersubs.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>
  <title>Super Subs » CasualStar</title> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

  <div data-ng-controller="SuperSubsController">
    <div class="wrap">
      <div class="highlight">
       <center> This list ranks hundreds of our most active and generous subs within Casualstar. If you are a Femdom, this ranking will help you to quickly identify the more genuine subs and paypigs.</center>
      </div>
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
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>