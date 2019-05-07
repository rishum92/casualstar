@extends('layouts.master')


@section('meta')
  <title>Super Subs » CasualStar</title> 
@endsection

@section('content')

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
      <form class="inputform">
        <div class="form-group">
          <input placeholder="Search by username" type="text" id="search">
          <button class="btn_search" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>  
      </form>
    </div>
    <div class="center_text">
      <?php  if(Auth::check()) {?>
        @if(Auth::user()->username == 'Admin')
          <input class = "titlediv" type="text" id="competition_title"name = "competition_title" value="{{$get_title}}">
          <br />
          Expires:<input class = "inputfield" type="text" id="expiry"name = "expirydate" value="{{$showdate}}">GMT
        @else
          <input class = "titlediv" type="text" value="{{$get_title}}" readonly="true">
          <br />
          Expires:<input type="text" class = "inputfield" value = "{{$showdate}}"readonly="true">GMT
        @endif
      <?php } ?>
      </div>
        <?php  //echo"<pre>"  ; print_r($exists); die;
          if(Auth::check()) { ?>
            @if(Auth::user()->gender == 'female')
            <?php if(empty($exists) || date('d/m/Y') == $showdate)
            { ?>
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
                                    <img src="" alt="@lang('messages.uploadPreview')">
                                  </div>
                                  @include('components.cropperControls')
                                  <label>Photo</label>
                                  <input type="hidden" name="x" ng-model="addPhoto['data'].x" />
                                  <input type="hidden" name="y" ng-model="addPhoto['data'].y" />
                                  <input type="hidden" name="width" ng-model="addPhoto['data'].width" />
                                  <input type="hidden" name="height" ng-model="addPhoto['data'].height" />
                                  <input type="hidden" name="rotate" ng-model="addPhoto['data'].rotate" />
                                  <input type="hidden" name="type" ng-model="addPhoto['data'].type">
                                  <input type="file" name="file" ng-model="addPhoto['data'].file" class="form-control" accept="image/*" valid-file required>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" ng-disabled="addPhoto.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i>
                                </button>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <button type="button" data-ng-click="openModal('addPhoto')" class="page_btn"><i class="fa fa-camera"></i>Upload Photo</button>
                  </div>
                </center>            
              <?php } ?>
               @endif
            <?php } else {?>
              <center>
                <button type="button" onclick="newwin()" class="page_btn"><i class="fa fa-camera"></i>Upload Photo</button>
              </center>
            <?php } 
           ?>
            <!---Image Uploader Close-->
            <!--Competition User Div Start-->
           <?php //echo"<pre>"; print_r($total_voters_count); die; ?>
            <div class="wrap_prodiv" id="default_searched">
              @include('competition_users')
              <!--Competition User Div Close-->
            </div>
            <div class="wrap_prodiv" id="searched_data" style="display:none;">
              @include('competition_users_searched')
            </div>
            <div class="wrap_prodiv">
              <div style="font-size: 30px;text-align: center;" id = "notfound"></div>
            </div>
            
              <!--Terms and conditions -->
            <div>
              @include('modals.termsmodel')
                <button ng-controller = "UserCompetitionController" type="button" class = "page_btn" data-ng-click="openModal('termsmodel')">
                Terms & Conditions
                </button>
            </div>
            
                <!--Terms and conditions -->
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
          <a href = "{{url('/')}}" class = "page_btn"> Register </a>
          <a href = "{{url('/')}}" class = "page_btn"> Login </a>
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
    $('#myimgprofile').attr('src','img/competition_user/'+data[0].username+'/'+data[0].user_profile);
   },
 });
}

</script>
<!--Add Image popup-->
<link href="https://cdn.rawgit.com/sachinchoolur/lightgallery.js/master/dist/css/lightgallery.css" rel="stylesheet">
<div class="modal fade" id="imageModalId" tabindex="-1" role="dialog">
 <input type = "hidden" id="hiddenuserid">


  <div class="modal-dialog" role="document">
    <div class="modal-content-centered">
      <center>
        <img class = "imgpopup" id="myimgprofile">
      </center>
      <br/>
    </div>
  </div>
