
<div class="modal fade" id="addPrivatePhotoModal" tabindex="-1" role="dialog" aria-labelledby="addPrivatePhotoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="addPrivatePhoto" ng-submit="submitModal('addPrivatePhoto')" files="true" novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
          <h2>Add a new private photo</h2>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="img-preview">
              <img src="" alt="@lang('messages.uploadPreview')">
            </div>
            @include('components.cropperControls')
            <label>Photo</label>
            <input type="hidden" name="x" ng-model="addPrivatePhoto['data'].x" />
            <input type="hidden" name="y" ng-model="addPrivatePhoto['data'].y" />
            <input type="hidden" name="width" ng-model="addPrivatePhoto['data'].width" />
            <input type="hidden" name="height" ng-model="addPrivatePhoto['data'].height" />
            <input type="hidden" name="rotate" ng-model="addPrivatePhoto['data'].rotate" />
            <input type="hidden" name="type" ng-model="addPrivatePhoto['data'].type">
            <input type="file" name="file" ng-model="addPrivatePhoto['data'].file" class="form-control" accept="image/*" valid-file required>
          </div>
          <div class="form-group">
            <label>Caption</label>
            <input type="text" name="title" ng-model="addPrivatePhoto['data'].title" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" ng-disabled="addPrivatePhoto.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input>
        </div>
      </form>
    </div>
  </div>
</div>

