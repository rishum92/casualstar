
<div class="modal fade" id="addCoverPhotoModal" tabindex="-1" role="dialog" aria-labelledby="addCoverPhotoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="addCoverPhoto" ng-submit="submitModal('addCoverPhoto')" files="true" novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
          <h2>Change cover photo</h2>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="img-preview">
              <img src="" alt="<?php echo app('translator')->get('messages.uploadPreview'); ?>">
            </div>
            <?php echo $__env->make('components.cropperControls', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <label>Cover photo</label>
            <input type="hidden" name="x" ng-model="addCoverPhoto['data'].x" />
            <input type="hidden" name="y" ng-model="addCoverPhoto['data'].y" />
            <input type="hidden" name="width" ng-model="addCoverPhoto['data'].width" />
            <input type="hidden" name="height" ng-model="addCoverPhoto['data'].height" />
            <input type="hidden" name="rotate" ng-model="addCoverPhoto['data'].rotate" />
            <input type="hidden" name="type" ng-model="addCoverPhoto['data'].type">
            <input type="file" name="file" ng-model="addCoverPhoto['data'].file" class="form-control" accept="image/*" valid-file required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" ng-disabled="addCoverPhoto.$invalid" class="main-btn stroke-btn form-btn"><i class="fa fa-check"></i></input>
        </div>
      </form>
    </div>
  </div>
</div>

