<?php $__env->startSection('meta'); ?>
  <title>Profile » CasualStar</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

  <script type="text/javascript">
    var modal = $('#addCoverPhotoModal');

    modal.on('hidden.bs.modal', function () { 
      cleanModalData($(this));
    });

    modal.find('input[type="file"]').change(function() {
      var formGroup = $(this).parent();
      var modalPreview = formGroup.find('img');
      var oFReader = new FileReader();
      
      if(this.files[0]) {
        $(modalPreview).cropper('destroy'); 
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) { 
          modalPreview.parent().fadeIn();
          modalPreview.attr('src', oFREvent.target.result);
          formGroup.find('.photo-controls').fadeIn();
          
          modalPreview.cropper({
            aspectRatio: 16 / 9, 
            viewMode: 1,
            dragMode: 'none',
            crop: function(data) {
              setCropData(this, data);
            }
          });
        }
      } else {
        modalPreview.find('img').cropper('destroy');
        modalPreview.attr('src','');
        modalPreview.parent().fadeOut();
        formGroup.find('.photo-controls').fadeOut();
      }
    });
  </script>

  <script type="text/javascript">
    var modal = $('#addProfilePhotoModal');

    modal.on('hidden.bs.modal', function () {
      cleanModalData($(this));
    });

    modal.find('input[type="file"]').change(function() {
      var formGroup = $(this).parent();
      var modalPreview = formGroup.find('img');
      var oFReader = new FileReader();
      
      if(this.files[0]) {
        $(modalPreview).cropper('destroy');
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
          modalPreview.parent().fadeIn();
          modalPreview.attr('src', oFREvent.target.result);
          formGroup.find('.photo-controls').fadeIn();
          
          modalPreview.cropper({
            aspectRatio: 1 / 1,
            dragMode: 'none',
            viewMode: 1,
            crop: function(data) {
              setCropData(this, data);
            }
          });
        }
      } else {
        modalPreview.find('img').cropper('destroy');
        modalPreview.attr('src','');
        modalPreview.parent().fadeOut();
        formGroup.find('.photo-controls').fadeOut();
      }
    });
  </script>
