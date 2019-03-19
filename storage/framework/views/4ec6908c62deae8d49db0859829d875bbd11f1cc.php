
<div class="modal fade" id="termsmodelModal" tabindex="-1" role="dialog" aria-labelledby="addPhotoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form name="termsmodel" ng-submit="submitModal('termsmodel')" files="true" novalidate>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i></button>
          <h2>Terms & Condition</h2>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <?php  if(Auth::check()) {?>
             <?php if(Auth::user()->username == 'Admin'): ?>
              <textarea style = "border:none;" rows="8" cols="60" name = "edittext"><b>Participation</b>
Anyone is able to participate in the competition however, only verified Casualstar members can receive a prize payout, be it cash or otherwise. 
Verification can be done before, during or after competition has expired. 
Image submitted into any competition must be of the same user who the registered account belongs to. 
<b>Prizes</b>
 Prize and or rewards are subject to performance. A minimum of 100 votes are required in order to receive the 1st place payout prize.
 A minimum of 75 votes are required in order to receive the 2nd place payout prize. 
A minimum of 50 votes are required in order to receive the 3rd place payout prize. 
In addition to the above payout threshold, contestants from positions 4 to 10 will only receive prize for 10 or more votes, whenever a prize is available. 
<b>Winners</b>
If your one of the valid winners, once the competition is completed you don’t have to do anything; a member of the Casualstar team will contact you to discuss and arrange collection of your reward. 
<b>Payments</b>
Cash payout method will primarily be paid into your bank account.  
Payments will be transferred within 7 days after the expiration of the competition. However, the initial transfer may take longer if there needs to be an investigation for any reasons, relating to submitted content and or identity fakery. 
Any unverified user who is not verified has 7 days after the completion of the competition to submitting a valid verification request. If the 7 days passes with a valid verification submitted then that user forfeits their right to be rewarded the available prize on offer.  
<b>All rights reserved</b>
Casualstar reserve the right to adjust expiry dates, or end any active competition without prior notice to participants, if any unforeseen circumstances arise beyond Casualstar's control.
Casualstar reserve to right to withhold rewards from any contestant who does not fulfil any of the guidelines stated in the “Participation” and “Payments” sections above.
Casualstar reserve the right to at any time change or modify these terms and conditions, and any changes made shall be effective immediately upon posting/ update to this webpage.
The competition and these terms and conditions will be governed by [English] law and any disputes will be subject to the exclusive jurisdiction of the courts of [England].
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

