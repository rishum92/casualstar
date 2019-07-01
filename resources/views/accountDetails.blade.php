@extends('layouts.master')

@section('meta')
  <title>Account Details » CasualStar</title>
@endsection

@section('scripts')
  <script type="text/javascript">
    $("#username").on("keydown", function (e) {
        return e.which !== 32;
    });

    $("#username").on("change", function (e) {
        $("#username").val($("#username").val().replace(/ /g,''));  
    });
  </script>
@endsection

@section('content')  
  @if(Auth::user()->gender == 'male' && true == false)
    <section class="main subscription-main contact-main">
      <div class="wrap wrap-flex block-flex vertical-center-flex">
        <div class="description block-flex wrap-flex">
          <div class="sub-column">
            <h1>
              Account details 
            </h1>
          </div>
            <div class="sub-column hidden">
              <p><span>Account type:</span> @if($subscribed == 1) Premium @else Standard @endif</p>
              @if($subscribed == 1)
                <p><span>Order</span> #{{$orders[0]->id}}</p>
                <p><span>Plan:</span> {{$orders[0]->plan->name}}</p>
                <p><span>Payment method:</span> {{$orders[0]->payment_method}}</p>
                <p><span>Start date:</span> {{date("d/m/Y", strtotime($orders[0]->created_at))}}</p>
                <p><span>End date:</span> {{date("d/m/Y", strtotime($orders[0]->created_at->addMonth($orders[0]->plan->period)))}}</p>
              @else
                <button type="button" class="main-btn" data-toggle="modal" data-target="#subscribeModal">Upgrade account type</button>
              @endif
            </div>
        </div>
      </div>
    </section>
  @else
    <section class="main subscription-main contact-main" data-ng-controller="SubscriptionController">
      <div class="wrap wrap-flex block-flex vertical-center-flex">
        <div class="description block-flex wrap-flex">
          <div class="sub-column">
            <h1>
              Account Details
            </h1>
            <hr/>
            .....
            <br>
            <hr/>
            <h2>Activate your profile page PAY ME button below:</h2>
            <hr/>
            <p>Once you have added your links below, your PAY ME button will appear on your profile page. Make sure each link is correct.</p>
          </div>
          <div class="sub-column xl-column">
            <p><h3>Complete your PayPal.me URL (End bit only):</h3></p>
            <p class="inline">https://www.paypal.me/</p>
            <p class="inline" e-form="editablePayPalUrl" e-maxlength="200" onbeforesave="update($data, 'paypal_url', user.id)" e-placeholder="Complete the ending" editable-text="user.paypal_url">
              [[user.paypal_url]]
              <button type="button" class="edit-button" ng-click="editablePayPalUrl.$show()" ng-hide="editablePayPalUrl.$visible"><i class="ion-edit"></i></button>
            </p><br><br>
            <p><h3>Complete your Cash.me URL (End bit only -- $ or £):</h3></p>
            
            <span ng-hide="user.cashme_url_uk && user.cashme_url_uk != ''">
              <p class="inline">https://www.cash.me/$</p>
              <p class="inline" e-form="editableCashMeUrl" e-maxlength="200" onbeforesave="update($data, 'cashme_url', user.id)" e-placeholder="Complete the ending" editable-text="user.cashme_url">
                [[user.cashme_url]]
                <button type="button" class="edit-button" ng-click="editableCashMeUrl.$show()" ng-hide="editableCashMeUrl.$visible"><i class="ion-edit"></i></button>
              </p>
            </span>

            <span ng-hide="user.cashme_url && user.cashme_url != ''">
              <p class="inline">https://www.cash.me/£</p>
              <p class="inline" e-form="editableCashMeUrlUk" e-maxlength="200" onbeforesave="update($data, 'cashme_url_uk', user.id)" e-placeholder="Complete the ending" editable-text="user.cashme_url_uk">
                [[user.cashme_url_uk]]
                <button type="button" class="edit-button" ng-click="editableCashMeUrlUk.$show()" ng-hide="editableCashMeUrlUk.$visible"><i class="ion-edit"></i></button>
              </p>
            </span>
            <br>
<br>
            <p><h3>Another Method:</h3></p>
            <p>Enable this option to accept payments by any other methods: <u>Recommended</u>.</p>
            <div ng-if="user.alt_url == 0">
              <input id="alt_url" ng-checked="false" type="checkbox" name="altUrl">
              <label for="alt_url" ng-click="update(1, 'alt_url', user.id)">Disabled: Click to enable.</label>
            </div>
            <div ng-if="user.alt_url == 1">
              <input id="alt_url" ng-model="altUrl" type="checkbox" name="altUrl" ng-checked="true">
              <label for="alt_url" ng-click="update(0, 'alt_url', user.id)">Enabled</label>
            </div>
          </div><div>
          <br/><br/>
          <p>For help setting up your PayPal.me link click <a target="_blank" href="https://www.paypal.me"><h3>here.</h3></a></p>
            <p>For help setting up your Cash.me link click <a target="_blank" href="https://cash.me/cashtags"><h3>here.</h3></a></p>
          </div>
 <div>
            <hr/>
            <p>We understand there is a wide range of payment methods available, therefore we encourage users to exchange any other preferred methods of completing payments, inside the private messaging system.</p>
          </div>
        </div>
      </div>
    </section>
  @endif

  @include('modals.payment')
@endsection