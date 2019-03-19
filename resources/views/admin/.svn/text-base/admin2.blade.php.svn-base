@extends('layouts.master')

@section('meta')
  <title>CasualStar</title>
@endsection

@section('scripts')
  
@endsection

@section('content') 
<div data-ng-controller="AdminController" data-ng-init="savedPageUsers={{$pageUsers}}">
  <section class="main admin-main">
    <div class="wrap">
      <div class="description">
        <h1>User Verification Control</h1><!--
        <h3>Online users: <b>[[onlineUsers]]</b> ([[onlineBots]] bots)</h3>
        <h3>Total users: <b>[[count]]</b></h3>-->
        <!-- <p>If you have any questions or issues please contact us using the form below.</p> -->
      </div>
      <!--<h3>Users</h3>-->
      <div class="table-responsive"><!--
        <input type="checkbox" ng-change="filterUsers()" data-ng-model="genderMale" name="gender" id="male" value="male">
        <label for="male"><i class="ion-male"></i> Male</label>
        <input type="checkbox" ng-change="filterUsers()" data-ng-model="genderFemale" name="gender" id="female" value="female">
        <label for="female"><i class="ion-female"></i> Female</label>-->
        <input type="text" class="form-control admin-search" ng-change="filterUsers('admin2')" ng-model-options="{ updateOn: 'default blur', debounce: {'default': 0, 'blur': 0, 'change': 0} }" ng-model="searchUsers" placeholder="Search for users">
        <table class="table">
          <thead> 
            <tr>
              <th>Username</th>
              <th>VerifyPhoto</th>
              <th>Uploaded Date</th>
              <th>Approved Date</th>
              <th>Status</th>
              <th>Approve</th>
              <th>Deny/Cancel</th>
              <th>Notes</th>
              <!--<th>Action</th>-->
            </tr>
          </thead>
          <tbody>
            <!--<tr ng-repeat='user in admin_users' data-ng-if="user.username != 'Admin'">-->
            <tr ng-repeat='user in admin_users'>
                
              <td><a href="/users/[[user.username]]"><i data-ng-show="user.title == 'ADMIN'" class="fa fa-key"></i><i data-ng-if="user.status == 0" class="fa fa-close"></i> [[user.username]] </a></td>
              <td>
				<a href="[[getVerifyPhotoUrl(user.verify_img, user)]]" class="lightGallery" title="[[user.username]]">
					<img data-ng-src="[[getVerifyPhotoPreviewUrl(user.verify_img, user)]]" class="thumb" alt="No Image" width="50" height="25" />
				</a>
				<button ng-if="user.verify_img!=NULL" mwl-confirm="" title="{{ Lang::get('Remove Photo?') }}" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="deleteSelfie(user)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false" class="btn btn-danger btn-xs pull-right"><span class="glyphicon glyphicon-remove"></span></button>
			  </td>
              <td>[[formatDateOnly(user.uploaded_at)]]</td>
              <td>[[formatDateOnly(user.verify_created_at)]]</td>
              <td>
			  <label ng-show="user.verify_check == 'None'" class="text-muted">No Request Found.</label>
			  <label ng-show="user.verify_check == 'PENDING'" class="text-muted">PENDING</label>
			  <label ng-show="user.verify_check == 'VERIFIED'" class="text-success">[[user.verify_check]]</label>
			  <label ng-show="user.verify_check == 'CANCELLED'" class="text-danger">[[user.verify_check]]</label>
			  </td>
			  <td>
			  <button ng-show="user.verify_check == 'None' || user.verify_check == 'CANCELLED' || user.verify_check == 'PENDING'" ng-click="approveUser(user)" class="btn btn-info">APPROVE</button>
			  <label ng-show="user.verify_check == 'VERIFIED'" class="text-success">[[user.verify_check]]</label>
			  </td>
			  <td>
			  <label ng-show="user.verify_check == 'None'">No Request Found.</label>
			  <label ng-show="user.verify_check == 'CANCELLED'">Request has been denied.</label>
			  <button ng-show="user.verify_check != 'CANCELLED' && user.verify_check != 'None'" ng-click="cancelUser(user)" class="btn btn-danger">CANCEL</button>
			  </td>
              <td>
					<label ng-show="user.verify_check == 'None'" class="item-action">Not Updated Yet.</label>
					<form name='myForm' novalidate >
						<textarea ng-show="user.verify_check != 'None'" name="text_notes" ng-model="text_notes" ng-init="text_notes=user.text_notes" ng-change="saveUpdates(user, text_notes)" style="resize:none;" class="form-control">[[user.text_notes]]</textarea>
					</form>
			  </td>
              <!--<td>
                <button ng-hide="user.status == -1" ng-click="lockUser(user)" class="item-action"><i class="fa fa-unlock"></i></button>
                <button ng-hide="user.status == 1 || user.status == 0" ng-click="unlockUser(user)" class="item-action"><i class="fa fa-lock checked"></i></button>
                <button ng-click="openModal('emailUser', 'user_id', user.id)" class="item-action"><i class="fa fa-envelope"></i></button>
				<button type="button" class="edit-button" mwl-confirm="" title="@lang('messages.deleteInterest')" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="deleteInterest(interest)" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="ion-trash-a"></i></button>
              </td>-->
            </tr>
          </tbody>
        </table>

        <nav>
          <paging
          class="small pagination"
          page="pageUsers" 
          page-size="perPageUsers" 
          total="totalUsers"
          paging-action="changeAdmin2Page(page, pageSize, total)">
          </paging>
        </nav>
      </div>
    </div>
    @include('modals.emailUser')
  </section>
</div>
@endsection