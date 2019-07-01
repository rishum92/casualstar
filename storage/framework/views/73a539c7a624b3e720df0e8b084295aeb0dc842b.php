<!DOCTYPE html>
<html lang="<?php echo e(App::getLocale()); ?>">

  <head>
  
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-117117961-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-117117961-1');
</script>

  
  <!-- **** -->
  <!-- Meta -->
  <!-- **** -->

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(URL::asset('img/icons/apple-icon-57x57.png')); ?>"> 
  <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(URL::asset('img/icons/apple-icon-60x60.png')); ?>">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(URL::asset('img/icons/apple-icon-72x72.png')); ?>">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(URL::asset('img/icons/apple-icon-76x76.png')); ?>">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(URL::asset('img/icons/apple-icon-114x114.png')); ?>">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(URL::asset('img/icons/apple-icon-120x120.png')); ?>">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(URL::asset('img/icons/apple-icon-144x144.png')); ?>">
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(URL::asset('img/icons/apple-icon-152x152.png')); ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(URL::asset('img/icons/apple-icon-180x180.png')); ?>">
  <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo e(URL::asset('img/icons/android-icon-192x192.png')); ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(URL::asset('img/icons/favicon-32x32.png')); ?>">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(URL::asset('img/icons/favicon-96x96.png')); ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(URL::asset('img/icons/favicon-16x16.png')); ?>">
  <link rel="manifest" href="<?php echo e(URL::asset('img/icons/manifest.json')); ?>">
  <meta name="msapplication-TileColor" content="#ffffff')}}">
  <meta name="msapplication-TileImage" content="<?php echo e(URL::asset('img/icons/ms-icon-144x144.png')); ?>">
  
  <!-- <meta name="theme-color" content="#ffffff')}}"> -->

  <?php echo $__env->yieldContent('meta'); ?>  

  <!-- *** -->
  <!-- CSS -->
  <!-- *** --> 
  <link href="<?php echo e(URL::asset('css/searchBar.css')); ?>" rel="stylesheet"> <!-- APInfo -->

  <!-- Animate CSS -->
  <link href="<?php echo e(URL::asset('components/animate.css/animate.min.css')); ?>" rel="stylesheet"> 

  <!-- Bootstrap CSS -->
  <link href="<?php echo e(URL::asset('components/bootstrap/dist/css/bootstrap.min.css')); ?>" rel="stylesheet">

  <!-- Cropper CSS -->
  <link href="<?php echo e(URL::asset('components/cropper/dist/cropper.min.css')); ?>" rel="stylesheet">

  <?php if(Auth::check()): ?>

    <!-- Angular Select2 CSS -->
    <link href="<?php echo e(URL::asset('components/angular-ui-select/dist/select.css')); ?>" rel="stylesheet">

    <!-- Angular Datepicker CSS -->
    <link href="<?php echo e(URL::asset('components/angular-datepicker/dist/angular-datepicker.min.css')); ?>" rel="stylesheet">

    <!-- Angular Bootstrap Calendar CSS -->
    <link href="<?php echo e(URL::asset('components/angular-bootstrap-calendar/dist/css/angular-bootstrap-calendar.min.css')); ?>" rel="stylesheet">

  <?php endif; ?>

  <!-- Bootstrap Datetimepicker CSS -->
  <link href="<?php echo e(URL::asset('components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet">

  <!-- Ionicons CSS -->
  <link href="<?php echo e(URL::asset('components/ionicons/css/ionicons.min.css')); ?>" rel="stylesheet ">

  <!-- FontAwesome CSS -->
  <link href="<?php echo e(URL::asset('components/fontawesome/css/font-awesome.min.css')); ?>" rel="stylesheet">

  <!-- Slick CSS -->
  <link href="<?php echo e(URL::asset('components/slick-carousel/slick/slick.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(URL::asset('components/slick-carousel/slick/slick-theme.css')); ?>" rel="stylesheet">

  <!-- Lightgallery CSS -->
  <link href="<?php echo e(URL::asset('components/lightgallery/dist/css/lightgallery.min.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(URL::asset('components/lightgallery/dist/css/lg-transitions.min.css')); ?>" rel="stylesheet">

  <!-- ********** -->
  <!-- Custom CSS -->
  <!-- ********** -->

  <!-- CasualStar CSS -->
  <link href="<?php echo e(URL::asset('css/style.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(URL::asset('css/competitions/competitions.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(URL::asset('css/competitions/simple-line-icons.css')); ?>" rel="stylesheet">
  <script src="<?php echo e(URL::asset('components/jquery/dist/jquery.min.js')); ?>" type="text/javascript"></script>
  <?php echo $__env->yieldContent('style'); ?>

  </head>
  <?php if(Auth::check()): ?>
    <body data-ng-app="CasualStar" data-ng-controller="LiveController" data-ng-init="nodeHost='<?php echo e(getenv('NODE_HOST')); ?>';subscribed=<?php echo e($subscribed); ?>" data-ng-cloak>
  <?php else: ?>
    <body data-ng-app="CasualStar" data-ng-cloak>
  <?php endif; ?>

  <?php if(!Auth::check()): ?>
    <header>
      <div class="wrap">
        <div class="block-flex wrap-flex vertical-center-flex">
          <div class="logo"><img src="<?php echo e(URL::asset('img/logo.png')); ?>" alt="logo"/>
          
 
          
          </div><!-- end of header div??-->
        <!-- social icon-->
     <div class="socialWrap"> 
