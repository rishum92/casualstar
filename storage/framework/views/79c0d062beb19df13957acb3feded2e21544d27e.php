
<div class="modal fade" id="viewPhotoModal" tabindex="-1" role="dialog" aria-labelledby="viewPhotoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="viewPhoto" ng-submit="submitModal('viewPhoto')" files="true" novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
          
          <div class="userPhotoTitle">
            <a class="userImage" href="/users/[[viewPhoto['data'].photo.user.username]]?explore=true">
              <img data-ng-src="[[getUserPhoto(viewPhoto['data'].photo.user)]]" alt="[[viewPhoto['data'].photo.user.username]]" />
            </a>
            &nbsp;&nbsp;
            <h2>
              [[viewPhoto['data'].photo.user.username]]
            </h2>
          </div>
        </div>
        <div class="modal-body">
          <div class="explore-photo">
            <a href="users/[[viewPhoto['data'].photo.user.username]]?explore=true"><img ng-src="[[getPhotoUrl(viewPhoto['data'].photo)]]" alt="user photo" /></a>
          </div>
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
              <form data-ng-submit="postComment(viewPhoto['data'].photo)">
                <textarea data-ng-model="comment" maxlength="750" enter="postComment(viewPhoto['data'].photo)" shift class="form-control" placeholder="Type a comment here..."></textarea>
          <button ng-disabled="comment.length == 0" type="button" id="postCommentButton" ng-click="postComment(<?php echo e($user->user_id); ?>)" ng-disabled="viewPhoto.$invalid" class="post-comment-btn form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input></button>
              </form>
              <ul class="conversation">
                <li class="message block-flex wrap-flex" data-ng-class="partner" data-ng-repeat="comment in photoComments">
                  <div class="image">
                    <a ng-if="comment.user.id != user.id" href="/users/[[comment.user.username]]?explore=true">
                      <img data-ng-src='[[getCommentUserPhoto(comment)]]' alt="[[comment.user.username]]" />
                    </a>
                    <img ng-if="comment.user.id == user.id" data-ng-src='[[getCommentUserPhoto(comment)]]' alt="[[comment.user.username]]" />
                  </div>
                  <div class="text">
                    [[comment.text]]
                    <span class="date-sent">[[comment.posted]]</span> 
                  </div>
                  <button type="button" ng-if="user.id == comment.user.id" class="edit-button" mwl-confirm="" title="Remove comment?" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="deleteComment(viewPhoto['data'].photo, comment.id)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false; pauseRefresh($event)"><i class="ion-trash-a"></i></button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

