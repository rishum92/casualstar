<!-- Subscription Modal -->
<div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="subscribeModalLabel" data-ng-controller="PaymentController">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="subscribeModalLabel">Subscribe</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(array('name' => 'payment', 'route' => 'payment', 'method' => 'POST', 'novalidate' => 'novalidate')) !!}
          <p>Please select a payment plan</p>
          <p style="font-size:12px;">The equivalent amount 
&amp; currency will be converted to your own currency further in the process.</p>
          <div class="payment-plan">
            <div class="payment-options">
              @foreach($plans as $key => $plan)
                <div class="radio">
                  <label>
                    <input type="radio" name="plan" @if($key == 0) checked @endif id="m{{$key}}" value="{{$plan->id}}">
                    <span>{{$plan->name}}</span>
                    <b><span>
                      £{{ $plan->price}}
                    </span><br>
                     / month
                    </b>
                    <small>Billed in one payment of £{{ $plan->price * $plan->period}} <span>{{$plan->best_deal}}</span></small>
                  </label>
                </div>
              @endforeach  
            </div>
          </div>
          <div class="payment-data">
            <p>Payment method and details</p>
            <div class="form-group block-flex wrap-flex">
              <div class="card-type">
                <input type="radio" name="method" ng-init="method='paypal'" ng-model="method" id="paypal" checked value="paypal">
                <label for="paypal"><i class="fa fa-paypal" aria-hidden="true"></i>PayPal</label>
              </div>
              <div class="card-type">
                <input type="radio" name="method" ng-model="method" id="credit_card" value="credit_card">
                <label for="credit_card"><i class="fa fa-credit-card" aria-hidden="true"></i>Credit/Debit Card</label> 
              </div>
            </div>
            <div class="card-details" ng-hide="method == 'paypal'">
              <div class="form-group block-flex wrap-flex">
                <!-- <div class="card-type">
                  <input type="radio" name="card_type" id="visa" checked value="visa">
                  <label for="visa">Visa</label>
                </div>
                <div class="card-type">
                  <input type="radio" name="card_type" id="mastercard" value="mastercard"> 
                  <label for="mastercard">MasterCard</label>
                </div> -->
                <label for="card_type">Card type</label>
                <select ng-init="cardType=cardTypes[0].value" ng-model="cardType" class="form-control" name="card_type" ng-options="card.value as card.name for card in cardTypes"></select>
              </div>
              <div class="block-flex wrap-flex space-between-flex">
                <div class="form-group">
                  <label for="first_name">First name</label>
                  <input type="text" class="form-control" name="first_name" id="first_name" value="">
                </div>
                <div class="form-group">
                  <label for="last_name">Last name</label>
                  <input type="text" class="form-control" name="last_name" id="last_name" value="">
                </div>
              </div>
              <div class="block-flex wrap-flex space-between-flex">
                <div class="form-group">
                  <label for="number">Card number</label>
                  <!-- <input type="number" class="form-control" name="number" id="number" ng-model="card.number" cc-format cc-number > -->
                  <input type="text" maxlength="19" class="form-control" name="number" id="number" ng-model="card.number" name="cardNumber" cc-number cc-format cc-type="cardType" ng-required="true"/>
                </div>
                <div class="form-group">
                  <label for="cvv2">Card verification code (CVV2)</label>
                  <!-- <p>This can be found on the back of your card</p> -->
                  <input type="text" ng-model="card.cvc" cc-type="cardNumber.$ccType" ng-required="true" class="form-control" name="cvv2" cc-cvc id="cvv2" >
                </div>
              </div>
              <div class="block-flex wrap-flex space-between-flex">
                <div class="form-group">
                  <label for="expireMonth">Expiry month (MM)</label>
                  <input type="number" min=1 max=12 class="form-control" name="expireMonth" id="expireMonth" value="">
                </div>
                <div class="form-group">
                  <label for="expireYear">Expiry year (YYYY)</label>
                  <input type="number" min=2016 class="form-control" name="expireYear" id="expireYear" value="">
                </div>
              </div>
            </div>
            <button type="submit" class="main-btn">Subscribe</button>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>