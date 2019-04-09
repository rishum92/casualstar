<div class="modal fade" id="votepopupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Click Vote Now, to confirm your vote.
      </div>
      <input type="hidden" name="modalcompetitionid" id="modalcompetitionid">
      <input type="hidden" name="competition_userid" id="competition_userid">
      <input type="hidden" name="competition_username" id="competition_username">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" data-dismiss="modal" target="" id="confirm_vote" value="1">Vote Now</button>
      </div>
    </div>
  </div>
</div>