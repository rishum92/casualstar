<?php $__env->startSection('meta'); ?>
  <title>CasualStar</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?> 
<div data-ng-controller="AdminController">
  <section class="main admin-main">
    <div class="wrap">
      <div class="description">
        <h1>Admin</h1>
        <h3>Online users: <b>[[onlineUsers]]</b> ([[onlineBots]] bots)</h3>
        <h3>Total users: <b>[[count]]</b></h3>
        <!-- <p>If you have any questions or issues please contact us using the form below.</p> -->
      </div>
      <hr>
      <div class="table-responsive">
        <h3>Subscriptions</h3>
        <table class="table">
          <thead> 
            <tr>
              <th>Username</th>
              <th>E-mail</th>
              <th>Plan</th>
              <th>Payment method</th>
              <th>Start</th>
              <th>End</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat='subscription in subscriptions'>
              <td>
                <a href="/users/[[subscription.user.username]]">
                <i data-ng-show="subscription.user.status == 0" class="fa fa-close"></i>
                  [[subscription.user.username]]
                </a>
              </td>
              <td>[[subscription.user.email]]</td>
              <td>[[subscription.plan.name]]</td>
              <td>[[subscription.payment_method]]</td>
              <td>[[formatDate(subscription.created_at)]]</td>
              <td>[[formatDate(subscription.expires_at.date)]]</td>
              <td>
              <button type="button" class="item-action" mwl-confirm="" title="Cancel subscription?" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="deleteSubscription(subscription)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="ion-trash-a"></i></button>
              </td>
            </tr>
          </tbody>
        </table>

        <nav>
          <paging
          class="small pagination"
          page="pageSubscriptions" 
          page-size="perPageSubscriptions" 
          total="totalSubscriptions"
          paging-action="changePageSubscriptions(page, pageSize, total)">
          </paging>
        </nav>
      </div>
      <hr>
      <h3>Users</h3>
      <div class="table-responsive" ng-init="filterUsers()">
        <input type="checkbox" ng-change="filterUsers()" data-ng-model="genderMale" name="gender" id="male" value="male">
        <label for="male"><i class="ion-male"></i> Male</label>
        <input type="checkbox" ng-change="filterUsers()" data-ng-model="genderFemale" name="gender" id="female" value="female">
        <label for="female"><i class="ion-female"></i> Female</label>
        <input type="text" class="form-control admin-search" ng-change="filterUsers()" ng-model-options="{ updateOn: 'default blur', debounce: {'default': 500, 'blur': 0} }" ng-model="searchUsers" placeholder="Search for users">
        <table class="table">
          <thead> 
            <tr>
              <th>Username</th>
              <th>E-mail</th>
              <th>Gender</th>
              <th>Registered</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat='user in users' data-ng-if="user.username">
                
              <td><a href="/users/[[user.username]]"><i data-ng-show="user.title == 'ADMIN'" class="fa fa-key"></i><i data-ng-if="user.status == 0" class="fa fa-close"></i> [[user.username]] </a></td>
              <td>[[user.email]]</td>
              <td>[[user.gender]]</td>
              <td>[[formatDate(user.created_at)]]</td>
              <td>
                <button ng-hide="user.status == -1" ng-click="lockUser(user)" class="item-action"><i class="fa fa-unlock"></i></button>
                <button ng-hide="user.status == 1 || user.status == 0" ng-click="unlockUser(user)" class="item-action"><i class="fa fa-lock checked"></i></button>
                <button ng-click="openModal('emailUser', 'user_id', user.id)" class="item-action"><i class="fa fa-envelope"></i></button>
              </td>
            </tr>
          </tbody>
        </table>

        <nav>
          <paging
          class="small pagination"
          page="pageUsers" 
          page-size="perPageUsers" 
          total="totalUsers"
          paging-action="changePageUsers(page, pageSize, total)">
          </paging>
        </nav>
      </div>
    </div>
    <?php echo $__env->make('modals.emailUser', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </section>

  <section class="admin-interests">
    <div class="wrap">
    <ul class="block-flex wrap-flex">
      <li ng-repeat="interest in interests">
        <span class="editable-interest-name block-flex wrap-flex vertical-center-flex" e-form="editableInterestName" onbeforesave="updateInterestField($data, 'name', interest.id)" editable-text="interest.name">
          [[interest.name]]
          <div class="edit-hold">
            <button type="button" class="edit-button" ng-click="editableInterestName.$show()" ng-hide="editableInterestName.$visible">
            <i class="ion-edit"></i>
            </button>
            <button type="button" class="edit-button" mwl-confirm="" title="<?php echo app('translator')->get('messages.deleteInterest'); ?>" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="deleteInterest(interest)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="ion-trash-a"></i></button>
          </div>
        </span>
      </li>
    </ul>
    <button class="main-btn" ng-click="openModal('addInterest')"><i class="ion-ios-pricetags"></i> Add interest</button>
    
    </div>
    <?php echo $__env->make('modals.addInterest', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </section> 
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>