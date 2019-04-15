 <?php $__env->startSection('meta'); ?>
<title><?php echo e($username); ?> » CasualStar</title>
<?php $__env->stopSection(); ?> <?php $__env->startSection('scripts'); ?> <?php $__env->stopSection(); ?> <?php $__env->startSection('content'); ?>

<div class="profile-container" data-ng-controller="UserController" data-ng-init="username='<?php echo e($username); ?>'">
<div class="loader" data-ng-if="loadingWinks" style="position: fixed;">
    <div class="spinner">
      <img src="../img/ring.gif" alt="loader" />
    </div>
</div>

<section class="profile-main" data-ng-if="userLoaded">
    <div class="pgp_icon">
        <?php //echo "<pre>";print_r($pgp_notification);die;?>
        <?php if(Auth::user()->gender == 'female'): ?>
        <?php if($gender == 'male'): ?>
        <?php if($pgp_notification >= 1000): ?>
            <span class="pgp_counter"><img src="<?php echo e(URL::to('/')); ?>/img/PGa.png" alt="Img" width="30px"></span>
        <?php else: ?>
            <span class="pgp_counter">PGP<br>
                <?php printf("%04d", $pgp_notification); ?>
            </span>
        <?php endif; ?>
        <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="profile-wrap">
        <div id="userPhotoProfile">
            <div class="image" lightgallery data-src="[[getUserPhotoUrl(user.img)]]">
                <a href="[[getUserPhotoUrl(user.img)]]" class="lightGallery" title="[[user.username]]">
                        <img ng-if="[[getPhotoPreviewUrl(user.img == '') && user.gender=='female']]" src="<?php echo e(URL::to('/')); ?>/img/female.jpg" alt="profile pic"/>

                        <img ng-if="[[getPhotoPreviewUrl(user.img == '') && user.gender=='male']]" src="<?php echo e(URL::to('/')); ?>/img/male.jpg" alt="profile pic"/>
                   <!--  <div ng-switch="user.gender">
                        <div ng-switch-when="female">
                            <img ng-if="[[getPhotoPreviewUrl(user.img == '')]]" src="<?php echo e(URL::to('/')); ?>/img/female.jpg" alt="profile pic"/>
                        </div>
                        <div ng-switch-when="male">
                            <img ng-if="[[getPhotoPreviewUrl(user.img == '')]]" src="<?php echo e(URL::to('/')); ?>/img/male.jpg" alt="profile pic"/>
                        </div>
                    </div> -->
                </a>
                <a href="[[getUserPhotoUrl(user.img)]]" class="lightGallery" title="[[user.username]]">
                    <img ng-if="[[getPhotoPreviewUrl(user.img != '')]]" data-ng-src="[[getPhotoPreviewUrl(user.img)]]" alt="profile pic"/>
                </a>
            </div><!--
				<?php if(Auth()->user()->title!="ADMIN"): ?>
				<div ng-if="[[user.verify_check]] == 'VERIFIED'" class="col-md-3 col-lg-3 col-sm-3 col-xs-3 col-md-offset-5">
				  <i class="fa fa-check edit-button" aria-hidden="true">Verified</i>
				</div>
				<?php endif; ?>-->
            </div>
			<div class="clearfix"></div>
            <h1>
            <span class="verify-icon">
              [[user.username]] 
            </span>
				<img ng-if="[[user.verify_check]] == 'VERIFIED'" class="img-valign" src="[[getVerifySymbolUrl()]]" alt="" />	
			</h1>
            <p>
                [[user.description]]
            </p>
        </div>
    </section>


    <div class="actions">
        <div class="block-flex wrap-flex vertical-center-flex row-center-flex">
            <button data-ng-if="!user.winked" data-ng-click="wink(user.username)" class="action wink"><i class="ion-eye"></i><?php echo e(Lang::get('messages.wink')); ?></button>
            <button data-ng-if="user.winked" onClick="notify('warning','You cannot send another wink until the user replies to your previous one.')" class="action wink active"><i class="ion-eye"></i><?php echo e(Lang::get('messages.wink')); ?></button> <?php if($subscribed == 1 || $subscribed == 0): ?>
            <a href="<?php echo e(URL::route('messages')); ?>/[[user.username]]" class="action message"><i class="ion-ios-paperplane"></i><?php echo e(Lang::get('messages.message')); ?></a> <?php else: ?>
            <button type="button" data-toggle="modal" data-target="#subscribeModal" class="action message"><i class="ion-ios-paperplane"></i><?php echo e(Lang::get('messages.message')); ?></button> <?php endif; ?>
            <button class="action favorite" data-ng-class="getFavorite(user)" data-ng-click="toggleFavorite(user.username)"><i class="ion-heart"></i><?php echo e(Lang::get('messages.favorite')); ?></button>
        </div>
    </div>

    <div class="stats">
        <div class="block-flex wrap-flex vertical-center-flex row-center-flex">
            <div class="stat age">
                <small class="user-age"><?php echo e(Lang::get('age')); ?></small>
                <span class="user-age">[[user.age]]</span>
            </div>
            <?php if($isOnline): ?>
            <div class="stat status">
                <span class="indicator active"></span>
                <small><?php echo e(Lang::get('messages.onlineNow')); ?></small>
            </div>
            <?php else: ?>
            <div class="stat status">
                <span class="indicator"></span> <?php if($lastLogin): ?>
                <small>Last seen: <?php echo e(date("d/m/Y", strtotime($lastLogin))); ?></small> <?php else: ?>
                <small>Last seen: </small> <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="stat location">
                <i class="ion-ios-location"></i>
                <span>[[user.location]]</span>
                <div id="grant-access" ng-if="buttonEnable" style="margin: 5px;"> <button  ng-click="grantedAccess(buttonEnable)" class="btn btn-lg btn-primary grant-access" >Grant access</button></div>
            </div>
        </div>
    </div>

    <div class="profile-gallery" data-ng-if="user.photos.length > 0">
        <h2><?php echo e(Lang::get('messages.morePhotos')); ?></h2>
        <div class="wrap">
            <div id="userPhotos" class="block-flex wrap-flex">
                <div lightgallery class="photo" data-src="[[getPhotoUrl(photo.img)]]" data-ng-repeat="photo in user.photos">
                    <a class="lightGallery" href="[[getPhotoUrl(photo.img)]]" title="[[photo.title]]">
                        <img data-ng-src="[[getPhotoPreviewUrl(photo.img)]]" alt="[[photo.title]]" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-gallery" data-ng-if="user.privatephotos.length > 0 && user.gender == 'female'">
        <h2><?php echo e(Lang::get('messages.privateGalary')); ?></h2>
        
        <div class="wrap">
          
     <div id="userPrivatePhotos" class="block-flex wrap-flex">
                <div lightgallery class="photo" data-src="[[getPhotoUrl(photo.img)]]" data-ng-repeat="photo in user.privatephotos">
                    <a class="lightGallery"  title="[[photo.title]]" ng-if="!accessGranted">
                        <img class="blur-img" data-ng-src="[[getPrivatePhotoPreviewUrl(photo.img)]]" alt="[[photo.title]]" />
                    </a>
                    <a class="lightGallery" href="[[getPhotoUrl(photo.img)]]" title="[[photo.title]]" ng-if="accessGranted">
                        <img  data-ng-src="[[getPrivatePhotoPreviewUrl(photo.img)]]" alt="[[photo.title]]" />
                    </a>
                </div>
                <div ng-if="!accessGranted && iwantaccess" class="floating-div">
             <span ng-if="accessPending" class="pending">Request is pending</span>
                 
            <button ng-if="!accessPending" class="btn btn-primary btn-flat btn-lg ng-scope" ng-click="sendRequest(iwantaccess)" style=" margin: 6px 0px 0px 6px;">I want access</button> </div>
            </div>
            
        </div>
    </div>

    <?php if((isset($user->cashme_url) && $user->cashme_url != '') || (isset($user->paypal_url) && $user->paypal_url != '') || (isset($user->cashme_url_uk) && $user->cashme_url_uk != '') || $user->alt_url == 1): ?>
    <div class="donate-btn-box">
        <div class="wrap">
            <button class="main-btn donate-btn" data-toggle="modal" data-ng-click="donate()" data-target="#donateModal">PAY ME</button>
        </div>
    </div>
    <?php endif; ?>

    <div class="tags" data-ng-if="user.interests.length > 0">
        <div class="wrap">
            <h2><?php echo e(Lang::get('messages.enjoys')); ?></h2>
            <div class="block-flex wrap-flex row-center-flex">
                <span class="tag" data-ng-repeat="interest in user.interests">[[interest.name]]</span>
            </div>
        </div>
    </div>
    <section class="rec-members service-list-section" ng-if="serviceList.length>0">
        <div class="wrap">
            <h3>All Available Services For You</h3>
            <div class="row">
                <div class="col-md-12">
				
                    <div class="col-md-3" ng-repeat="service in serviceList">
                        <div class="box box-success" ng-if="(service.service_name!='' && service.service_name != null) && (service.SID == 1)">
                            <div class="box-header with-border">
                                <h3 class="box-title">[[service.service_name]]</h3>

                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header  -->
							<!--<span ng-if="service.negotiate=='true'">Negotiate / [[service.variable_name]] </span>
							<span ng-if="service.negotiate!='true'"> [[service.amount]] [[currency_code]] / [[service.variable_name]]</span>-->
							<!--
							<div class="box-body" ng-if="service.sr_status == null">
								<span ng-if="service.negotiate=='true'">Negotiate / [[service.variable_name]] </span>

                            </div>
							
							<div class="box-body" ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='EXPIRED'">
								<span ng-if="service.negotiate=='true'">Negotiate / [[service.variable_name]] </span>
								<span ng-if="service.negotiate=='false'">[[service.amount]] [[currency_code]] / [[service.variable_name]] </span>
                            </div>
							
							<div class="box-body" ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='COMPLETED'">
								<span ng-if="service.negotiate=='true'">Negotiate / [[service.SRVNAME]] </span>
								<span ng-if="service.negotiate=='false'">[[service.amount]] [[currency_code]] / [[service.SRVNAME]] </span>
                            </div>
							
							<div class="box-body" ng-if="service.sr_status != null && service.sr_status=='PENDING'">
								<span ng-if="service.negotiate=='true'">Negotiate / [[service.SRVNAME]] </span>
								<span ng-if="service.negotiate=='false'">[[service.amount]] [[currency_code]] / [[service.SRVNAME]] </span>
                            </div>
							
							<div class="box-body" ng-if="service.sr_status != null && service.service_id != 10 && service.sr_status=='COMPLETED'">
								<span ng-if="service.negotiate=='true'">Negotiate / [[service.variable_name]] </span>
								<span ng-if="service.negotiate=='false'">[[service.amount]] [[currency_code]] / [[service.variable_name]] </span>
                            </div>
							<div class="box-footer" ng-if="service.sr_status == null">
								<button type="submit" class="btn-sm btn-success btn-flat" ng-click="sendRequest(service.id)">Send Request</button>
							</div>

							<div class="box-footer" ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='EXPIRED'">
								<button type="submit" class="btn-sm btn-success btn-flat" ng-click="sendRequest(service.id)">Send Request</button>
                            </div>
							
							<div class="box-footer" ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='COMPLETED'">
								<span>You have access</b></span>
                            </div>
							
							<div class="box-footer" ng-if="service.sr_status != null && service.sr_status=='PENDING'">
								<span>Request status:<b>[[service.sr_status]]</b></span>
							</div>
							
							<div class="box-footer" ng-if="service.sr_status != null && service.service_id != 10 && service.sr_status=='COMPLETED'">
								<button type="submit" class="btn-sm btn-success btn-flat" ng-click="sendRequest(service.id)">Send Request</button>
							</div> -->
							
							<div class="box-body">
								<span ng-if="service.negotiate=='true' && service.sr_status == null">Negotiate / [[service.variable_name]] </span>
								<span ng-if="service.negotiate=='false' && service.sr_status == null">[[service.amount]] [[currency_code]] / [[service.variable_name]] </span>
								<span ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='EXPIRED' && service.negotiate=='true'">Negotiate / [[service.variable_name]] </span>
								<span ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='EXPIRED' && service.negotiate=='false'">[[service.amount]] [[currency_code]] / [[service.variable_name]] </span>
								<span ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='COMPLETED' && service.negotiate=='true'">Negotiate / [[service.SRVNAME]] </span>
								<span ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='COMPLETED' && service.negotiate=='false'">[[service.amount]] [[currency_code]] / [[service.SRVNAME]] </span>
								<span ng-if="service.sr_status != null && service.sr_status=='PENDING' && service.negotiate=='true'">Negotiate / [[service.SRVNAME]] </span>
								<span ng-if="service.sr_status != null && service.sr_status=='PENDING' && service.negotiate=='false'">[[service.amount]] [[currency_code]] / [[service.SRVNAME]] </span>
								<span ng-if="service.sr_status != null && service.service_id != 10 && service.sr_status=='COMPLETED' && service.negotiate=='true'">Negotiate / [[service.variable_name]] </span>
								<span ng-if="service.sr_status != null && service.service_id != 10 && service.sr_status=='COMPLETED' && service.negotiate=='false'">[[service.amount]] [[currency_code]] / [[service.variable_name]] </span>
                            </div>
							
							<div class="box-footer" >
								<button type="submit" ng-if="service.sr_status == null" class="btn-sm btn-success btn-flat" ng-click="sendRequest(service.id)">Send Request</button>
								<button type="submit" ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='EXPIRED'" class="btn-sm btn-success btn-flat" ng-click="sendRequest(service.id)">Send Request</button>
								<span ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='COMPLETED'">You have access</b></span>
								<span ng-if="service.sr_status != null && service.sr_status=='PENDING'">Request status:<b>[[service.sr_status]]</b></span>
								<button type="submit" ng-if="service.sr_status != null && service.service_id != 10 && service.sr_status=='COMPLETED'" class="btn-sm btn-success btn-flat" ng-click="sendRequest(service.id)">Send Request</button>
							</div>
							<!--
							<div class="box-footer">
                                <button type="submit" ng-if="(service.status=='EXPIRED' && service.service_id==10) || ((service.status!='PENDING' || service.status=='COMPLETED') && service.id!=10) " class="btn-sm btn-success btn-flat" ng-click="sendRequest(service.id)">Send Request</button>
                                <span ng-if="service.status=='PENDING'">Request status:<b>[[service.status]]</b></span>
                                 <span ng-if="service.status=='COMPLETED' && service.service_id==10">You have access</b></span>
                            </div>-->
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
						<!--<div class="box box-success" ng-if="(service.service_name!='' && service.service_name != null) && (service.SID == 249)">-->
						<div class="box box-success" ng-if="(service.service_name!='' && service.service_name != null) && (service.SID == service.user_id)">
							<div class="box-header with-border">
                                <h3 class="box-title">[[service.service_name]]</h3>

                                <!-- /.box-tools -->
                            </div>
							<div class="box-body">
								<span ng-if="service.negotiate=='true' && service.sr_status == null">Negotiate / [[service.variable_name]] </span>
								<span ng-if="service.negotiate=='false' && service.sr_status == null">[[service.amount]] [[currency_code]] / [[service.variable_name]] </span>
								<span ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='EXPIRED' && service.negotiate=='true'">Negotiate / [[service.variable_name]] </span>
								<span ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='EXPIRED' && service.negotiate=='false'">[[service.amount]] [[currency_code]] / [[service.variable_name]] </span>
								<span ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='COMPLETED' && service.negotiate=='true'">Negotiate / [[service.SRVNAME]] </span>
								<span ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='COMPLETED' && service.negotiate=='false'">[[service.amount]] [[currency_code]] / [[service.SRVNAME]] </span>
								<span ng-if="service.sr_status != null && service.sr_status=='PENDING' && service.negotiate=='true'">Negotiate / [[service.SRVNAME]] </span>
								<span ng-if="service.sr_status != null && service.sr_status=='PENDING' && service.negotiate=='false'">[[service.amount]] [[currency_code]] / [[service.SRVNAME]] </span>
								<span ng-if="service.sr_status != null && service.service_id != 10 && service.sr_status=='COMPLETED' && service.negotiate=='true'">Negotiate / [[service.variable_name]] </span>
								<span ng-if="service.sr_status != null && service.service_id != 10 && service.sr_status=='COMPLETED' && service.negotiate=='false'">[[service.amount]] [[currency_code]] / [[service.variable_name]] </span>
                            </div>
							
							<div class="box-footer" >
								<button type="submit" ng-if="service.sr_status == null" class="btn-sm btn-success btn-flat" ng-click="sendRequest(service.id)">Send Request</button>
								<button type="submit" ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='EXPIRED'" class="btn-sm btn-success btn-flat" ng-click="sendRequest(service.id)">Send Request</button>
								<span ng-if="service.sr_status != null && service.service_id == 10 && service.sr_status=='COMPLETED'">You have access</b></span>
								<span ng-if="service.sr_status != null && service.sr_status=='PENDING'">Request status:<b>[[service.sr_status]]</b></span>
								<button type="submit" ng-if="service.sr_status != null && service.service_id != 10 && service.sr_status=='COMPLETED'" class="btn-sm btn-success btn-flat" ng-click="sendRequest(service.id)">Send Request</button>
							</div>
						</div>
						</div><!--col-md-3-->
                    <!-- serviceList-->
				</div> <!--col-md-12-->
            </div><!--row-->
        </div><!--wrap-->
    </section>
    <?php echo $__env->make('modals.payment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> <?php echo $__env->make('modals.donate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> <?php if(count($similarUsers) > 0): ?>
    <section class="rec-members">
        <div class="wrap">
            <h3>Other members you might like</h3>
            <div class="row">
                <?php foreach($similarUsers as $user): ?>
                <div class="col-md-3 col-xs-4">
                    <div class="member">
                        <div class="image">
                            <a href="/users/<?php echo e($user->username); ?>">
                  <?php if(is_null($user->img)): ?>
                    <img src="<?php echo e(URL::asset('img/' . $user->gender . '.jpg')); ?>" alt="<?php echo e($user->username); ?>">
                  <?php else: ?>
                    <img src="<?php echo e(URL::asset('img/users/' . $user->username . '/previews/' . $user->img)); ?>" alt="<?php echo e($user->username); ?>">
                  <?php endif; ?>
                </a>
                        </div>
                        <h4><?php echo e($user->username); ?></h4>
                        <?php if($user->distance > 0): ?>
                        <p><?php echo e($user->distance); ?> miles away</p>
                        <?php elseif($user->distance == 0): ?>
                        <p>near you</p>
                        <?php endif; ?>
                        <p><i class="ion-ios-location"></i> <?php echo e($user->location); ?></p>
                        <a href="/users/<?php echo e($user->username); ?>" class="profile-link">
                See profile <i class="ion-arrow-right-c"></i>
              </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?> <?php echo $__env->make('modals.altDonate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>