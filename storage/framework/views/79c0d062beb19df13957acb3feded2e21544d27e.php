<?php //echo "<pre>";print_r($user->user_id}});die;?>
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
            <label>[[viewPhoto['data'].photo.title]]</label>
          </div>
          <div class="form-group likes">
            <!-- <h3>Likes</h3> -->
            [[formatLikes(photoLikes.length)]]
            <button type="button" class="edit-button" ng-click="likePhoto(viewPhoto['data'].photo)"><i class="[[getLikeIcon()]]"></i></button>
          </div>
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

