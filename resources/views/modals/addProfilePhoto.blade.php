
<div class="modal fade" id="addProfilePhotoModal" tabindex="-1" role="dialog" aria-labelledby="addProfilePhotoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="addProfilePhoto" ng-submit="submitModal('addProfilePhoto')" files="true" novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
          <h2>Change profile photo</h2>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="img-preview">
              <img src="" alt="@lang('messages.uploadPreview')">
            </div>
            @include('components.cropperControls')
            <label>Profile photo</label>
            <input type="hidden" name="x" ng-model="addProfilePhoto['data'].x" />
            <input type="hidden" name="y" ng-model="addProfilePhoto['data'].y" />
            <input type="hidden" name="width" ng-model="addProfilePhoto['data'].width" />
            <input type="hidden" name="height" ng-model="addProfilePhoto['data'].height" />
            <input type="hidden" name="rotate" ng-model="addProfilePhoto['data'].rotate" />
            <input type="hidden" name="type" ng-model="addProfilePhoto['data'].type">
            <input type="file" name="file" ng-model="addProfilePhoto['data'].file" class="form-control" accept="image/*" valid-file required>
          </div>
        </div>
        <div class="modal-footer"> 
          <button type="submit" ng-disabled="addProfilePhoto.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input>
        </div>
      </form>
    </div>
  </div>
</div>

