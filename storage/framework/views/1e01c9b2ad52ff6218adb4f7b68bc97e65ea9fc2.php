<?php $__env->startSection('meta'); ?>
  <title>PAY ME » CasualStar</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <script type="text/javascript">
    $("#username").on("keydown", function (e) {
        return e.which !== 32;
    });

    $("#username").on("change", function (e) {
        $("#username").val($("#username").val().replace(/ /g,''));  
    });
  </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>  

  <!-- Female only -->
  <div class="wrap">
    <div class="highlight">
     <center> Below are the members who have clicked your PAY ME button but may not have completed the process of tributing.</center>
    </div>
  </div>

  <section class="main subscription-main contact-main" data-ng-controller="SubscriptionController">
    <div class="wrap wrap-flex block-flex vertical-center-flex">
      <div class="table-responsive donation-table">
        <h3>PAY ME Attempts</h3>
        <table class="table">
          <thead>
            <tr>
              <th>Username</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat='user in donationAttempts'>
              <td>
                <a href="/users/[[user.username]]">
                  [[user.username]]
                </a>
              </td>
              <td>[[formatDate(user.attemptDate)]]</td>
            </tr>
          </tbody>
        </table>
        <p data-ng-if="donationAttempts.length == 0">No PAY ME attempts have been made yet.</p>

        <nav>
          <paging
          class="small pagination"
          page="pageDonationAttempts" 
          page-size="perPageDonationAttempts" 
          total="totalDonationAttempts"
          paging-action="changePageDonationAttempts(page, pageSize, total)">
          </paging>
        </nav>
      </div>
    </div>
  </section>

  <?php echo $__env->make('modals.payment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>