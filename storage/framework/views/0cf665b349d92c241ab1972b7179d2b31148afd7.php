
<div class="modal fade" id="termsmodelModal" tabindex="-1" role="dialog" aria-labelledby="addPhotoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="termsmodel" ng-submit="submitModal('termsmodel')" files="true"      novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
          <h2>Terms & Condition</h2>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <?php  if(Auth::check()) {?>
             <?php if(Auth::user()->username == 'Admin'): ?>
              <textarea style = "border:none;" rows="8" cols="60" name = "edittext">This is the terms and condition
              </textarea>
              <?php else: ?>
              <textarea style = "border:none;" rows="8" cols="60" readonly>This is the terms and condition
              </textarea>
            <?php endif; ?>
          <?php } else {}?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" ng-disabled="termsmodel.$invalid" class="form-btn main-btn stroke-btn"><i class="fa fa-check"></i></input>
        </div>
      </form>
    </div>
  </div>
</div>