<script type="text/javascript">
    var modal = $('#addPhotoModal');

    modal.on('hidden.bs.modal', function () {
      cleanModalData($(this));
    });

    modal.find('input[type="file"]').change(function() {
      var formGroup = $(this).parent();
      var modalPreview = formGroup.find('img');
      var oFReader = new FileReader();
      
      if(this.files[0]) {
        $(modalPreview).cropper('destroy');
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
          modalPreview.parent().fadeIn();
          modalPreview.attr('src', oFREvent.target.result);
          formGroup.find('.photo-controls').fadeIn();
          
          modalPreview.cropper({
            aspectRatio: 1 / 1,
            dragMode: 'none',
            viewMode: 1,
            crop: function(data) {
              setCropData(this, data);
            }
          });
        }
      } else {
        modalPreview.find('img').cropper('destroy');
        modalPreview.attr('src','');
        modalPreview.parent().fadeOut();
        formGroup.find('.photo-controls').fadeOut();
      }
    });
  </script>
  <script type="text/javascript">
    var modal = $('#addPrivatePhotoModal');

    modal.on('hidden.bs.modal', function () {
      cleanModalData($(this));
    });

    modal.find('input[type="file"]').change(function() {
      var formGroup = $(this).parent();
      var modalPreview = formGroup.find('img');
      var oFReader = new FileReader();
      
      if(this.files[0]) {
        $(modalPreview).cropper('destroy');
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
          modalPreview.parent().fadeIn();
          modalPreview.attr('src', oFREvent.target.result);
          formGroup.find('.photo-controls').fadeIn();
          
          modalPreview.cropper({
            aspectRatio: 1 / 1,
            dragMode: 'none',
            viewMode: 1,
            crop: function(data) {
              setCropData(this, data);
            }
          });
        }
      } else {
        modalPreview.find('img').cropper('destroy');
        modalPreview.attr('src','');
        modalPreview.parent().fadeOut();
        formGroup.find('.photo-controls').fadeOut();
      }
    });
  </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <div data-ng-controller="ProfileController" class="profile-container"> 
    <?php echo $__env->make('modals.addProfilePhoto', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('modals.addCoverPhoto', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('modals.addPhoto', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('modals.addPrivatePhoto', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <section class="profile-main" data-ng-if="userLoaded" style="background-image:url([[getCoverPhotoUrl(user.cover)]])">
      
      <div class="image-controls">
      <!--   <button type="button" data-ng-click="openModal('addCoverPhoto')"><i class="fa fa-picture-o"></i> <?php echo e(Lang::get('messages.changeCoverPhoto')); ?></button> -->
        <button type="button" data-ng-click="openModal('addProfilePhoto')"><i class="fa fa-camera"></i></button>
      </div>

      <div class="profile-wrap">
        <div class="wrap">
          <div id="userPhotoProfile"> 
            <div class="image" lightgallery data-src="[[getPhotoUrl(user.img)]]">
              <a href="[[getPhotoUrl(user.img)]]" class="lightGallery" title="[[user.username]]">
                <img data-ng-src="[[getPhotoPreviewUrl(user.img)]]" alt="profile pic" />
              </a>
            </div>
			<?php if(Auth()->user()->title!="ADMIN"): ?>
			<!--<div ng-if="[[user.verify_check]] == 'VERIFIED'" class="col-md-3 col-lg-3 col-sm-3 col-xs-3 col-md-offset-5 col-xs-offset-5">
			  <i class="fa fa-check edit-button" aria-hidden="true">Verified</i>
			</div>-->
			<?php endif; ?>
          </div>
		  <div class="clearfix"></div>
          <h1>
            <span class="verify-icon">
              [[user.username]] 
            </span>
			<?php if(Auth()->user()->verify_check =="VERIFIED"): ?>
				<img class="img-valign" src="<?php echo e(URL::asset('img/verifiedBadge2018.png')); ?>" alt="" />	
			<?php endif; ?>
          </h1>
          <p data-ng-if="user.description == ''">Share a statement here.</p>
          <p e-form="editableDescription" e-maxlength="200" onbeforesave="update($data, 'description', user.id)" editable-textarea="user.description">
            [[user.description]] 
            <button type="button" class="edit-button" ng-click="editableDescription.$show()" ng-hide="editableDescription.$visible"><i class="ion-edit"></i></button>
          </p>
			<?php if(Auth()->user()->verify_check ==""): ?>
		  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" >
		    <a class=" pull-right text-info" href="<?php echo e(URL::route('verify')); ?>"><h1><span class="edit-button">Account Verification</span></h1></a>
		  </div>
			<?php endif; ?>

        </div>
      </div>
    </section>

    <div class="stats">
      <div class="block-flex wrap-flex vertical-center-flex row-center-flex">
        <div class="stat age">
          <small class="user-age"><?php echo e(Lang::get('age')); ?></small>
          <span class="user-age">[[user.age]]</span>
        </div>
        <div class="stat status">
          <span class="indicator active"></span>
          <small><?php echo e(Lang::get('messages.onlineNow')); ?></small>
        </div>
        <div class="stat location"> 
          <i class="ion-ios-location" data-ng-click="editing($event)"></i>
          <span class="user-location" data-ng-click="editing($event)">[[user.location]]<i class="ion-edit"></i></span>
          <button class="close-input" data-ng-click="noMoreEditing($event)"><i class="ion-android-close"></i></button>
          <!-- <span>[[user.city]], [[user.country]]</span> -->
          <input type="text" ng-blur="noMoreEditing($event)" id="vendorAddress" elem-ready="geoReady()" name="address" class="form-control editable" ng-model="vendorAddress" placeholder="Type in and select your address.">
          <!-- END MAP -->
        </div>
      </div>
    </div>

  
    <div class="profile-gallery">
      <h2><?php echo e(Lang::get('messages.morePhotos')); ?></h2>
      
      <!-- Female only -->
      <div class="wrap" data-ng-if="user.gender == 'female' && user.photos.length == 0">
        <div class="highlight">
          <center>You’re more likely to get a Tribute if you add some quality pictures of yourself and or your fetish.</center> 
        </div>
      </div>

      <!-- Male only -->
      <div class="wrap" data-ng-if="user.gender == 'male' && user.photos.length == 0">
        <div class="highlight">
          <center>Upload to your public gallery and flaunt your wealth for even more attention. Its okay to do it, you're on Casualstar!</center> <i class="ion-happy-outline"></i>
        </div>
      </div>
      
      <div class="wrap">
        <div class="block-flex wrap-flex" id="userPhotos" ng-sortable="photoConfig" ng-model="user.photos">
          <div lightgallery class="photo" data-src="[[getPhotoUrl(photo.img)]]" data-ng-repeat="photo in user.photos"> 
            <a href="[[getPhotoUrl(photo.img)]]" class="lightGallery" title="[[photo.title]]">
              <img data-ng-if="userLoaded" data-ng-src="[[getPhotoPreviewUrl(photo.img)]]" alt="[[photo.title]]" />
            </a>
            <div class="controls">
              <button type="button" class="edit-button"><i class="ion-arrow-move"></i></button>
              <button type="button" class="edit-button" mwl-confirm="" title="<?php echo e(Lang::get('messages.removePhoto')); ?>" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="destroyPhoto(photo)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="ion-trash-a"></i></button>
            </div>
          </div>
        </div>
      </div>
      <div class="add-gallery-photo">
        <button type="button" data-ng-hide="user.photos.length > 3" data-ng-click="openModal('addPhoto')"><i class="fa fa-camera"></i> <?php echo e(Lang::get('messages.addPhoto')); ?></button>
      </div>
    </div>
   
    
      <div class="profile-gallery" data-ng-if="user.gender == 'female'">
      <h2>Private gallery([[user.privatephotos.length]]/8)</h2>
      <div class="wrap" data-ng-if="user.privatephotos.length == 0">
        <div class="highlight">
          <center>You currently have no uploads in your Private Gallery. </center> 
        </div>
      </div>
      
      <div class="wrap">
        <div class="block-flex wrap-flex" id="userPrivatePhotos" ng-sortable="photoConfig" ng-model="user.privatephotos">
          <div lightgallery class="photo" data-src="[[getPhotoUrl(photo.img)]]" data-ng-repeat="photo in user.privatephotos"> 
            <a href="[[getPhotoUrl(photo.img)]]" class="lightGallery" title="[[photo.title]]">
              <img data-ng-if="userLoaded" data-ng-src="[[getPrivatePhotoPreviewUrl(photo.img)]]" alt="[[photo.title]]" />
            </a>
            <div class="controls">
              <button type="button" class="edit-button"><i class="ion-arrow-move"></i></button>
              <button type="button" class="edit-button" mwl-confirm="" title="<?php echo e(Lang::get('messages.removePhoto')); ?>" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="destroyPrivatePhoto(photo)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="ion-trash-a"></i></button>
            </div>
          </div>
        </div>
      </div>
      <div class="add-gallery-photo" >
		<div data-ng-hide="user.privatephotos.length > 7">
			<button type="button" data-ng-show="iwantaccess" data-ng-click="openModal('addPrivatePhoto')"><i class="fa fa-camera"></i> Add Private Photo</button>
			<button type="button" class="addPrivatePhoto2" data-ng-hide="iwantaccess" ><i class="fa fa-camera"></i> Add Private Photo</button>
        </div>
      </div>
      <div class="private-note"><label class="private-note-label" style= "padding-left: 2px; padding-right: 2px;">Note: Your Private Gallery will NOT be seen by visitors unless you grant them access.</label></div></div>
     
    <?php if((isset($user->cashme_url) && $user->cashme_url != '') || (isset($user->paypal_url) && $user->paypal_url != '') || $user->alt_url == 1): ?>
      <div class="donate-btn-box">
        <div class="wrap">
          <button class="main-btn donate-btn" data-toggle="modal" data-target="#donateModal">PAY ME</button>
        </div>
      </div>
    <?php endif; ?>
    <section class="rec-members service-list-section" ng-if="serviceList.length>0">
        <div class="wrap">
            <h3>All Available Services</h3>
            <center><p>Promote to your Twitter & Instagram followers for more sales & Tributes.</p></center></br>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3" ng-repeat="service in serviceList">
                        <div class="box box-success" ng-if="service.service_name!='' && service.service_name != null">
                            <div class="box-header with-border">
                                <h3 class="box-title">[[service.service_name]]</h3>

                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <span ng-if="service.negotiate=='true'">Negotiate / [[service.variable_name]]</span>
                                <span ng-if="service.negotiate!='true'"> [[service.amount]] [[currency_code]] / [[service.variable_name]]</span>

                            </div>
                            <div class="box-footer">
                                <button type="submit"  class="btn-sm btn-default btn-flat send-request" >Send Request</button>
                               
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>

                </div>
            </div>
        </div>
    </section>
	<?php if(Auth::user()->gender == 'female'): ?>
	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" ng-if="[[user.verify_check]] != 'VERIFIED'"><!--NEED TO CHECK FOR IF THEY HAVE ALREADY ACTIVATE THEIR TWITTER AUTO TWEETS... DISPLAY IF NO & DO NOT DISPLAY IF YES---->
		<a class="pull-right text-info" href="<?php echo e(URL::route('twit.account')); ?>"><h5><span class="ion-social-twitter">Click to promote on your Twitter</span></h5></a>
	</div>                   
	<?php endif; ?>

    <div class="tags">
      <div class="wrap">
        <h2><?php echo e(Lang::get('messages.iEnjoy')); ?></h2>
        <ui-select multiple data-ng-click="searchInterests('')" ng-model="results.selected" theme="bootstrap">
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
    </div>
    <?php echo $__env->make('modals.donate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>