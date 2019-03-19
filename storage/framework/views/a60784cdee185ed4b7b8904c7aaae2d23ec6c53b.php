<div class="modal fade" id="emailUserModal" tabindex="-1" role="dialog" aria-labelledby="emailUserModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="emailUser" ng-submit="submitModal('emailUser')" files="true" novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
          <h2>Email user</h2>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" ng-model="emailUser['data'].subject" required class="form-control">
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea type="text" name="message" ng-model="emailUser['data'].message" required class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" ng-disabled="emailUser.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input>
        </div>
      </form>
    </div>
  </div>
</div>