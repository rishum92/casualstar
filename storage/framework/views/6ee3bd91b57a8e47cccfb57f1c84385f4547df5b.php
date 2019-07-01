<?php $__env->startSection('meta'); ?>
  <title>Explore Banner Ads | CasualStar</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
	function validateFilePresent() {
		var filePresent = false;

      $('input.image-file').each(function(key, input) {
        if(input.value != '') {
            filePresent = true;
        }
      });

      if(!filePresent) {
        $('#unconfirmFiles').click();
      }
	}
</script>
  <script type="text/javascript">
    var modal = $('#addPhoto1Modal');

    modal.on('hidden.bs.modal', function () {
    	if($('#addPhoto1Preview').attr('src') == undefined) {
	      cleanModalData($(this));
    	}
    });

    modal.find('input[type="file"]').change(function() {
      var formGroup = $(this).parent();
      var modalPreview = formGroup.find('img');
      var oFReader = new FileReader();

      if(this.files[0]) {
          var allowedFormats = ['image/png','image/jpeg'];
          if(allowedFormats.indexOf(this.files[0].type) == -1) {
              notify('warning', 'You may only upload JPG and PNG photos.');
              this.value = '';
              validateFilePresent();
              return;
          }
      	var fileSize = this.files[0].size / 1000;
	    var maxSize = 4.5 * 1000;
	    if(fileSize > maxSize) {
	      notify('warning', 'Selected file size exceeds max: 4.5MB');
	      this.value = '';
	      validateFilePresent();
	      return;
	    }
        $(modalPreview).cropper('destroy');
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
          modalPreview.parent().fadeIn();
          modalPreview.attr('src', oFREvent.target.result);
          formGroup.find('.photo-controls').fadeIn();

          modalPreview.cropper({
            aspectRatio: 16 / 10,
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
        var preview = $('#addPhoto1Preview');
        preview.parent().addClass('hidden');
        validateFilePresent();
      }
    });
  </script>
  <script type="text/javascript">
    var modal = $('#addPhoto2Modal');

    modal.on('hidden.bs.modal', function () {
	if($('#addPhoto2Preview').attr('src') == undefined) {
	     cleanModalData($(this));
	  }
    });

    modal.find('input[type="file"]').change(function() {
      var formGroup = $(this).parent();
      var modalPreview = formGroup.find('img');
      var oFReader = new FileReader();

      if(this.files[0]) {
          var allowedFormats = ['image/png','image/jpeg'];
          if(allowedFormats.indexOf(this.files[0].type) == -1) {
              notify('warning', 'You may only upload JPG and PNG photos.');
              this.value = '';
              validateFilePresent();
              return;
          }
      	var fileSize = this.files[0].size / 1000;
	    var maxSize = 4.5 * 1000;
	    if(fileSize > maxSize) {
	      notify('warning', 'Selected file size exceeds max: 4.5MB');
	      this.value = '';
        	validateFilePresent();
	      return;
	    }
        $(modalPreview).cropper('destroy');
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
          modalPreview.parent().fadeIn();
          modalPreview.attr('src', oFREvent.target.result);
          formGroup.find('.photo-controls').fadeIn();

          modalPreview.cropper({
            aspectRatio: 16 / 10,
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
        var preview = $('#addPhoto2Preview');
        preview.parent().addClass('hidden');
        validateFilePresent();
      }
    });
  </script>
  <script type="text/javascript">
    var modal = $('#addPhoto3Modal');

    modal.on('hidden.bs.modal', function () {
    	if($('#addPhoto3Preview').attr('src') == undefined) {
  		    cleanModalData($(this));
  		}
    });

    modal.find('input[type="file"]').change(function() {
      var formGroup = $(this).parent();
      var modalPreview = formGroup.find('img');
      var oFReader = new FileReader();

      if(this.files[0]) {
          var allowedFormats = ['image/png','image/jpeg'];
          if(allowedFormats.indexOf(this.files[0].type) == -1) {
              notify('warning', 'You may only upload JPG and PNG photos.');
              this.value = '';
              validateFilePresent();
              return;
          }
      	var fileSize = this.files[0].size / 1000;
	    var maxSize = 4.5 * 1000;
	    if(fileSize > maxSize) {
	      notify('warning', 'Selected file size exceeds max: 4.5MB');
	      this.value = '';
        	validateFilePresent();
	      return;
	    }
        $(modalPreview).cropper('destroy');
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
          modalPreview.parent().fadeIn();
          modalPreview.attr('src', oFREvent.target.result);
          formGroup.find('.photo-controls').fadeIn();

          modalPreview.cropper({
            aspectRatio: 16 / 10,
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
        var preview = $('#addPhoto3Preview');
        preview.parent().addClass('hidden');
    	validateFilePresent();
      }
    });
  </script>
  <script type="text/javascript">
    var modal = $('#addPhoto4Modal');

    modal.on('hidden.bs.modal', function () {
    	if($('#addPhoto4Preview').attr('src') == undefined) {
      		cleanModalData($(this));
  		}
    });

    modal.find('input[type="file"]').change(function() {
      var formGroup = $(this).parent();
      var modalPreview = formGroup.find('img');
      var oFReader = new FileReader();

      if(this.files[0]) {
          var allowedFormats = ['image/png','image/jpeg'];
          if(allowedFormats.indexOf(this.files[0].type) == -1) {
              notify('warning', 'You may only upload JPG and PNG photos.');
              this.value = '';
              validateFilePresent();
              return;
          }
      	var fileSize = this.files[0].size / 1000;
	    var maxSize = 4.5 * 1000;
	    if(fileSize > maxSize) {
	      notify('warning', 'Selected file size exceeds max: 4.5MB');
	      this.value = '';
        	validateFilePresent();
	      return;
	    }
        $(modalPreview).cropper('destroy');
        oFReader.readAsDataURL(this.files[0]);
        oFReader.onload = function (oFREvent) {
          modalPreview.parent().fadeIn();
          modalPreview.attr('src', oFREvent.target.result);
          formGroup.find('.photo-controls').fadeIn();

          modalPreview.cropper({
            aspectRatio: 16 / 10,
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
        var preview = $('#addPhoto4Preview');
        preview.parent().addClass('hidden');
    	validateFilePresent();
      }
    });
  </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="banner-ads-section">
	<div class="wrap" id="bannerAdsController" ng-controller="BannerAdsController">
		<h1>Banner Ads request form</h1>
      	<div class="container">
	     	<div class="row">
	     		<div class="col-md-2">
	     			&nbsp;
	     		</div>
	      		<div class="col-md-8">
      				<h3>What would you like to post on the Explore page Banner?</h3>
					<div class="ads-type-buttons">
						<div class="row">
							<div class="col-md-2">
							</div>
							<div class="col-md-3">
								<button ng-click="selectType('images')" class="ad-type-button btn-primary [[getActiveTypeClass('images')]]" type="button" name="type">1 to 4 images</button>
							</div>
							<div class="col-md-2 or-type">
								<span><h3>Or</h3></span>
							</div>
							<div class="col-md-3">
	     						<button ng-click="selectType('video')" class="ad-type-button btn-primary [[getActiveTypeClass('video')]]" type="button" name="type">Short Video Clip</button>
							</div>
							<div class="col-md-2">
							</div>
						</div>
					</div>
					<div class="ads-files" ng-if="typeSelected">
						<button class="hidden" id="confirmFiles" ng-click="confirmFiles()">Confirm files</button>
						<button class="hidden" id="unconfirmFiles" ng-click="unconfirmFiles()">Confirm files</button>
						<div class="row">
							<div class="col-md-3" ng-if="type == 'video'">&nbsp;</div>
							<div class="col-md-6 text-align-center animated fadeIn" ng-if="type == 'video'">
								<div class="add-gallery-photo no-bg">
									<video id="video" class="hidden animated fadeIn"></video>
									<input type="file" id="videoFile" class="hidden" ng-model="video" onchange="videoSelected(this)" accept=".mp4,.mp4v,.mpg4,.mp2,.mov">
									<p>Allowed formats: MP4 and MOV</p>
									<p>Maximum filesize: 280MB</p>
									<br>
									<button type="button" onclick="clickInputFile(this)"><i class="fa fa-video-camera"></i> Select video clip</button>
								</div>
							</div>
							<div class="col-md-3 animated fadeIn" ng-if="type == 'video'">&nbsp;</div>
							<div class="col-md-3 animated fadeIn" ng-if="type == 'images'">
								<div class="img-controls hidden animated fadeIn">
									<img class="banner-ad-image" id="addPhoto1Preview">
								</div>
								<div class="add-gallery-photo no-bg">
									<button type="button" ng-click="openModal('addPhoto1')"><i class="fa fa-camera"></i> Select photo</button>
								</div>
							</div>
							<div class="col-md-3 animated fadeIn" ng-if="type == 'images'">
								<div class="img-controls hidden animated fadeIn">
									<img class="banner-ad-image" id="addPhoto2Preview">
								</div>
								<div class="add-gallery-photo no-bg">
									<button type="button" ng-click="openModal('addPhoto2')"><i class="fa fa-camera"></i> Select photo</button>
								</div>
							</div>
							<div class="col-md-3 animated fadeIn" ng-if="type == 'images'">
								<div class="img-controls hidden animated fadeIn">
									<img class="banner-ad-image" id="addPhoto3Preview">
								</div>
								<div class="add-gallery-photo no-bg">
									<button type="button" ng-click="openModal('addPhoto3')"><i class="fa fa-camera"></i> Select photo</button>
								</div>
							</div>
							<div class="col-md-3 animated fadeIn" ng-if="type == 'images'">
								<div class="img-controls hidden animated fadeIn">
									<img class="banner-ad-image" id="addPhoto4Preview">
								</div>
								<div class="add-gallery-photo no-bg">
									<button type="button" ng-click="openModal('addPhoto4')"><i class="fa fa-camera"></i> Select photo</button>
								</div>
							</div>
						</div>
					</div>
					<div class="ads-calendar animated fadeIn" ng-if="filesConfirmed">
						<h3>When would you like your banner to be featured?</h3>
						<p>[[selectedDays.length > 0 ? selectedDates : 'Please select the dates using the calendar below.']]</p>
						<div class="row calendar-view">
							<div class="col-md-6">
								<h4>[[monthInView]] [[year]]</h4>
							</div>
							<div class="col-md-6">
								<div class="btn-group ads-calendar-buttons">
									<button
											class="btn btn-primary"
											mwl-date-modifier
											date="viewDate"
											ng-click="setMonths('prev')"
											decrement="calendarView">
										Previous month
									</button>
									<button
											class="btn btn-default"
											mwl-date-modifier
											date="viewDate"
											set-to-today>
										Today
									</button>
									<button
											class="btn btn-primary"
											mwl-date-modifier
											date="viewDate"
											ng-click="setMonths('next')"
											increment="calendarView">
										Next month
									</button>
								</div>
							</div>
						</div>
						<mwl-calendar
							events="events"
							view="calendarView"
							view-date="viewDate"
							cell-modifier="cellModifier(calendarCell)"
							on-timespan-click="selectDay(calendarCell)"
							excluded-days="excludedDays"
							on-view-change-click="viewChangeClicked(calendarNextView)"
							on-date-range-select="rangeSelected(calendarRangeStartDate, calendarRangeEndDate)"
						>
						</mwl-calendar>
						<p>[[selectedDays.length > 0 ? 'You have selected: ' + selectedDates : '']]</p>
					</div>
					<div class="ads-review-terms animated fadeIn" ng-if="selectedDays.length > 0">
						<div class="row">
							<div class="col-md-12">
								<h1>Terms and conditions</h1>
								<p>You may upload images and create a video that is, kink specific, teasing, sexy, classy, bratty, montage, or just a regular selfie clip. You may also say whatever you feel works best for you. Ensure the video is well lit, and does not have excessive background noise.  Background music is okay.</p>
								<br>
								<p>It is prohibited for your submitted content to include, children, vulnerable adults, anything illegal, offensive, or unrelated to what this website is all about.</p>
								<br>
								<p><strongg>NOTE:</strongg> All videos and images submitted are subject to review by Casualstar, and will only be approved if it meets our standards and satisfaction.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<p>Please review your e-mail address: [[$parent.user.email]]</p>
								<br><br>
								<input id="extra_promotions" ng-model="requestFormData.extra_promotions" type="checkbox"><label for="extra_promotions">I would also like to add my submitted video and or images to Casualstar’s social networks (Instagram and twitter) for extra promotions.</label>
							</div>
							<div class="col-md-6">
								&nbsp;
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<button class="submit" ng-click="completeBooking($event)">Complete Booking</button>
							</div>
						</div>
					</div>
	      		</div>
	      		<div class="col-md-2">
	     			&nbsp;
	     		</div>
	      	</div>
      	</div>
      	<div class="modal fade" id="addPhoto1Modal" tabindex="-1" role="dialog" aria-labelledby="addPhoto1Modal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <form name="addPhoto1" ng-submit="submitModal('addPhoto1')" files="true" novalidate>
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
		          <h2>Add photo</h2>
		        </div>
		        <div class="modal-body">
		          <div class="form-group">
		            <div class="img-preview">
		              <img src="" class="live-preview" alt="<?php echo app('translator')->get('messages.uploadPreview'); ?>">
		            </div>
		            <?php echo $__env->make('components.cropperControls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		            <label>Photo</label>
		            <input type="hidden" name="x" ng-model="addPhoto1['data'].x" />
		            <input type="hidden" name="y" ng-model="addPhoto1['data'].y" />
		            <input type="hidden" name="width" ng-model="addPhoto1['data'].width" />
		            <input type="hidden" name="height" ng-model="addPhoto1['data'].height" />
		            <input type="hidden" name="rotate" ng-model="addPhoto1['data'].rotate" />
		            <input type="hidden" name="type" ng-model="addPhoto1['data'].type">
		            <input type="file" name="file" ng-model="addPhoto1['data'].file" class="form-control image-file" id="photoFile1" accept=".jpg,.jpeg,.png" valid-file required>
		          </div>
		        </div>
		        <div class="modal-footer">
		          <button type="button" ng-click="submitModal('addPhoto1')" ng-disabled="addPhoto1.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input>
		        </div>
		      </form>
		    </div>
		  </div>
		</div>
		<div class="modal fade" id="addPhoto2Modal" tabindex="-1" role="dialog" aria-labelledby="addPhoto2Modal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <form name="addPhoto2" ng-submit="submitModal('addPhoto2')" files="true" novalidate>
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
		          <h2>Add photo</h2>
		        </div>
		        <div class="modal-body">
		          <div class="form-group">
		            <div class="img-preview">
		              <img src="" class="live-preview" alt="<?php echo app('translator')->get('messages.uploadPreview'); ?>">
		            </div>
		            <?php echo $__env->make('components.cropperControls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		            <label>Photo</label>
		            <input type="hidden" name="x" ng-model="addPhoto2['data'].x" />
		            <input type="hidden" name="y" ng-model="addPhoto2['data'].y" />
		            <input type="hidden" name="width" ng-model="addPhoto2['data'].width" />
		            <input type="hidden" name="height" ng-model="addPhoto2['data'].height" />
		            <input type="hidden" name="rotate" ng-model="addPhoto2['data'].rotate" />
		            <input type="hidden" name="type" ng-model="addPhoto2['data'].type">
		            <input type="file" name="file" ng-model="addPhoto2['data'].file" class="form-control image-file" id="photoFile2" accept=".jpg,.jpeg,.png" valid-file required>
		          </div>
		        </div>
		        <div class="modal-footer">
		          <button type="button" ng-click="submitModal('addPhoto2')" ng-disabled="addPhoto2.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input>
		        </div>
		      </form>
		    </div>
		  </div>
		</div>
		<div class="modal fade" id="addPhoto3Modal" tabindex="-1" role="dialog" aria-labelledby="addPhoto3Modal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <form name="addPhoto3" ng-submit="submitModal('addPhoto3')" files="true" novalidate>
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
		          <h2>Add photo</h2>
		        </div>
		        <div class="modal-body">
		          <div class="form-group">
		            <div class="img-preview">
		              <img src="" class="live-preview" alt="<?php echo app('translator')->get('messages.uploadPreview'); ?>">
		            </div>
		            <?php echo $__env->make('components.cropperControls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		            <label>Photo</label>
		            <input type="hidden" name="x" ng-model="addPhoto3['data'].x" />
		            <input type="hidden" name="y" ng-model="addPhoto3['data'].y" />
		            <input type="hidden" name="width" ng-model="addPhoto3['data'].width" />
		            <input type="hidden" name="height" ng-model="addPhoto3['data'].height" />
		            <input type="hidden" name="rotate" ng-model="addPhoto3['data'].rotate" />
		            <input type="hidden" name="type" ng-model="addPhoto3['data'].type">
		            <input type="file" name="file" ng-model="addPhoto3['data'].file" class="form-control image-file" id="photoFile3" accept=".jpg,.jpeg,.png" valid-file required>
		          </div>
		        </div>
		        <div class="modal-footer">
		          <button type="button" ng-click="submitModal('addPhoto3')" ng-disabled="addPhoto3.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input>
		        </div>
		      </form>
		    </div>
		  </div>
		</div>
		<div class="modal fade" id="addPhoto4Modal" tabindex="-1" role="dialog" aria-labelledby="addPhoto4Modal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <form name="addPhoto4" ng-submit="submitModal('addPhoto4')" files="true" novalidate>
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
		          <h2>Add photo</h2>
		        </div>
		        <div class="modal-body">
		          <div class="form-group">
		            <div class="img-preview">
		              <img src="" class="live-preview" alt="<?php echo app('translator')->get('messages.uploadPreview'); ?>">
		            </div>
		            <?php echo $__env->make('components.cropperControls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		            <label>Photo</label>
		            <input type="hidden" name="x" ng-model="addPhoto4['data'].x" />
		            <input type="hidden" name="y" ng-model="addPhoto4['data'].y" />
		            <input type="hidden" name="width" ng-model="addPhoto4['data'].width" />
		            <input type="hidden" name="height" ng-model="addPhoto4['data'].height" />
		            <input type="hidden" name="rotate" ng-model="addPhoto4['data'].rotate" />
		            <input type="hidden" name="type" ng-model="addPhoto4['data'].type">
		            <input type="file" name="file" ng-model="addPhoto4['data'].file" class="form-control image-file" id="photoFile4" accept=".jpg,.jpeg,.png" valid-file required>
		          </div>
		        </div>
		        <div class="modal-footer">
		          <button type="button" ng-click="submitModal('addPhoto4')" ng-disabled="addPhoto4.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input>
		        </div>
		      </form>
		    </div>
		  </div>
		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>