<a href="https://www.twitter.com/casualstars" target="_blank">
<img src="/img/twitterIcon.png" alt="casualstarTwitter" style="width:28px;height:28px; margin-left:20px;"> <a/> </div>

     <div class="socialWrap"> 
<a href="https://www.instagram.com/casualstarr" target="_blank">
<img src="/img/insta.png" alt="casualstarInstagram" style="width:auto;height:28px; margin-left: 5px; "> <a/></div>

          
          <ul class="menu">
            <li><a class="<?php if(Route::is('index') || Route::is('index')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('index')); ?>">Home</a></li>
			<li><a href="<?php echo e(URL::route('competitions')); ?>">Competitions</a></li>
            <li><a href="<?php echo e(URL::route('about')); ?>">About us</a></li>
            <li><a href="<?php echo e(URL::route('faq')); ?>">FAQ Help</a></li>
            <li><a href="<?php echo e(URL::route('terms')); ?>">Terms &amp; Conditions</a></li>
            <li><a href="<?php echo e(URL::route('contact')); ?>">Contact</a></li> 
          </ul>
        </div>
      </div>
    </header>
  <?php endif; ?>
    <div class="menu-overlay"></div>

    <?php if(Auth::check()): ?>
      <div class="user-menu">
        <div class="wrap">
          <div class="block-flex wrap-flex vertical-center-flex">

            <div class="logo">
              <a href="<?php echo e(URL::route('dashboard')); ?>"> <img src="<?php echo e(URL::asset('img/logo.png')); ?>" alt="logo"/></a>
            </div>

            <div class="welcome block-flex vertical-center-flex">
              <?php if(Auth()->user()->username): ?>
                <span><?php echo e(Lang::get('messages.hello')); ?>, <?php echo e(Auth::user()->username); ?>!</span>
              <?php else: ?>
                <span><?php echo e(Lang::get('messages.hello')); ?>, stranger!</span> 
              <?php endif; ?>
            </div>
            <ul class="block-flex wrap-flex vertical-center-flex"> 
              <li><a class="<?php if(Route::is('dashboard') || Route::is('dashboard')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('dashboard')); ?>"><i class="ion-home" ></i>Dashboard</a></li>
               <?php if(Auth()->user()->gender=="female"): ?>
              <li><a class="<?php if(Route::is('services') || Route::is('services')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('services')); ?>"><i class="ion-ios-rose" ></i>Services </a>
				<span ng-if="pending_count">
                    <span class="small-notif" ng-if="pending_count<100" >[[pending_count]]</span>
              
                    <span class="small-notif larger" ng-if="pending_count>99">99+</span>
                </span>
              </li>
                 <?php endif; ?>
				 <?php if(Auth()->user()->gender=="male"): ?>
                <li>
                  <a class="<?php if(Route::is('competitions') || Route::is('competitions')): ?> active <?php endif; ?>" href="<?php echo e(URL ::route('competitions')); ?>"><i class="ion-home"></i> Competitions </a>
                </li>
                <?php endif; ?>
              <li>
                <a class="<?php if(Route::is('activity') || Route::is('activity')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('activity')); ?>"><i class="ion-flash"></i>Activity</a>
                <?php if($activityCount > 0): ?>
                  <?php if($activityCount < 100): ?>
                    <span class="small-notif"><?php echo e($activityCount); ?></span>
                  <?php else: ?>
                    <span class="small-notif larger">99+</span>
                  <?php endif; ?>
                <?php endif; ?>

                <?php if($pgp_notification >= 1000): ?>
                  <span class="small-notif">1</span>
                <?php endif; ?>
                
              </li>
              <li>
                <a class="<?php if(Route::is('messages') || Route::is('messages')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('messages')); ?>"><i class="ion-chatbubbles"></i>Messages</a>
                <span data-ng-if="messageCount > 0 && messageCount < 100" class="small-notif">[[messageCount]]</span>
                <span data-ng-if="messageCount > 0 && messageCount > 99" class="small-notif larger">99+</span>
              </li>
              <li><a class="<?php if(Route::is('explore') || Route::is('explore')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('explore')); ?>"><i class="ion-earth"></i>Explore</a></li>
              <!-- <li><a class="<?php if(Route::is('supersubs') || Route::is('supersubs')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('supersubs')); ?>"><i class="ion-star"></i>Supersubs</a></li> -->
              
              <!-- <li><a class="<?php if(Route::is('offers') || Route::is('offers')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('offers')); ?>"><i class="ion-star"></i>Offer</a>
                  <?php if($offercount > 0): ?>
                    <?php if($offercount < 100): ?>
                    <span class="small-notif"><?php echo e($offercount); ?></span>
                   <?php else: ?>
                    <span class="small-notif larger">99+</span>
                  <?php endif; ?>
                 <?php endif; ?> 
                  </li>  -->

                  <li><a class="<?php if(Route::is('offers') || Route::is('offers')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('offers')); ?>"><i class="ion-star"></i>Offer</a>
                  
                      <?php foreach($notification_data as $user_notifications): ?>
                       <?php if($user_notifications->notification == '0'): ?>
                       <?php else: ?>
                        <span class="small-notif larger"><?php echo e($user_notifications->notification); ?></span>
                        <?php endif; ?>
                      <?php endforeach; ?>
                  </li> 
                  <!-- <li>
                    <a href="#">0000</a>
                  </li> -->

             </ul>
            <?php if($donationCount > 0): ?>
              <a href="<?php echo e(URL::route('donations')); ?>" class="donate-icon active">
                  <?php if($donationCount < 100): ?>
                    <span class="small-notif"><?php echo e($donationCount); ?></span>
                  <?php else: ?>
                    <span class="small-notif larger">99+</span>
                  <?php endif; ?>
              </a>
            <?php else: ?>
              <a href="<?php echo e(URL::route('donations')); ?>" class="donate-icon active">
              </a>
            <?php endif; ?>
            <!--<div class="<?php echo e((Auth::user()->verify_check !== 'VERIFIED') ? 'image' : 'image image_ver'); ?>">-->
            
           <!--Start of div--> <div class="<?php echo e((Auth::user()->gender == 'male') ? 'image' : 'image image_ver_twit'); ?>">
            <!--<div class="image">-->
                <?php if(Auth::user()->img): ?>
                  <img id="userPhoto_uploade" src="<?php echo e(URL::asset('img/users/' . Auth::user()->username . '/previews/' . Auth::user()->img )); ?>" alt="profile photo" />
                <?php else: ?>
                  <img id="userPhoto_uploade" src="<?php echo e(URL::asset('img/' . Auth::user()->gender . '.jpg')); ?>" alt="profile photo" />
                <?php endif; ?>



              <div class="logout">
                <a href="<?php echo e(URL::route('profile')); ?>"><i class="ion-person-stalker"></i>My profile</a>
                <hr>
                <?php if(Auth::user()->gender == 'female'): ?>
        				<a href="<?php echo e(URL::route('twit.account')); ?>"><i class="ion-social-twitter"></i>Auto-tweets</a>
                 <hr>
                <?php endif; ?>
               
                <a href="<?php echo e(URL::route('supersubs')); ?>"><i class="ion-key"></i>Supersub</a>
                <hr>
                  <a href="<?php echo e(URL::route('competitions')); ?>"><i class="ion-home"></i>Competitions</a>
                <hr>
                <a href="<?php echo e(URL::route('account.details')); ?>"><i class="ion-key"></i>Account details</a>
                <hr>
                <a href="<?php echo e(URL::route('donations')); ?>"><i class="ion-cash"></i>Tributes</a>
                <hr>
                <a href="<?php echo e(URL::route('settings')); ?>"><i class="ion-wrench"></i>Settings</a>
                <hr>
				<!--<?php if(Auth::user()->id != 1): ?>
                <a href="<?php echo e(URL::route('verify')); ?>"><i class="ion-android-exit"></i>Account verification</a>
                <hr>
                <?php endif; ?> -->
                <a href="<?php echo e(URL::route('verify')); ?>"><i class="ion-android-checkbox-outline"></i>Account verification</a>
                <hr>
                <a href="<?php echo e(URL::route('logout')); ?>"><i class="ion-android-exit"></i>Logout</a>
              </div>
            </div> <!--end of drop menu div container-->
            <?php if(Auth::user()->gender == 'male'): ?>
              <?php if($pgp_notification >= 1000): ?>
                <span class="pgp_counter"><img src="<?php echo e(URL::to('/')); ?>/img/PGa.png" alt="Img" width="30px"></span>
              <?php else: ?>
                <span class="pgp_counter">PGP</br>
                  <?php printf("%04d", $pgp_notification); ?>
                </span>
              <?php endif; ?>
            <?php endif; ?>
            
          </div>

        </div>
       </div>
      <button class="menu-toggle">
        <i class="ion-android-menu">
          <span class="small-notif" data-ng-if="notificationCount +pending_count > 0 && notificationCount +pending_count < 100">[[notificationCount+ pending_count]]</span>
          <span class="small-notif larger" data-ng-if="notificationCount +pending_count > 0 && notificationCount+pending_count > 99">99+</span>
        </i>
      </button>
      <div class="sidebar">
        <ul class="mobile-user-menu">
          <li><a class="<?php if(Route::is('dashboard') || Route::is('dashboard')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('dashboard')); ?>"><i class="ion-home"></i>Dashboard</a></li>
            <?php if(Auth()->user()->gender=="female"): ?>
              <li><a class="<?php if(Route::is('services') || Route::is('services')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('services')); ?>"><i class="ion-ios-rose" >
                    <span class="small-notif" ng-if="pending_count<100&&pending_count>0" >[[pending_count]]</span>
              
                    <span class="small-notif larger" ng-if="pending_count>99">99+</span>
                 </i>Services</a></li>
                 <?php endif; ?>
          <li>
            <a class="<?php if(Route::is('activity') || Route::is('activity')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('activity')); ?>">
              <i class="ion-flash">           
              <?php if($activityCount > 0): ?>
                <?php if($activityCount < 100): ?>
                  <span data-ng-init="activityCount=<?php echo e($activityCount); ?>" class="small-notif"><?php echo e($activityCount); ?></span>
                <?php else: ?>
                  <span data-ng-init="activityCount=<?php echo e($activityCount); ?>" class="small-notif larger">99+</span>
                <?php endif; ?>
              <?php endif; ?>
              </i>
              Activity
            </a>
          </li>
          <li>
            <a class="<?php if(Route::is('messages') || Route::is('messages')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('messages')); ?>">
              <i class="ion-chatbubbles">
                <span data-ng-if="messageCount > 0 && messageCount < 100" data-ng-if="" class="small-notif">[[messageCount]]</span>
                <span data-ng-if="messageCount > 0 && messageCount > 99" class="small-notif larger">99+</span>
              </i>
              Messages
            </a>
          </li>
          <li><a class="<?php if(Route::is('explore') || Route::is('explore')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('explore')); ?>"><i class="ion-earth"></i>Explore</a></li>
          <li><a class="<?php if(Route::is('supersubs') || Route::is('supersubs')): ?> active <?php endif; ?>" href="<?php echo e(URL::route('supersubs')); ?>"><i class="ion-star"></i>Supersubs</a></li>
        </ul>

      </div>
    <?php endif; ?>
    <?php echo $__env->yieldContent('content'); ?>

    <footer>
      <ul class="footer-menu">
        <li><a href="<?php echo e(URL::route('index')); ?>">Home</a></li>
		<li><a href="<?php echo e(URL::route('competitions')); ?>">Competitions</a></li>
        <li><a href="<?php echo e(URL::route('about')); ?>">About us</a></li>
        <li><a href="<?php echo e(URL::route('faq')); ?>">FAQ Help</a></li>
        <li><a href="<?php echo e(URL::route('terms')); ?>">Terms &amp; Conditions</a></li>
        <li><a href="<?php echo e(URL::route('privacy')); ?>">Privacy policy</a></li>
        <li><a href="<?php echo e(URL::route('safety')); ?>">Safety tips</a></li>
        <li><a href="<?php echo e(URL::route('contact')); ?>">Contact</a></li>
        <?php if(Auth::user() && Auth::user()->title == 'ADMIN'): ?>
          <li>
            &nbsp;
          </li>
          <li>
            <a href="<?php echo e(URL::route('admin')); ?>"><i class="ion-gear-b"></i> Admin</a>
          </li>
		  <li>
              <a href="<?php echo e(URL::route('admin2')); ?>"><i class="ion-checkmark"></i> Verifications</a>
          </li>
          <li>
