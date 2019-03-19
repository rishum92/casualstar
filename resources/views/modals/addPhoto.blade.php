
<div class="modal fade" id="addPhotoModal" tabindex="-1" role="dialog" aria-labelledby="addPhotoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="addPhoto" ng-submit="submitModal('addPhoto')" files="true" novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
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
          <div class="form-group">
            <label>Caption</label>
            <input type="text" name="title" ng-model="addPhoto['data'].title" maxlength=100 class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" ng-disabled="addPhoto.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input>
        </div>
      </form>
    </div>
  </div>
</div>

