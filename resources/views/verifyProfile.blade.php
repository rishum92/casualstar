@extends('layouts.master')

@section('meta')
  <title>Account Verification » CasualStar</title>
@endsection

@section('scripts')
  <script type="text/javascript">
    var modal = $('#addSelfiePhotoModal');

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
@endsection

@section('content')
  <div data-ng-controller="ProfileController" class="profile-container"> 
    @include('modals.addSelfiePhoto')
    <section class="profile-main" data-ng-if="userLoaded" style="background-image:url([[getCoverPhotoUrl(user.cover)]])">
      
      <div class="img-valign_150" title="Verified" ng-if="user.verify_check == 'VERIFIED'">
      <!--   <button type="button" data-ng-click="openModal('addCoverPhoto')"><i class="fa fa-picture-o"></i> {{ Lang::get('messages.changeCoverPhoto') }}</button> -->
		<img src="[[getVerifySymbolUrl()]]" alt="" />
      </div>
	  <!--<div class="profile-wrap">-->
        <div class="wrap">
          <div id="userPhotoProfile" ng-init="[[initLightGallery()]]" ng-if="user.verify_check !== 'PENDING'"> 
			  <div ng-if="user.verify_check != 'VERIFIED'"> 
				<div class="image" lightgallery data-src="[[getSamplePhotoUrl]]" ng-if="user.verify_check != 'VERIFIED'">
				  <a href="[[getSamplePhotoUrl]]" class="lightGallery" title="Example Photo">
					<img data-ng-src="[[getSamplePhotoUrl]]" alt="Example Photo" />
				  </a>
				 <span>
			  <h3 class="edit-button">Example Photo</h3>
				</span>
				</div>
				<span>
			  <h1><u class="text-warning">Verification Guidelines</u></h1>
				</span>
			  <h4>
				<span class="text-danger">
				 Please ensure the following guidelines are met before submitting your photo for approval. 
				</span>
			  </h4><hr>
				  <div class="list-group text-danger"><div class="list-group-item list-group-item-info"><h5 class="" style="color:red;"> We manually check submissions so please DO NOT submit a regular photo of yourself that does not follow the required guidelines, otherwise IT WILL BE REJECTED.</h5></div>
				  <div class="list-group-item list-group-item-info"><h5><li class="text-left"> DO NOT submit a picture of an I.D card or Passport.</li></h5></div>
				
					  <div class="list-group-item list-group-item-info"><h5><li class="text-left">Ensure your FACE, USERNAME and the CASUALSTAR.UK website name are CLEARLY WRITTEN on the paper and follows the format in the "Example Photo" above. Failure to include any of these important details will result in your application being rejected.</li></h5></div>
					  <div class="list-group-item list-group-item-info"><h5><li class="text-left">Ensure that you have a profile picture or at least 2 separate photos within your Public Gallery that clearly shows your face.</li></h5></div>
					  <div class="list-group-item list-group-item-info"><h5><li class="text-left">Ensure photo submitted is not too dark, pixelated, overlayed, too small, or faked.</li></h5></div>
					  <div class="list-group-item list-group-item-info"><h5><li class="text-left">Ensure that your image is correctly orrientated. if you need to please rotate your image so that it reads from left to right.</li></h5></div>
					  <div class="list-group-item list-group-item-info"><h5><li class="text-left">The process normally takes between 1 and 3 business days to be checked and verified.</li></li></h5></div>
					  <div class="list-group-item list-group-item-info"><h5><li class="text-left">NOTE: Your verification photo will only been used by our team to verify your Casualstar.UK account.</li></li></h5></div>
					  	  <div class="list-group text-danger"><div class="list-group-item list-group-item-info"><h5><li class="text-left" style="color:red;">NOTE: If you are not able to read, understand and correctly follow the simple guidelines stated above, we may rightly assume you lack the understanding needed for our website, and as a result your account may be blocked and deleted without further notice.</li></h5></div>
				  </div>
				  </div>
				<div class="add-gallery-photo" style="background:transparent;" ng-if="user.verify_check != 'VERIFIED'">
					<button type="button" data-ng-click="openModal('addSelfiePhoto')"><i class="fa fa-camera"></i> {{ Lang::get('messages.addSelfiePhoto') }}</button>
				</div>		  
			</div>
		</div>
		<div class="clearfix"></div>
		<br/>		  
		<div id="userPhotos" ng-init="[[initLightGallery()]]"> 
            <div class="image" lightgallery data-src="[[getVerifyPhotoUrl(user.verify_img)]]" ng-if="user.verify_check != 'None' && (user.verify_img != null || user.verify_img != '')">
              <a href="[[getVerifyPhotoUrl(user.verify_img)]]" class="lightGallery" title="[[user.username]]">
                <img data-ng-src="[[getVerifyPhotoUrl(user.verify_img)]]" alt="[[user.username]]" />
              </a>
            </div>
		</div>
		  <span ng-if="user.verify_check != 'None'">
			<h1><u class="text-warning">Verification Status</u></h1>
			</span>
		  <div class="list-group text-danger"  ng-if="user.verify_check == 'PENDING'">
			  <div class="list-group-item list-group-item-info"><h5 class="text-left text-warning">Thank you. Your verification is pending: if Successful, a message will display here, stating that your account has now been verified. You and any visitors to your page will also be able to see the verification badge next to your profile username. If you have not completed your profile, pleasee do, as it will help in the verification process. Thanks.</h5></div>
		  </div>
		  <div class="list-group text-danger"  ng-if="user.verify_check == 'VERIFIED'">
			  <div class="list-group-item list-group-item-sucess"><h5 class="text-center text-success">Congratulations. You have successfully verified your account. Your verification badge can now be seen on your profile page, next to your username.</h5></div>
		  </div>
		  <div class="list-group text-danger"  ng-if="user.verify_check == 'CANCELLED'">
			  <div class="list-group-item list-group-item-info"><h5><div> Unfortunately your account was not verified. This may have been caused by one or more of the following:</div><hr/><div class="list-group text-danger"><h5><li class="text-left">You had no other images of yourself at the time we viewed your profile.</li><li class="text-left">Your photo submitted did not resemble your profile picture or images in your public gallery.</li><li class="text-left">The verification photo you submitted did not display all the relevant guidelines required, as detailed above and or depicted in the illustrated example photo.</li><li class="text-left">You are more than welcome to resubmit another request that meets the necessary guidelines.</li></h5></div></li></h5></div>
		  </div>
        </div>
      <!--</div>-->	
    </section>
  </div>

@endsection