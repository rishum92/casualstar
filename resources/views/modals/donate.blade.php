<!-- Subscription Modal -->
<div class="modal fade" id="donateModal" tabindex="-1" role="dialog" aria-labelledby="donateModalLabel" data-ng-controller="PaymentController">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
        <h4 class="modal-title" id="donateModalLabel">PAY ME</h4>
      </div>
      <div class="modal-body">
          <div class="payment-data">
            <p>Please select a PAY ME method</p>
            <br>
            <div class="form-group block-flex wrap-flex">
              @if(isset($user->paypal_url) && $user->paypal_url != '')
                <img id="paypalDonation" src="/img/paypal.png" alt="paypal">
                &nbsp;&nbsp;&nbsp;
                <a target="_blank" href="https://www.paypal.me/{{$user->paypal_url}}">https://www.paypal.me/{{$user->paypal_url}}</a>
              @endif
            </div>

            @if((isset($user->paypal_url) && $user->paypal_url != '') && (isset($user->cashme_url) && $user->cashme_url != ''))
              <div class="form-group block-flex wrap-flex">
                or
              </div>
            @endif

            <div class="form-group block-flex wrap-flex">
              @if(isset($user->cashme_url) && $user->cashme_url != '')
                <img id="cashmeDonation" src="/img/cashme.png" alt="cashme">
                &nbsp;&nbsp;&nbsp;
                <a target="_blank" href="https://www.cash.me/${{$user->cashme_url}}">https://www.cash.me/${{$user->cashme_url}}</a>
              @elseif(isset($user->cashme_url_uk) && $user->cashme_url_uk != '')
                <img id="cashmeDonation" src="/img/cashme.png" alt="cashme">
                &nbsp;&nbsp;&nbsp;
                <a target="_blank" href="https://www.cash.me/£{{$user->cashme_url_uk}}">https://www.cash.me/£{{$user->cashme_url_uk}}</a>
              @endif 
            </div>
            <div class="form-group block-flex wrap-flex">
              @if($user->alt_url == 1)
                <button type="button" style="height:40px;width:185px;" data-ng-click="altDonate('{{$user->username}}')" class="secondary-btn">Discuss a method</button>
              @endif
            </div>
            <button type="button" class="main-btn" data-dismiss="modal" aria-label="Close">Close</button>
          </div>
      </div>
    </div>
  </div>
</div>