&nbsp;
            <a href="<?php echo e(URL::route('admin.banner.ads')); ?>">
              <?php if($bannerAdRequestCount > 0): ?>
                <?php if($bannerAdRequestCount > 99): ?>
                    <?php $bannerAdRequestCount = "99+" ?>
                    <?php $over99 = 'true'; ?>
                <?php else: ?>
                    <?php $over99 = 'false'; ?>
                <?php endif; ?>
                <span class="banner-ad-notification" data-count="<?=$bannerAdRequestCount ?>" data-over99="<?=$over99?>"><?php echo e($bannerAdRequestCount); ?></span>
              <?php endif; ?>
              <i class="ion-star"></i> Banner ads</a>
          </li>
        <?php endif; ?>
      </ul>
      <hr>
    </footer>
      
    <!-- ** -->
    <!-- JS -->
    <!-- ** -->

    <!-- jQuery JS -->
    <script src="<?php echo e(URL::asset('components/jquery/dist/jquery.min.js')); ?>" type="text/javascript"></script>

    <!-- Cropper JS -->
    <script src="<?php echo e(URL::asset('components/cropper/dist/cropper.min.js')); ?>" type="text/javascript"></script>

    <!-- Angular JS -->
    <script src="<?php echo e(URL::asset('components/angular/angular.min.js')); ?>" type="text/javascript"></script>

    <script src="<?php echo e(URL::asset('components/moment/min/moment.min.js')); ?>"></script>

    <?php if(Auth::check()): ?>

      <!-- Angular Bootstrap Confirm JS -->
      <script src="<?php echo e(URL::asset('components/angular-bootstrap-confirm/dist/angular-bootstrap-confirm.min.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('components/angular-bootstrap-confirm/src/ui-bootstrap-position.js')); ?>" type="text/javascript"></script>

      <!-- Angular Credit Cards JS -->
      <script src="<?php echo e(URL::asset('components/angular-credit-cards/release/angular-credit-cards.js')); ?>" type="text/javascript"></script>

      <!-- Angular File Upload -->
      <script src="<?php echo e(URL::asset('components/ng-file-upload/ng-file-upload.min.js')); ?>" type="text/javascript"></script>

      <!-- Angular Route JS -->
      <script src="<?php echo e(URL::asset('components/angular-route/angular-route.min.js')); ?>" type="text/javascript"></script>

      <!-- Angular Sanitize JS -->
      <script src="<?php echo e(URL::asset('components/angular-sanitize/angular-sanitize.min.js')); ?>" type="text/javascript"></script>

      <!-- Angular Paging JS -->
      <script src="<?php echo e(URL::asset('components/angular-paging/dist/paging.min.js')); ?>" type="text/javascript"></script>

      <!-- Angular Xeditable JS -->
      <script src="<?php echo e(URL::asset('components/angular-xeditable/dist/js/xeditable.js')); ?>"></script>

      <!-- Angular Sortable JS -->
      <script src="<?php echo e(URL::asset('components/Sortable/Sortable.js')); ?>"></script>
      <script src="<?php echo e(URL::asset('components/Sortable/ng-sortable.js')); ?>"></script>

      <!-- Angular Ui-Select JS -->
      <script src="<?php echo e(URL::asset('components/angular-ui-select/dist/select.js')); ?>" type="text/javascript"></script>

      <!-- Angular Datepicker JS -->
      <script src="<?php echo e(URL::asset('components/angular-datepicker/dist/angular-datepicker.min.js')); ?>"></script>

      <!-- Angular Scroll Glue JS -->
      <script src="<?php echo e(URL::asset('components/angular-scroll-glue/src/scrollglue.js')); ?>" type="text/javascript"></script>

      <!-- Angular Slick Carousel JS -->
      <script src="<?php echo e(URL::asset('components/angular-slick-carousel/dist/angular-slick.min.js')); ?>" type="text/javascript"></script>

      <!-- Angular Infinite Scroll JS -->
      <script src="<?php echo e(URL::asset('components/ngInfiniteScroll/build/ng-infinite-scroll.min.js')); ?>" type="text/javascript"></script>

      <!-- Angular Bootstrap Calendar JS -->
      <script src="<?php echo e(URL::asset('components/angular-bootstrap-calendar/dist/js/angular-bootstrap-calendar-tpls.min.js')); ?>" type="text/javascript"></script>
      
      <!-- Geocomplete JS -->
      <script src="<?php echo e(URL::asset('components/geocomplete/jquery.geocomplete.min.js')); ?>"></script>

    <?php endif; ?>

    <!-- Bootstrap Datetimepicker JS + Moment dependency -->
    <script src="<?php echo e(URL::asset('components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')); ?>"></script>

    <!-- Bootstrap JS -->
    <script src="<?php echo e(URL::asset('components/bootstrap/dist/js/bootstrap.min.js')); ?>" type="text/javascript"></script>

    <!-- Bootstrap Validator JS -->
    <script src="<?php echo e(URL::asset('components/bootstrap-validator/js/validator.js')); ?>" type="text/javascript"></script>

    <!-- Google Maps API JS -->
    <script src="https://maps.google.com/maps/api/js?libraries=places&key=<?php echo e(getenv('GOOGLE_MAPS')); ?>" type="text/javascript"></script>

    <!-- Geocomplete JS -->
    <script src="<?php echo e(URL::asset('components/geocomplete/jquery.geocomplete.min.js')); ?>"></script>
    
    <!-- Notify JS -->
    <script src="<?php echo e(URL::asset('components/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js')); ?>" type="text/javascript"></script>

    <!-- Slick JS -->
    <script src="<?php echo e(URL::asset('components/slick-carousel/slick/slick.min.js')); ?>" type="text/javascript"></script>

    <!-- Swipebox JS -->
    <script src="<?php echo e(URL::asset('components/swipebox/src/js/jquery.swipebox.min.js')); ?>" type="text/javascript"></script>

    <script src="<?php echo e(URL::asset('components/lightgallery/dist/js/lightgallery.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(URL::asset('components/lightgallery/dist/js/lg-thumbnail.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(URL::asset('components/lightgallery/dist/js/lg-zoom.min.js')); ?>" type="text/javascript"></script>

    <!-- ********* -->
    <!-- Custom JS -->
    <!-- ********* -->

    <script src="<?php echo e(URL::asset('js/scripts.js')); ?>" type="text/javascript"></script>

    <?php if(Auth::check()): ?>
      <!-- CasualStar Angular controllers -->
      <script src="<?php echo e(URL::asset('js/controllers/ActivityController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/AdminBannerAdsController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/BannerAdsController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/ServicesController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/UserController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/ChatController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/DashboardController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/ExploreController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/SuperSubsController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/LiveController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/PaymentController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/ProfileController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/SettingsController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/SubscriptionController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/RegisterController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/AdminController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/CompitionController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/CompitionuserController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/PostController.js')); ?>" type="text/javascript"></script>
	    <script src="<?php echo e(URL::asset('js/controllers/CompetitionuserController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/CommentController.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/SearchUserController.js')); ?>" type="text/javascript"></script>

      <!-- CasualStar Angular app -->
      <script src="<?php echo e(URL::asset('js/app.js')); ?>" type="text/javascript"></script>
	  <script src="<?php echo e(URL::asset('js/bootbox.js')); ?>" type="text/javascript"></script>
      <!-- Socket.IO JS -->
      <script type="text/javascript" src="<?php echo e(URL::asset('js/socket.io.js')); ?>"></script>
    <?php else: ?>
      <!-- CasualStar Angular Non-Auth app -->
      <script src="<?php echo e(URL::asset('js/app_nonauth.js')); ?>" type="text/javascript"></script>
      <script src="<?php echo e(URL::asset('js/controllers/RegisterController.js')); ?>" type="text/javascript"></script>
    <?php endif; ?>
