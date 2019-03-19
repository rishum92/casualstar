<!-- Modal -->
<div class="modal fade" id="addInterestModal" tabindex="-1" role="dialog" aria-labelledby="addInterestModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="addInterest" ng-submit="submitModal('addInterest')" files="true" novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
          <h2>Add Interest</h2>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" ng-model="addInterest['data'].name" class="form-control" pattern=".{1,}" required>
            <div ng-show="addInterest.name.$invalid && !addInterest.name.$pristine" class="help-block with-errors">Name is required</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" ng-disabled="addInterest.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input>
        </div>
      </form>
    </div>
  </div>
</div>