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

  <!-- Female only -->
  <div class="wrap">
    <div class="highlight">
      These are the members who have clicked your donation button but may not have completed the process. Why not start a conversation to find out if they have? And if so, don't forget to say thanks. <i class="ion-happy-outline"></i>
    </div>
  </div>

  @if(Auth::user()->gender == 'male')
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
              Donation
            </h1>
            <p>For help setting up your PayPal link click <a href="https://www.paypal.me">here</a></p>
            <p>For help setting up your Cash.me link click <a href="https://cash.me/cashtags">here</a></p>
          </div>
          <div class="sub-column xl-column">
            <p>My PayPal.me donation URL:</p>
            <p>Make sure your link is correct!</p>
            <p class="inline">https://www.paypal.me/</p>
            <p class="inline" e-form="editablePayPalUrl" e-maxlength="200" onbeforesave="update($data, 'paypal_url', user.id)" e-placeholder="Enter your PayPal.me URL" editable-text="user.paypal_url">
              [[user.paypal_url]]
              <button type="button" class="edit-button" ng-click="editablePayPalUrl.$show()" ng-hide="editablePayPalUrl.$visible"><i class="ion-edit"></i></button>
            </p><br>
            <p class="inline">https://www.cash.me/$</p>
            <p class="inline" e-form="editableCashMeUrl" e-maxlength="200" onbeforesave="update($data, 'cashme_url', user.id)" e-placeholder="Enter your Cash.me URL" editable-text="user.cashme_url">
              [[user.cashme_url]]
              <button type="button" class="edit-button" ng-click="editableCashMeUrl.$show()" ng-hide="editableCashMeUrl.$visible"><i class="ion-edit"></i></button>
            </p>
          </div>
        </div>
              <div class="table-responsive donation-table">
        <h3>Donation atempts</h3>
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
        <p data-ng-if="donationAttempts.length == 0">No donation attempts have been made yet.</p>

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
  @endif

  @include('modals.payment')
@endsection