<!--  -->

<script>
//intrested users list
function interestedcount(post_id){
  $.ajax({
    url: 'offerpost/'+post_id,
    type: 'GET',
    success: function(data){
      $('#popupmodal').modal('toggle');
      $('#interested_model_id').html(data);
     },
  });
}

$("popupmodal").blur(function(){
  alert("This input field has lost its focus.");
});

function myofferinterestedcount(post_id){
  $.ajax({
    url: 'myofferpost/'+post_id,
    type: 'GET',
    success: function(data){
      $('#myofferpost').modal('toggle');
      $('#myoffer_interested_model_id').html(data);
    },
  });
}

function my_logged_interested(post_id){
  $.ajax({
    url: 'logged_interested/'+post_id,
    type: 'GET',
    success: function(data){
      $('#logged_interested').modal('toggle');
      $('#my_logged_interested').html(data);
    },
  });
}

$("popupmodal").blur(function(){
  alert("This input field has lost its focus.");
});


function send_offer_message(post_id, receiver_id){
  offer_message = $('textarea#offer_message_'+receiver_id).val();
  $.ajax({
    url: 'send_offer_message',
    type: 'POST',
    data: {
        "_token": "<?php echo e(csrf_token()); ?>",
        "post_id": post_id,
        "receiver_id": receiver_id,
        "offer_message": offer_message
        },

    success: function(data){ 
      //$('#myofferpost').modal('toggle');
      //$('#myoffer_interested_model_id').html(data);
    },
  });
}

  //interested user close    
 
 //modal script
 $(function(){
      $(".closeModal").click(function(){
          $(this).closest(".modal").modal("hide")
      });
    });
 //modal script close

 </script>          

    <?php echo $__env->yieldContent('scripts'); ?>
     
    <?php if(Session::has('message')): ?>
      <script type="text/javascript">
        notify("<?php echo e(Session::get('messageType')); ?>", "<?php echo e(Session::get('message')); ?>");
      </script>
    <?php endif; ?>

    <!-- ************* -->
    <!-- External APIs -->
    <!-- ************* -->
    
  </body>
</html>