</div>
<!--Add Image popup-->

<!-- vote popup start -->
<script>
function confirm_vote_popup(id,competition_userid,username) {
 $('#modalcompetitionid').val(id);
 $('#competition_userid').val(competition_userid);
 $('#competition_username').val(username);
 // var username = $('#competition_username').val();
 // $('#thakyouforvote').text('Thankyou for voting '+username+'. You also have one more vote remaining.');
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
      <div class="modal-body" id="thakyouforvote">
        Click Vote Now, to confirm your vote.
      </div>
      <input type="hidden" name="modalcompetitionid" id="modalcompetitionid">
      <input type="hidden" name="competition_userid" id="competition_userid">
      <input type="hidden" name="competition_username" id="competition_username">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit"  class="btn btn-primary" data-dismiss="modal" target="" id="confirm_vote" onclick="message_popup()" value="1">Vote Now</button>
      </div> 
    </div>
  </div>
</div>
<!-- vote popup end -->
<script>
  function message_popup()
  {
    $('#messagepopupModal').modal('show');
    var username = $('#competition_username').val();
    $('#thankyoumessage').text('Thank you for voting '+username+'. You also have one more vote remaining.');
  }
</script>
<!--vote message popup start-->
<div class="modal fade" id="messagepopupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="messagepopupModal">Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="thankyoumessage">
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
        <button type="button" class="btn btn-primary" id="thakyoumsgrefresh" data-dismiss="modal">Ok</button>
      </div> 
    </div>
  </div>
</div>
<!--vote message popup end-->

<!--comment popup start-->
<?php //echo "<pre>";print_r($user);die;?>
<div class="modal fade" id="commentcompetitionModal" tabindex="-1" role="dialog" aria-labelledby="viewPhotoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="viewPhoto" files="true" novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
          
          <div class="userPhotoTitle">
            <a class="userImage" id="profile_username">
              <img id="img_profile"/>
            </a>
            &nbsp;&nbsp;
            <h3 id ="user_name">
            </h3>
          </div>
        </div>
        <div class="modal-body">
          <div class="explore-photo caption">
            <label></label>
          </div>
         <!--  <div class="form-group likes">
             <h3>Likes</h3>
            
            <button type="button" class="edit-button" ng-click="likePhoto(viewPhoto['data'].photo)"><i class="[[getLikeIcon()]]"></i></button>
          </div> -->
          <div class="messages">
            <div class="form-group right comments">
              <!-- <h3>Comments</h3> -->
              <!-- [[photoComments.length]] -->
              <input type="hidden" name="competition_user_id" id="competition_user_id">
              <input type="hidden" name="competition_id" id="competition_id">
              <form>
                <textarea id="comment" autocomplete="off" maxlength="300" name="commentmessage" class="form-control" placeholder="Type a comment here..."></textarea>
                <button type="button" id="postCommentButton" class="post-comment-btn form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input></button>
              </form>
              <ul class="conversation" id="demo_comment">
              </ul>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!--comment popup end-->
<script>
  $("#thakyoumsgrefresh").click(function() {
      location.reload();
    });
  
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
  $('#search').on('keyup',function(){
    var text = "";
    var norecord="";
    var auth_userid = $('#auth_userid').val();
    var auth_username = $('#auth_username').val();

    $value=$(this).val();
    if($value ==''){
      $('#default_searched').show();
    }
    $.ajax({
      type : "get",
      url : "{{ route('live_search.action')}}",
      data:{'search':$value},
      success:function(data){
        obj = JSON.parse(data);
        res = obj.response;
            if(data){
                if (obj.not_found !='Recordnotfound') {
                    $('#notfound').attr('style','display:none');
                    $('#default_searched').attr('style', 'display: none');
                    $('#searched_data').removeAttr('style');
                    $('#record_found').removeAttr('style');
                    for (i = 0; i < res.length; i++) 
                    {
        
                      text += '<li><div class="wrap_profile">'
                      if(res[i].total_votes >= 7)
                      {
                        text +='<div class="first_place">1<sup>st</sup></div>'
                        if(auth_username == 'Admin')
                        {
                          text +='<div class = "first_place_amount"><input type="hidden" name="hidden_user_id" id = "hidden_user_id" value ='+res[i].user_id+'>Wins:$<input type ="text" value="" id = "firstplace_amount"  class="edit_amount"></div>'
                        }
                        else
                        {
                          text +='<div class = "first_place_amount">Wins:$<input type ="text" value ="100" class="edit_amount" readonly = "true"> </div>'
                        }
                      }
                        else if(res[i].total_votes >= 5)
                        {
                          text +='<div class = "second_place">2<sup>nd</sup></div><div class="second_place_amount">Wins:$<input type ="text" value ="50" class="edit_amount" readonly = "true"></div>'
                        }
                        else if(res[i].total_votes >= 3)
                        {
                          text +='<div class="third_place">3<sup>rd</sup></div><div class ="third_place_amount">Wins:$<input type ="text" value ="25" class="edit_amount" readonly = "true"></div>'
                        }
                        text +='<div class="img-pro"><img onclick = "imagemodal('+res[i].user_id+')" src="img/competition_user/'+ res[i].username +'/previews/'+ res[i].user_profile +'"><br></div><div class="profile_content"><h1><a href="users/'+ res[i].username +'">' + res[i].username + '</a></h1><p>44 - High Wycombe, Bucking-hamshire</p><div class="like_block"><i class="fa fa-heart"></i>'+res[i].total_votes+'</div><div class="wrap_btn"><button class="page_btn" onclick = "confirm_vote_popup('+res[i].competition_id+','+res[i].user_id+')"><i class="fa fa-heart"></i> Vote Me</button><button class="page_btn" onclick = "profilecomment('+res[i].user_id+')" type="button"><i class="fa fa-comments"></i> Comments</button></div><div class="comment_count">'+res[i].total_comment+'</div><br>'
                        if(res[i].user_id == auth_userid || auth_username == 'Admin')
                          { 
                            text +='<div><i onclick = "deleteconfirmation('+res[i].competition_id+')" class = "fa fa-trash trash_btn"></i></div></div> </div></li>';
                          }
                    }
                    $('#record_found').html(text);
                  }
                  else {
                    $('#default_searched').hide();
                    $('#record_found').attr('style','display: none');
                    $('#notfound').attr('style','display:block');
                    norecord += 'No Record Found';
                    $('#notfound').html(norecord);
                  } 
            } else{
                $('#default_searched').hide();
                $('#record_found').attr('style','display: none');
                $('#notfound').attr('style','display:block');
                norecord += 'No Record Found';
                $('#notfound').html(norecord);
            }
        }
    });
  })
</script>
<!--Comment Delete Popup Start-->
<script>
function deletecomment(comment_id) {
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
<!--Comment Delete Popup End-->
<!--Comment Popup Script Start-->
<script>
  function profilecomment(user_id)
  {
    var comment = "";
    $('#commentcompetitionModal').modal('show');
    $.ajax({
      url: 'comment_user_data/'+user_id,
      type: 'GET',
      success: function(data){
        data = JSON.parse(data);
        //console.log(data);return false;
       // $('#commentcompetitionModal').modal('toggle');
        $('#img_profile').attr('src','img/users/'+data.user_data[0].username+'/previews/'+data.user_data[0].img);
        $('#user_name').text(data.user_data[0].username);
        $('#profile_username').attr("href","users/"+data.user_data[0].username);
        $('#competition_user_id').val(data.user_data[0].user_id);
        $('#competition_id').val(data.user_data[0].competition_id);
        for (i = 0; i < data.get_comment.length; i++)
        {
          var d = new Date(data.get_comment[i].created_at);
          var h = d.getHours(); 
          var m = d.getMinutes(); 
          var s = d.getSeconds();
          var dat = d.getDate(); 
          var mon = d.getMonth()+1;
          var yea = d.getFullYear();
          var newdateformat = h+":"+m+":"+s+" "+dat+"/"+mon+"/"+yea;
          comment +='<li class="message block-flex wrap-flex" class="partner"><div class="image"><a href="#"><img src="img/users/'+data.get_comment[i].username+'/previews/'+data.get_comment[i].img+'"/></a></div> <div class="text">'+data.get_comment[i].comment+'<span class="date-sent">'+newdateformat+'</span></div><button type="button" onclick = "deletecomment('+data.get_comment[i].id+')" class="edit-button"><i class="ion-trash-a"></i></button></li>';
        }
        $("#demo_comment").html(comment);
      }
    });
  }

</script>
<!--Comment Popup Script End -->
<!--Comment Delete Popup Start-->
<script>
function deletecomment(comment_id) {
 $('#deletecommentModal').modal('show');
 $('#comment_id').val(comment_id);
}
</script>


<!--Delete Comment Confirmation Popup-->
<div class="modal fade" id="deletecommentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      Are you sure you want to delete this comment?
      </div>
      <input type="hidden" name="comment_id" id="comment_id">

      <div class="modal-footer">
        <button class="btn btn-primary" id="comment_delete" data-dismiss="modal">Yes</button>
        <button class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<!--Comment Delete Popup End-->
<!--Comment Delete Ajax Start-->
<script>
  $("#comment_delete").click(function() {
    var comment_id = $("#comment_id").val();
      $.ajax({
        type: 'GET',
        url: 'delete_comment/'+comment_id,
        success:function(data)
        {
          location.reload();
        }
      });
    });
  </script>

<!--Comment Delete Ajax End-->

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
                "_token" : "{{ csrf_token() }}",
                "date"   : convertdate,
              },
        success:function(data)
        {
                
        }
      });
    });

   //change the title
  $("#competition_title").blur(function() {
    var title = $("#competition_title").val(); 
    $.ajax({
      url: 'edit_title',
      type: 'POST',
      data: {
              "_token" : "{{ csrf_token() }}",
              "title"   : title,
            },
      success:function(data)
      {
              
      }
    });
  }); 

  // for confirmation vote
