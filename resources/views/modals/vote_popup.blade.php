
<div class="modal fade" id="vote_popupModal" tabindex="-1" role="dialog" aria-labelledby="addPhotoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i>
        </button>
        <h2>Vote Confirmation</h2>
      </div>
      <div class="modal-body">
        Click Vote Now, to confirm your vote.
      </div>
      <script>
      $("#confirm_vote").click(function() {
        var confirm_vote = $("#confirm_vote").val();
        var competitionid = $("#modalcompetitionid").val(); 
        var competition_userid = $("#competition_userid").val();
        var competition_username = $("competition_username").val();
        $.ajax({
        url: 'confirm_vote',
        type: 'POST',
        data: {
              "_token"              : "{{ csrf_token() }}",
              "confirm_vote"        : confirm_vote,
              "competitionid"       : competitionid,
              "competition_userid"  : competition_userid,
            },
        success:function(data)
        {
          $("#messagedisplay").removeAttr("style");
          //$("#messagedisplay").css({"display":"block"});
          $(".wrap_prodiv").html(data);
          //location.reload();
        }
      });
    });
  </script>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" data-dismiss="modal" target="" id="confirm_vote" value="1">Vote Now</button>
      </div>
    </div>
  </div>
</div>

