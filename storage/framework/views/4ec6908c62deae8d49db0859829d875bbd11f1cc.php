
<div class="modal fade" id="termsmodelModal" tabindex="-1" role="dialog" aria-labelledby="addPhotoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ion-android-close"></i>
        </button>
        <h2>Terms & Condition</h2>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <?php  if(Auth::check()) {?>
            <?php if(Auth::user()->username == 'Admin'): ?>
              <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
                <style type="text/css">
                  textarea, iframe{
                    display: block;
                    margin: 10px 0;
                  }
                  iframe{
                    width: 570px;
                    border: 1px solid #a9a9a9;
                  }
                </style>
                <script type="text/javascript">
                  function edittext(){
                    $('#editadmin').show();
                    $('#myframe').hide();
                  }
                  function updateIframe(){
                    var myFrame = $("#myframe").contents().find('body');
                    $('#editadmin').hide();
                    $('#myframe').removeAttr('style');
                    var textareaValue = $("#editadmin").val();
                    myFrame.html(textareaValue);
                    $.ajax({
                      type: 'POST',
                      url: 'terms_store/',
                      data: {
                              "_token"           : "<?php echo e(csrf_token()); ?>",
                              "textareaValue"    : textareaValue,
                            },
                      success:function(data)
                      {
                        //location.reload();
                      }
                    }); 
                  }
                </script>
                <textarea id="editadmin" name ="terms_condition" rows="8" cols="60" placeholder="Type HTML or text here...">
                <?php echo e($termscondition); ?>

                </textarea>
                <iframe id="myframe" style="display: none"></iframe>
                <div>
                  <i class="fa fa-pencil-square-o onclicktext" onclick="edittext()"></i>
                </div>
                <div class="margin-top-10">
                  <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="updateIframe()"> Submit 
                  </button>
                  <button type ="button" data-dismiss="modal" class = "btn btn-secondary"> Cancel </button>
                </div>
              <?php else: ?>
                <div>
                  <?php echo nl2br($termscondition);?>
                </div>
            <?php endif; ?>
          <?php } else {}?>
        </div>
      </div>
    </div>
  </div>
</div>