//   $("#confirm_vote").click(function() {
//     var vote = "";
//     var confirm_vote = $("#confirm_vote").val();
//     var competitionid = $("#modalcompetitionid").val(); 
//     var competition_userid = $("#competition_userid").val();
//     var competition_username = $("#competition_username").val();
//     $.ajax({
//       url: 'confirm_vote',
//       type: 'POST',
//       data: {
//               "_token"              : "{{ csrf_token() }}",
//               "confirm_vote"        : confirm_vote,
//               "competitionid"       : competitionid,
//               "competition_userid"  : competition_userid,
//               "competition_username"  : competition_username,
//             },
//         success:function(data)
//         {   var obj = JSON.parse(data);
//             for(i =0; i < obj.competitionuser.data.length; i++){
//              vote +='<i class="fa fa-heart"></i>'+obj.competitionuser.data[i].total_votes;
//              //$("#increase_vote").html(vote);   
//             }
//             $("#increase_vote_ajax").html(vote);
//             $("#increase_vote_ajax").removeAttr("style");
//             $('#increase_vote').attr('style', 'display: none');
//              // $(".wrap_prodiv").html(data);
//         }
//     });
//   });
 
 // get
$("#confirm_vote").click(function() {
    var vote = "";
    var confirm_vote = $("#confirm_vote").val();
    var competitionid = $("#modalcompetitionid").val(); 
    var competition_userid = $("#competition_userid").val();
    var competition_username = $("#competition_username").val();
    $.ajax({
      url: 'confirm_vote/'+confirm_vote+'/'+competitionid+'/'+competition_userid+'/'+competition_username,
      type: 'GET',
        success:function(data)
        {   
            var obj = JSON.parse(data);
            //console.log(obj);
            // for(i =0; i < obj.competitionuser.data.length; i++){
            //  vote +='<i class="fa fa-heart"></i>'+obj.competitionuser.data[i].total_votes;
            //  //$("#increase_vote").html(vote);   
            // }
            vote +='<i class="fa fa-heart"></i>'+obj.uservotecount;
            $("#increase_vote_ajax_"+obj.competitionuserid).html(vote);
            $("#increase_vote_ajax_"+obj.competitionuserid).removeAttr("style");
            $('#increase_vote_'+obj.competitionuserid).attr('style', 'display: none');
            // location.reload();
             // $(".wrap_prodiv").html(data);
        }
    });
  });

  //for comment function
  $("#postCommentButton").click(function() {
    var comment_text = "";
    var comment = $("#comment").val();
    var competition_user_id = $("#competition_user_id").val(); 
    var competition_id = $("#competition_id").val();
    if(comment == ""){
        console.log("Please enter comments."); return false;
    }else{
        $.ajax({
            url: 'confirm_comment',
            type: 'POST',
            data: {
                  "_token"                : "{{ csrf_token() }}",
                  "comment"               : comment,
                  "competition_user_id"   : competition_user_id,
                  "competition_id"        : competition_id,
                },
            success:function(data)
                {
                //console.log(data);return false;
                $('#comment').val('');
                for (j = 0; j < data.length; j++)
                    {
                      var date = new Date(data[j].created_at);
                      var hour = date.getHours(); 
                      var min = date.getMinutes(); 
                      var sec = date.getSeconds();
                      var dat = date.getDate(); 
                      var mon = date.getMonth()+1;
                      var yea = date.getFullYear();
                      var dateformat = hour+":"+min+":"+sec+" "+dat+"/"+mon+"/"+yea;
                      comment_text +='<li class="message block-flex wrap-flex" class="partner"><div class="image"><a href="#"><img src="img/users/'+data[j].username+'/previews/'+data[j].img+'"/></a></div><div class="text">'+data[j].comment+'<span class="date-sent">'+dateformat+'</span></div><button type="button" onclick = "deletecomment('+data[j].id+')" class="edit-button"><i class="ion-trash-a"></i></button></li>';
                    }
                $("#demo_comment").html(comment_text);
                // location.reload();
                }
        });
    }
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
    
    // $("#first_place_amount").on('focus',"input#firstplace_amount", function() {
    //   console.log("on focus");
    // }).on('blur',"input#firstplace_amount", function() {
    //     console.log("on blur");
    // });
    
  //amount edit

  function firstplace_amount_fun(user_id) {

    var vote_amount = "";
    var hidden_user_id = user_id;
    var firstplace_amount = $("#firstplace_amount_"+hidden_user_id).val();
      $.ajax({
        type: 'GET',
        url: 'competition_vote_amount_edit/'+firstplace_amount+'/'+hidden_user_id,
        success:function(data)
        {   
          //  var obj = JSON.parse(data)
           // console.log(obj.competitionuservoteamount.vote_amount);firstplace_amount_ajax
           // $("#first_place_amount").val(obj.competitionuservoteamount.vote_amount);
            // vote_amount +='Wins:$<input type ="text" value ="'+obj.competitionuservoteamount.vote_amount+'" id = "firstplace_amount_ajax"  class="edit_amount">';
            // $("#firstplace_amount_ajax_"+hidden_user_id).html(vote_amount);
            // $("#firstplace_amount_ajax_"+hidden_user_id).removeAttr("style");
            // $("#first_place_amount").attr("style", "display: none");
        }
      });
    };


// Visitor Model Popup Script

function newwin() {

 $('#visitorpopupModal').modal('show');
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
<!--back top button start-->
<button class = "backtopbtn" onclick="scrollToTop()" id="scrollToTopButton"><i class="ion-arrow-up-a"></i></button>
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
<!--back top button close-->

@endsection