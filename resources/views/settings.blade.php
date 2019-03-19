@extends('layouts.master')

@section('meta')
  <title>Dashboard | CasualStar</title>
@endsection

@section('content')

  <!-- Female only -->
  <div class="wrap hidden " data-ng-if="user.gender == 'female'">
    <div class="highlight">
      You’re more likely to get a date or donations if you verify your account <i class="ion-happy-outline"></i>
    </div>
  </div>

  <div data-ng-controller="SettingsController">
    <section class="edit-profile">
      <div class="wrap block-flex wrap-flex space-between-flex">
        <div class="column">
          <div data-ng-if="user.img">
            <h2>Remove profile picture</h2>
            <div>
              <button type="button" class="item-action main-btn stroke-btn remove-profile-photo" mwl-confirm="" title="Remove profile photo?" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="deleteProfilePhoto()" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false"><i class="ion-trash-a"></i> remove</button>
            </div>
            <br><br>
          </div>
          <div data-ng-if="user.social == 0">
            <h2>Change password</h2> 
            <form data-ng-submit="changePassword()">
              <div class="form-group">
                <label>Current password</label> 
                <div class="input-group">
                  <span class="input-group-addon"><i class="ion-android-lock"></i></span>
                  <input type="password" name="oldPassword" id="oldPassword" ng-model="oldPassword" class="form-control" placeholder="">
                </div>
              </div>
              <br>
              <div class="form-group">
                <label>New password</label> 
                <div class="input-group">
                  <span class="input-group-addon"><i class="ion-android-lock"></i></span>
                  <input type="password" name="password" id="password" ng-model="password" class="form-control" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label>Confirm new password</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="ion-android-lock"></i></span>
                  <input type="password" name="password_confirmation" id="password_confirmation" ng-model="password_confirmation" class="form-control" placeholder="">
                </div>
              </div>
              <button type="submit" class="main-btn stroke-btn">change password</button>
            </form>
          </div>
        </div>
        <div class="column">
          <h2>Update contact details</h2>
          <form data-ng-submit="updateEmail()">
            <div class="form-group">
              <label>E-mail</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="ion-email"></i></span>
                <input type="email" class="form-control" ng-model="email">
              </div>
            </div>
            <button type="submit" class="main-btn stroke-btn">update</button>
          </form>
        </div>
        <div class="column cancel-account">
          <h2>Close account</h2>
          <div class="box" data-ng-controller="LiveController">
            <p>Your account can be reactivated at anytime by loging in.</p>
            <button type="button" class="main-btn stroke-btn" mwl-confirm="" title="{{ Lang::get('messages.closeAccount') }}?" message="" confirm-text="<i class='ion-android-done'></i>" cancel-text="<i class='ion-android-close'></i>" placement="top" on-confirm="closeAccount()" on-cancel="vm.cancelClicked = true" confirm-button-type="danger" cancel-button-type="default" ng-click="vm.confirmClicked = false; vm.cancelClicked = false">{{ Lang::get('messages.closeAccount') }}</button>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection