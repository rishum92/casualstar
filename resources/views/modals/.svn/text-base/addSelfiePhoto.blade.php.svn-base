
<div class="modal fade" id="addSelfiePhotoModal" tabindex="-1" role="dialog" aria-labelledby="addSelfiePhotoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="addSelfiePhoto" ng-submit="submitModal('addSelfiePhoto')" files="true" novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
          <h2>Add Verification Photo</h2>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="img-preview">
              <img src="" alt="@lang('messages.uploadPreview')">
            </div>
            @include('components.cropperControls')
            <label>Verification Photo</label>
            <input type="hidden" name="x" ng-model="addSelfiePhoto['data'].x" />
            <input type="hidden" name="y" ng-model="addSelfiePhoto['data'].y" />
            <input type="hidden" name="width" ng-model="addSelfiePhoto['data'].width" />
            <input type="hidden" name="height" ng-model="addSelfiePhoto['data'].height" />
            <input type="hidden" name="rotate" ng-model="addSelfiePhoto['data'].rotate" />
            <input type="hidden" name="type" ng-model="addSelfiePhoto['data'].type">
            <input type="file" name="file" ng-model="addSelfiePhoto['data'].file" class="form-control" accept="image/*" valid-file required>
          </div>
        </div>
        <div class="modal-footer"> 
          <button type="submit" ng-disabled="addSelfiePhoto.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input>
        </div>
      </form>
    </div>
  </div>
</div>

