<?php $__env->startSection('meta'); ?>
  <title>Super Subs » CasualStar</title> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class = "com_banner">
    <div class = "container">
        <div class = "table_block">
            <div class = "table_cell">
                <h1>Competi<span>tions</span></h1>
            </div>
        </div>
    </div>    
</section>
<section class="compt_content">
    <div class="container">
        <div class="headeing_search">
            <h2>Featured <span>Profile</span></h2>
            <form class="inputform">
                <div class="form-group">
                  
                        <input  type="text"placeholder="Search here...">
                        <button class="btn_search" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                   
                </div>  
            </form>
                    <div style="text-align: center;font-weight:bold;color:#D61857;"><span>     Vote for your  best looking female.</span> <br><br>
                        <?php  if(Auth::check()) {?>
                            
                            <?php if(Auth::user()->username == 'Admin'): ?>
                            Expires:<input class = "inputfield" type="text" id="expiry"name = "expirydate" value="<?php echo e($showdate); ?>">GMT
                        <?php else: ?>
                            <input type="text" style = "border:none; "value = "<?php echo e($showdate); ?> GMT" readonly="true">
                        
                            <?php endif; ?>
                            
                             <?php } ?>
                    </div>

           <?php    
           if(Auth::check()) {
             if(empty($exists))
               { ?>
                <?php if(Auth::user()->gender == 'female'): ?>
                <!--Image Uploader Start-->
                <center>
                    <div ng-controller = "UserCompetitionController"> 
                        <div class="modal fade" id="addPhotoModal" tabindex="-1" role="dialog" aria-labelledby="addPhotoModal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form name="addPhoto" ng-submit="submitModal('addPhoto')" files="true" novalidate>
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i>
                                            </button>
                                                <h2>Add a new photo</h2>
                                        </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <div class="img-preview">
                                                        <img src="" alt="<?php echo app('translator')->get('messages.uploadPreview'); ?>">
                                                    </div>
                                            <?php echo $__env->make('components.cropperControls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                <label>Photo</label>
                                                <input type="hidden" name="x" ng-model="addPhoto['data'].x" />
                                                <input type="hidden" name="y" ng-model="addPhoto['data'].y" />
                                                <input type="hidden" name="width" ng-model="addPhoto['data'].width" />
                                                <input type="hidden" name="height" ng-model="addPhoto['data'].height" />
                                                <input type="hidden" name="rotate" ng-model="addPhoto['data'].rotate" />
                                                <input type="hidden" name="type" ng-model="addPhoto['data'].type">
                                                <input type="file" name="file" ng-model="addPhoto['data'].file" class="form-control" accept="image/*" valid-file required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Caption</label>
                                                        <input type="text" name="title" ng-model="addPhoto['data'].title" maxlength=100 class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" ng-disabled="addPhoto.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <button type="button" data-ng-click="openModal('addPhoto')" class="page_btn"><i class="fa fa-camera"></i>Upload Photo</button>
                </div>
            </center>            
                <?php endif; ?>

               <?php }
               
           }
            else {?>
                 <center>
                  <button type="button" onclick="newwin()" class="page_btn"><i class="fa fa-camera"></i>Upload Photo</button>
                </center>
               <?php } 
           ?>



           <!---Image Uploader Close-->
           <!--Competition User Div Start-->

            <div class="wrap_prodiv">
                <ul class="profil_ul">
                    <?php //echo"<pre>"; print_r($competitionuser); die; ?>
                   <?php if(empty($competitionuser)): ?> 
                    <div style = "font-style: 20px;">
                        There is currently no active competitions.
                    </div>
                    <?php else: ?>
                    <?php foreach($competitionuser as $user): ?>
                        <li>
                            <?php if(!Auth::user()): ?>
                                <div class="wrap_profile" onclick = 'newwin()'>
                                    <div style = "font-style: 20px;">
                                        1st
                                    </div>
                                    <div class="img-pro">
                                        <img src="<?php echo e(URL::asset('img/competition_user/'.$user->username.'/previews/'.$user->user_profile)); ?>"><br/>
                                    </div>
                                    <div class="profile_content">
                                        <h1><a> <?php echo e($user->username); ?></a></h1>
                                  
                                        <p>44 - High Wycombe, Bucking-hamshire</p>
                                        <div class="like_block"><i class="fa fa-heart"></i> 203
                                        </div>
                                        <div class="wrap_btn">
                                            <button class="page_btn" type="button">
                                                <i class="fa fa-heart"></i> Vote Me
                                            </button>
                                            <div>
                                            <button class="page_btn" type="button"><i class="fa fa-comments"></i> Comments
                                            </button>
                                        </div> 
                                    </div>
                                </div>
                            <?php else: ?>
                              <div ng-controller = "UserCompetitionController"> 
                            <div class="wrap_profile">
                                    <?php if($user->competition_id == 1): ?>
                                        <div style="font-size: 24px;color: #FFC300;font-weight: bold;"><?php echo e($user->competition_id); ?><sup>st</sup></div>
                                        <?php elseif($user->competition_id == 2): ?>
                                        <div style="font-size: 24px;color: grey;font-weight: bold;"><?php echo e($user->competition_id); ?><sup>nd</sup></div>
                                        <?php elseif($user->competition_id == 3): ?>
                                        <div style="font-size: 24px;color:#EC7063;font-weight: bold;"><?php echo e($user->competition_id); ?><sup>rd</sup></div>
                                        <?php else: ?>
                                        <div style="font-size: 24px;color:#d61857;font-weight: bold;">#<?php echo e($user->competition_id); ?></div>
                                        <?php endif; ?>
                                    <div class="img-pro">
                                        <img src="<?php echo e(URL::asset('img/competition_user/'.$user->username.'/previews/'.$user->user_profile)); ?>">
                                        <br/>
                                    </div>
                                    <div class="profile_content">
                                        <h1><a href = "<?php echo e((url('/'))); ?>"> <?php echo e($user->username); ?></a></h1>
                                  
                                        <p>44 - High Wycombe, Bucking-hamshire</p>
                                        <div class="like_block"><i class="fa fa-heart"></i> 203
                                        </div>
                                        <div class="wrap_btn">
                                            <button class="page_btn" type="button">
                                                <i class="fa fa-heart"></i> Vote Me
                                            </button>
                                            <?php echo $__env->make('modals.commentcompetition', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            <button ng-controller = "CommentController"
                                            data-ng-click="viewThisPhoto(<?php echo e($user->user_id); ?>)"
                                            class="page_btn" type="button"><i class="fa fa-comments"></i>Comments
                                            </button>
                                        </div> 
                                    </div>
                                    <a href = "<?php echo e(url('competitiondelete/'.$user->competition_id)); ?>" class = "page_btn delbtn"> Delete</a>
                                </div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div>
                    <?php echo e($competitionuser->links()); ?>

                </div>
                <!--Competition User Div Close-->
                <!--Terms and conditions -->
                <div>
                    <?php echo $__env->make('modals.termsmodel', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <button ng-controller = "UserCompetitionController" type="button" class = "page_btn" data-ng-click="openModal('termsmodel')">
                        Terms & Conditions
                    </button>
                </div>
                <div class="scroll-top scroll-is-not-visible" style = "float:right;">
                    <a href="javascript:" id ="return-to-top"><i style = "font-size: 30px; color:#d61857;" class="fa fa-chevron-up" aria-hidden="true"></i></a>
                </div>
                <!--Terms and conditions -->
            </div>
        </div>
    </div>
</section>
<!--VisitorPopup Modal-->
<div class="modal fade" id="visitorpopupModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="visitorpopup" files="true" novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
          <h2>Register</h2>
        </div>
        <div class="modal-body">
          <p>Please register or login to access all functions on our member’s only website. <span style="font-weight:bold;"> Registration only takes about 1 Minute.</span></p><br />
          <a href = "<?php echo e(url('/')); ?>" class = "page_btn"> Register </a>
          <a href = "<?php echo e(url('/')); ?>" class = "page_btn"> Login </a>
        </div>
      </form>
    </div>
  </div>
</div>
<!--VisitorPopup Modal-->

<!--Add Image popup-->
<script>
function imagemodal(id) {
 $('#hiddenuserid').val(id);
 $('#imageModalId').modal('show');
}
</script>
<div class="modal fade" id="imageModalId" tabindex="-1" role="dialog">
 <input type = "hidden" id="hiddenuserid">

 <?php foreach($competitionuser as $user): ?>
 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <img  src="<?php echo e(URL::asset('img/competition_user/'.$user->username.'/previews/'.$user->user_profile)); ?>">
        <br/>
    </div>
  </div>
  
  <?php endforeach; ?>
</div>
<!--Add Image popup-->

<!--Add Photo-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<script type="text/javascript">
  $(document).scroll(function() {
var y = $(window).height();
var s=$(window).scrollTop();
if (s >= y) {
  $('.scroll-a').fadeIn();
} else {
  $('.scroll-a').fadeOut();
}
});
</script>

<!--Change Expiry Date -->
<script>
    $("#expiry").blur(function() {
        var date = $("#expiry").val(); 
        var convertdate = date.split("/").reverse().join("-");
            $.ajax({
                        url: 'editdate',
                        type: 'POST',
                        data: {
                                "_token" : "<?php echo e(csrf_token()); ?>",
                                "date"   : convertdate,
                              },                       
                        success:function(data)
                          {
                            alert(data);
                          }
                       });
   });

</script>
<!--Change Expiry Date -->
<!--Visitor Model Popup Script -->
<script>

function newwin() {

 $('#visitorpopupModal').modal('show');
}
//Visitor Model Popup Start

//ImagePopup Script Start
function imagemodal(id) {
 $('#hiddenuserid').val(id);
 $('#imageModalId').modal('show');
}
</script>
<!--Image Popup Script Close-->
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
    var modal = $('#imageModalId');

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
    $('#return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 500);
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>