<div class="modal fade" id="compitionModal" tabindex="-1" role="dialog" aria-labelledby="compitionModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="compition" ng-submit="submitModal('compition')" files="true" novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
          <h2>Add Compition</h2>
        </div>
        <div class="modal-body">
          <div class="form-group">
          <input type="hidden" name="user_id" ng-model="compition['data'].id" class="form-control">
            <label>Title</label>
            <input type="text" name="subject" ng-model="compition['data'].subject" class="form-control">
          </div>
          <div class="form-group">
            <label>Short Description</label>
            <textarea type="text" name="message" ng-model="compition['data'].description" class="form-control"></textarea>
          </div>
          <div class="form-group">
              <label>Expiry Date</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="ion-calendar"></i></span>
                <input type="text" id="expiry" name="expiry" ng-model="compition['data'].expiry" class="form-control" placeholder="">
              </div>
            </div>
          <div class="form-group">
            <label>Price Amount</label>
            <input type="text" name="price" ng-model="compition['data'].price"  class="form-control"></input>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" ng-disabled="compition.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input>
        </div>
      </form>
    </div>
  </div>
</div>