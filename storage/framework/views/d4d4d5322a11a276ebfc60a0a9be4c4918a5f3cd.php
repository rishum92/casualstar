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
                    <div class="center_text">
                      <span>Vote for your  best looking female.
                      </span>
                      <br><br>
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
                <?php echo $__env->make('competition_users', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
               
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
<script>
function imagemodal(id){
 
 $.ajax({
   url: 'expand_image/'+id,
   type: 'GET',
  
   success: function(data){ 
 
     $('#imageModalId').modal('toggle');
    $('#myimgprofile').attr('src','img/competition_user/'+data[0].username+'/previews/'+data[0].user_profile);
   },
 });
}
</script>
<!--Add Image popup-->

<div class="modal fade" id="imageModalId" tabindex="-1" role="dialog">
 <input type = "hidden" id="hiddenuserid">


  <div class="modal-dialog" role="document">
    <div class="modal-content-centered" style="margin-right: 300px;">
       <img id="myimgprofile" style="width:100%;max-width:400px">
        <br/>
    </div>
  </div>
 

 
</div>
<!--Add Image popup-->

<!-- vote popup start -->

<script>
function confirm_vote_popup(id,competition_userid) {
 $('#modalcompetitionid').val(id);
 $('#competition_userid').val(competition_userid);
 $('#competition_username').val(competition_username);
 $('#exampleModal').modal('show');
}
</script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Click Vote Now, to confirm your vote.
      </div>
      <input type="hidden" name="modalcompetitionid" id="modalcompetitionid">
      <input type="hidden" name="competition_userid" id="competition_userid">
      <input type="hidden" name="competition_username" id="competition_username">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" data-dismiss="modal" target="" id="confirm_vote" value="1">Vote Now</button>
        <div>
          <span id = "messagedisplay" style = "display:none;">
            Thank you for voting. Username is now in position 23 in the competition.You also have one more vote remaining.
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- vote popup end -->
<script>
function deleteconfirmation(id) {
 $('#deleteconfirmationbtn').modal('show');
 $('#competitionid').val(id);
}
</script>


<!--Delete Confirmation Popup-->
<div class="modal fade" id="deleteconfirmationbtn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      Are you sure you want to delete this submission?
      </div>
      <input type="hidden" name="competitionid" id="competitionid">

      <div class="modal-footer">
        <button class="btn btn-primary" id="confirm_delete">Yes</button>
        <button class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<!--Delete Confirmation Popup End-->
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
                
        }
      });
    });
  // for confirmation vote
  $("#confirm_vote").click(function() {
    var confirm_vote = $("#confirm_vote").val();
    var competitionid = $("#modalcompetitionid").val(); 
    var competition_userid = $("#competition_userid").val();
    var competition_username = $("competition_username").val();
   
    $.ajax({
      url: 'confirm_vote',
      type: 'POST',
      data: {
              "_token" : "<?php echo e(csrf_token()); ?>",
              "confirm_vote"   : confirm_vote,
              "competitionid"   : competitionid,
              "competition_userid"   : competition_userid,
            },
      success:function(data)
      {
        $("#messagedisplay").css({"display":"block"});
        $(".wrap_prodiv").html(data);
        //location.reload();
      }
    });
  });

  //for confirmation delete

   $("#confirm_delete").click(function() {
    var competitionid = $("#competitionid").val();
       $.ajax({
        type: 'GET',
        url: 'competitiondelete/'+competitionid,
        
        success:function(data)
        {
          location.reload();
        }
       });
     });

   $("#amount_edit").blur(function() {
    var amount_edit = $("#amount_edit").val();
    var hidden_user_id = $("#hidden_user_id").val();
    alert(hidden_user_id);
      $.ajax({
        type: 'POST',
        url: 'amount_edit',
        data: {
                "_token"          : "<?php echo e(csrf_token()); ?>",
                "amount_edit"     : amount_edit,
                "hidden_user_id"  : hidden_user_id,
              },
        success:function(data)
        {
          //location.reload();
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