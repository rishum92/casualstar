<?php $__env->startSection('meta'); ?>
 <title>CasualStar.UK  | Findom Services.  Dedicated to bringing Paypigs & Femdoms together.</title>
<meta name="description" content="CasualStar is a fetish platform that can help you gain an extra income as a femdom. Keep 100% of any tribute you make on CasualStar. Paypigs can easily keep track of new content posted by their favourite femdoms.">
<meta name="keywords" content="findom, paypigs, subs, financial dominatrix, paid fetish, bdsm, casualstar, casual, star,earn money, cash, online,findoms, femdoms, paypigs, escorting, mature dating service, free money, cash, extra income, meet for sex, sex online,casual encounters,donations"></meta>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <script type="text/javascript">

    function triggerPhotoChange() {
      $('.step.fourth-step').find('input[type="file"]').click();
    } 

    $("#username").on("keydown", function (e) {
        return e.which !== 32;
    });

    $("#username").on("change", function (e) {
        $("#username").val($("#username").val().replace(/ /g,'')); 
    });

    $(document).ready(function() {  

      var eighteenYears = new Date();
      eighteenYears.setTime(eighteenYears.valueOf() - 18 * 365 * 24 * 60 * 60 * 1000 - 5 * 24 * 60 * 60 * 1000);
      var hundredYears = new Date();
      hundredYears.setTime(hundredYears.valueOf() - 100 * 365 * 24 * 60 * 60 * 1000 - 18 * 24 * 60 * 60 * 1000); 

      $('#dob').datetimepicker({ 
        format: 'YYYY-MM-DD',
        viewMode: 'years',
        minDate : hundredYears.toISOString().slice(0,10),
        maxDate : eighteenYears.toISOString().slice(0,10)
      });

      $('#location').geocomplete({ 
      
      }).bind("geocode:result", function(event, result){  
        $('#lat').val(result.geometry.location.lat());
        $('#lng').val(result.geometry.location.lng());
        $('#locationNext').removeAttr('disabled');
        $('#createAccount').removeAttr('disabled'); 
      });

      $('#location').bind("propertychange change click keyup input paste", function(event) {
        $('#locationNext').attr('disabled', 'disabled');
        $('#createAccount').attr('disabled', 'disabled');
      })

      $('.step.fourth-step').find('input[type="file"]').change(function() {
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
              viewMode: 1,
              dragMode: 'none',

              crop: function(data) {
                setCropData(this, data);
              }
            });
          }
        }
      });
	  
	  
	  /* Twitter Register APInfo*/
	  
	  $('#twit_dob').datetimepicker({ 
        format: 'YYYY-MM-DD',
        viewMode: 'years',
        minDate : hundredYears.toISOString().slice(0,10),
        maxDate : eighteenYears.toISOString().slice(0,10)
      });

      $('#twit_location').geocomplete({ 
      
      }).bind("geocode:result", function(event, result, status){  
	  console.log(status);
	  console.log("lat " + result.geometry.location.lat() + "l " + result.geometry.location.lat());
        $('#twit_lat').val(result.geometry.location.lat());
        $('#twit_lng').val(result.geometry.location.lng());
		// console.log("yes");
		if($("form[name='register_twitter'] input[name='gender']:checked").length == 1){
			// console.log("all ok");
			$('#twit_createAccount').removeAttr('disabled'); 
			$("form[name='register_twitter']").submit();
		}
      });

      $('#twit_location').bind("propertychange change click keyup input paste", function(event) {
        $('#twit_createAccount').attr('disabled', 'disabled');
      });

      $('.step.last-step').find('input[type="file"]').change(function() {
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
              viewMode: 1,
              dragMode: 'none',

              crop: function(data) {
                setCropData(this, data);
              }
            });
          }
        }
      })
    });
  </script>

  <?php if(Session::has('toggleLogin')): ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('.main-btn.login').parent().removeClass('in').addClass('out');
        $('.main-btn.twitter_login').parent().removeClass('in').addClass('out');
        $('.login-step').removeClass('out').addClass('in');
        $('.twitter_login-step').removeClass('in').addClass('out');
      });
    </script>
  <?php endif; ?>
  
  
  <?php if(Session::has('toggleLoginTwitter')): ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('.main-btn.login').parent().removeClass('in').addClass('out');
        $('.main-btn.twitter_login').parent().removeClass('in').addClass('out');
        $('.last-step').removeClass('out').addClass('in');
        $('.twitter_login-step').removeClass('in').addClass('out');
      });
    </script>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <section class="main">
    <div class="message">
    </div>
    <?php if(!Auth::check()): ?>
    <div class="form-hold" id="form-top">
      <div class="form">
        <div class="logo"><img src="/img/logo.png" alt="logo"/></div>

        <div class="step first-step in">
          <h4><p class="tip"><?php echo e(Lang::get('messages.loginSignUp')); ?></p></h4>
          <button class="main-btn login stroke-btn" type="submit"><?php echo e(Lang::get('messages.login')); ?></button>
          <br>
          <button class="main-btn create-account" type="submit"><?php echo e(Lang::get('messages.createAccount')); ?></button>
          <span class="facebook-option"><?php echo e(Lang::get('messages.orYouCan')); ?></span>
          <a href="<?php echo e(URL::route('auth.getSocialAuth', 'facebook')); ?>"><button class="main-btn facebook-btn"><?php echo e(Lang::get('messages.loginFb')); ?></button></a>
          <span class="facebook-disclaimer">*We do not share with your Facebook.</span>
		  <br/>
          <!--<button class="main-btn twitter_login stroke-btn" type="submit"><?php echo e(Lang::get('messages.loginTwt')); ?></button>-->
		  <a href="<?php echo e(URL::route('auth.getSocialAuth', 'twitter')); ?>"><button class="main-btn stroke-btn"><?php echo e(Lang::get('messages.loginTwt')); ?></button></a>

      <br/> <!--
        <h4 class="tributeCount">Successful tributes: <span><?php echo e(31912 + $tributeCount); ?></span>.est</h4> -->
        </div> 
       
        <?php echo Form::open(array('name' => 'register', 'route' => 'register', 'method' => 'POST', 'files' => true, 'novalidate' => 'novalidate')); ?>

          <div class="step second-step out" data-ng-controller="RegisterController">
            <p class="tip"><?php echo e(Lang::get('messages.personalData')); ?><br><span class="small">(<?php echo e(Lang::get('messages.step')); ?> 1/3)</span></p>
            <div class="block-flex wrap-flex space-between-flex">
              <div class="form-group">
                <label><?php echo e(Lang::get('messages.username')); ?></label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="ion-android-person"></i></span>
                  <input data-ng-model="username" id="username" type="text" maxlength="16" name="username" class="form-control" placeholder="">
                </div>
                <div class="custom-help-block"><?php echo e(Lang::get('messages.usernameError')); ?></div> 
              </div>
              <div class="form-group">
                <label>Email</label>
                <div class="input-group"> 
                  <span class="input-group-addon"><i class="ion-ios-email"></i></span>
                  <input data-ng-model="email" type="email" maxlength="70" name="email" class="form-control" placeholder="">
                </div>
                <div class="custom-help-block"><?php echo e(Lang::get('messages.emailError')); ?></div>
              </div>
            </div>

            <div class="block-flex wrap-flex space-between-flex">
              <div class="form-group">
                <label><?php echo e(Lang::get('messages.password')); ?></label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="ion-android-lock"></i></span>
                  <input type="password" maxlength="88" name="password" class="form-control" placeholder="">
                </div>
                <div class="custom-help-block">Passwords must match and be at least 4 characters in length.</div>
              </div>
              <div class="form-group">
                <label><?php echo e(Lang::get('messages.confirmPassword')); ?></label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="ion-android-lock"></i></span>
                  <input type="password" maxlength="88" name="password_confirmation" class="form-control" placeholder="">
                </div>
                <div class="custom-help-block">Passwords must match and be at least 4 characters in length.</div>
              </div>
            </div>  

            <div class="form-group">
              <label>Date of birth</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="ion-calendar"></i></span>
                <input type="text" id="dob" name="dob" class="form-control" placeholder="">
              </div>
            </div>

            <div class="form-group">
              <label>Select your gender</label>
              <div class="input-group radio-group">
                <input type="radio" name="gender" id="male" value="male">
                <label for="male"><i class="ion-male"></i> Male</label>
                <input type="radio" name="gender" id="female" value="female">
                <label for="female"><i class="ion-female"></i> Female</label>
              </div>
              <div class="custom-help-block">Please select your gender.</div>
            </div>
            
            <br>
        <div style=" font-size: 11px; font-weight: bold; text-align: center; "><center>By registering, you agree to the CasualStar.uk <a href="https://www.casualstar.uk/terms-and-conditions">Terms & Conditions</a> and <a href="https://www.casualstar.uk/privacy">Privacy Policy.</center></a></div>
        <hr>
            <span class="main-btn step-btn stroke-btn">next step</span>
            <a class="small-link back-link back-step"><h3><i class="ion-android-arrow-back"></i>Back</h3></a>
          </div>
          
          <div class="step third-step out">
            <p class="tip">Add your location<br><span class="small">(step 2/3)</span></p>
            <div class="form-group">
              <label>Location</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="ion-ios-location"></i></span>
                <input type="text" id="location" name="location" class="form-control" placeholder="">
                <input type="hidden" id="lat" name="lat" placeholder="">
                <input type="hidden" id="lng" name="lng" placeholder="">
              </div>
            </div>
            <button class="main-btn step-btn stroke-btn" type="button" id="locationNext" disabled>next step</button>
            <a class="small-link back-link back-step2"><h3><i class="ion-android-arrow-back"></i>Back</h3></a>
          </div>
        
          <div class="step fourth-step out">
              <p class="tip">Add your profile image <br><span class="small">(step 3/3 - optional)</span></p>
              <div class="form-group">
                <div class="img-preview">
                  <img src="" alt="<?php echo app('translator')->get('messages.uploadPreview'); ?>">
                </div>
                <?php echo $__env->make('components.cropperControls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                <input type="hidden" name="x" ng-model="addProfilePhoto['data'].x" />
                <input type="hidden" name="y" ng-model="addProfilePhoto['data'].y" />
                <input type="hidden" name="width" ng-model="addProfilePhoto['data'].width" />
                <input type="hidden" name="height" ng-model="addProfilePhoto['data'].height" />
                <input type="hidden" name="rotate" ng-model="addProfilePhoto['data'].rotate" />
                <input type="file" name="file" class="form-control hidden" accept="image/*" required>
              </div>
              <button type="button" onClick="triggerPhotoChange()" class="add-profile-image"><i class="ion-ios-camera"></i></button>
              <button disabled id="createAccount" type="submit" class="main-btn step-btn">finish creating your account</button>
              <a class="small-link back-link back-step3"><h3><i class="ion-android-arrow-back"></i>Back</h3></a>
          </div> 
        <?php echo Form::close(); ?>

        

        
        <div class="step login-step out">
          <?php echo Form::open(array('route' => 'do.login', 'data-toggle' => 'validator', 'method' => 'POST')); ?>

            <p class="tip">Use the form below to login</p>
            <div class="form-group">
              <label>Email or Username</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="ion-android-person"></i></span>
                <input type="text" class="form-control" id="loginUsername" name="email" placeholder="" value="<?php if(Session::has('username')): ?><?php echo e(Session::get('username')); ?><?php endif; ?>" data-error="A valid e-mail or username is required." required>
              </div>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
              <label>Password</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="ion-android-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="" data-error="Password is required." required >
              </div>
              <div class="help-block with-errors"></div>
            </div>
            <button class="main-btn" type="submit">Login</button>
            <a href="<?php echo e(URL::route('reset.password')); ?>" class="small-link forgot-link">Forgot your password?</a>
            <a class="small-link back-link back-to-reg">Don't have an account yet? Create one here</a>
            <a class="small-link back-link back-login"><h3><i class="ion-android-arrow-back"></i>Back</h3></a>
          <?php echo Form::close(); ?>

        </div>
		
		<div class="step twitter_login-step out">
          <?php echo Form::open(array('route' => array('auth.getSocialAuth', 'twitter'), 'data-toggle' => 'validator', 'method' => 'GET')); ?>

            <p class="tip">Use the form below to Twitter login</p>
            <div class="form-group">
              <label>Email</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="ion-android-person"></i></span>
                <input type="text" class="form-control" id="twit_Username" name="email" placeholder="" value="<?php if(Session::has('username')): ?><?php echo e(Session::get('username')); ?><?php endif; ?>" data-error="A valid e-mail or username is required." required>
              </div>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
              <label>Password</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="ion-android-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="" data-error="Password is required." required >
              </div>
              <div class="help-block with-errors"></div>
            </div>
            <button class="main-btn" type="submit">Twitter Login</button>
            <a class="small-link back-link back-login"><h3><i class="ion-android-arrow-back"></i>Back</h3></a>
          <?php echo Form::close(); ?>

        </div>
		
		
		<div class="step last-step out" data-ng-controller="RegisterController">
		<?php echo Form::open(array('name' => 'register_twitter', 'route' => 'register_twitter', 'method' => 'POST', 'files' => true, 'novalidate' => 'novalidate')); ?>

			<input type="hidden" maxlength="10" name="id_hidden" class="form-control" value="<?php if(Session::has('toggleLoginTwitter')): ?><?php echo e(Session::get('user_id')); ?><?php endif; ?>" placeholder="">
            <p class="tip"><?php echo e(Lang::get('messages.personalData')); ?></p>
			<?php if(Session::has('twit_user_data')): ?>
			<div class="form-group">
              <label>Twitter Username: <?php echo e(Session::get('twit_user_data')); ?></label>
            </div>
			<?php endif; ?>
            <div class="form-group">
              <label>Date of birth</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="ion-calendar"></i></span>
                <input type="text" id="twit_dob" name="dob" class="form-control" placeholder="">
              </div>
            </div>

            <div class="form-group">
              <label>Select your gender</label>
              <div class="input-group radio-group">
                <input type="radio" name="gender" id="twit_male" value="male">
                <label for="twit_male"><i class="ion-male"></i> Male</label>
                <input type="radio" name="gender" id="twit_female" value="female">
                <label for="twit_female"><i class="ion-female"></i> Female</label>
              </div>
              <div class="custom-help-block">Please select your gender.</div>
            </div>
            <div class="form-group">
              <label>Location</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="ion-ios-location"></i></span>
                <input type="text" id="twit_location" name="location" class="form-control" placeholder="">
                <input type="hidden" id="twit_lat" name="lat" placeholder="">
                <input type="hidden" id="twit_lng" name="lng" placeholder="">
              </div>
            </div>
              <!--<p class="tip">Add your profile image <br><span class="small">(optional)</span></p>
              <div class="form-group">
                <div class="img-preview">
                  <img src="" alt="<?php echo app('translator')->get('messages.uploadPreview'); ?>">
                </div>
                <?php echo $__env->make('components.cropperControls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                <input type="hidden" name="x" ng-model="addProfilePhoto['data'].x" />
                <input type="hidden" name="y" ng-model="addProfilePhoto['data'].y" />
                <input type="hidden" name="width" ng-model="addProfilePhoto['data'].width" />
                <input type="hidden" name="height" ng-model="addProfilePhoto['data'].height" />
                <input type="hidden" name="rotate" ng-model="addProfilePhoto['data'].rotate" />
                <input type="file" name="file" class="form-control hidden" accept="image/*" required>
              </div>
              <button type="button" onClick="triggerPhotoChange()" class="add-profile-image"><i class="ion-ios-camera"></i></button>-->
              <button disabled id="twit_createAccount" type="submit" class="main-btn step-btn">Complete Your Profile</button>
              <!--<a class="small-link back-link back-step3"><h3><i class="ion-android-arrow-back"></i>Back</h3></a>-->
			<?php echo Form::close(); ?>

          </div>
      </div>
    </div>
    <?php endif; ?>
  </section> 
  
  <section class="icons">
    <div class="block-flex wrap-flex space-around-flex">
      <div class="icon">
	  <i class="i_custom fa fa-gbp"></i>
	  <i class="i_custom ion-social-usd"></i>
	  <i class="i_custom ion-social-euro"></i>
	  <i class="i_custom ion-social-yen"></i>
        <!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><i class="ion i_custom fa fa-gbp"></i></div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><i class="i_custom ion-social-usd"></i></div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><i class="i_custom ion-social-euro"></i></div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><i class="i_custom ion-social-yen"></i></div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
	  </div>-->
        <h3>Fetish and Extra Cash</h3>
        <p>Meet likeminded people with an active interest in Financial Dominatrix (#Findom). You can also make extra money selling your images, videos and other personalised content free of charge, that means you get to keep 100% of any money you gain, as we do not take a percentage.</p>
      </div>
      <div class="icon">
        <i class="ion-chatboxes"></i>
        <h3>100% Free Messaging</h3>
        <p>Chat live with our members by sending direct messages at no cost. There is also no set limit on the amount of messages you can send or recieve each day. Communication is completely free and unrestricted when you use Casualstar.UK; just dont harass anyone!</p>
      </div>
      <div class="icon">
        <i class="ion-ios-people"></i>
        <h3>Dommes & Subs Worldwide</h3> 
        <p>We have a range of members from all around the world including but not limited to; Femdoms, Paypigs, and also the more passive users wanting to explore and have fun. Register for free and become an active member within our diverse community.</p>
      </div>
    </div>
  </section>

  <section class="security">
    <div class="block-flex wrap-flex space-between-flex vertical-center-flex">
       <h2><center>Get paid with almost any payment method.</center></h2>
        <div class="logo"><img src="/img/cashapps/cashapps.png" width="auto" height="35" alt="cashapps"/></div>
    <p>We use SSL web security to encrypt and protect your sensitive data - We aim to always improve, and provide the experience you deserve.</p>

   <!---  <div class="image">
        <img src="<?php echo e(URL::asset('img/webSecurity.jpg')); ?>" alt="security" >
      </div> -->
 
    </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>