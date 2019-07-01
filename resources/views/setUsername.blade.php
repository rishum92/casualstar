@extends('layouts.master')

@section('meta')
  <title>Welcome! » CasualStar</title>
@endsection

@section('scripts')
<script type="text/javascript">
  $('#location').geocomplete({
  
  }).bind("geocode:result", function(event, result){
    $('#lat').val(result.geometry.location.lat());
    $('#lng').val(result.geometry.location.lng());
    $('#location').removeClass('error');
    if($('#username').val() != '' && !$('#username').hasClass('taken')) {
      $('#locationSet').val(true);
      $('#location').removeClass('error');
      $('#createAccount').removeAttr('disabled');
    }
  });

  $('#location').bind("propertychange change keyup input paste", function(event) {
    if($('#locationSet').val() == "true") {
      $('#location').addClass('error');
    }
    $('#locationSet').val(false);
    $('#createAccount').attr('disabled', 'disabled');
  })

  $("#username").on("keydown", function (e) {
    return e.which !== 32;
  });

  function isAlphaNumeric(str) {
    var code, i, len;

    for (i = 0, len = str.length; i < len; i++) {
      code = str.charCodeAt(i);
      if (!(code > 47 && code < 58) && // numeric (0-9)
          !(code > 64 && code < 91) && // upper alpha (A-Z)
          !(code > 96 && code < 123)) { // lower alpha (a-z)
        return false;
      }
    }
    return true;
  };
</script>


@endsection

@section('content')
  <div data-ng-controller="RegisterController">
    <section class="edit-profile">
      <div class="form wrap block-flex wrap-flex space-between-flex">
        <div class="column">
          &nbsp;
        </div>
        <div class="column">
          <h2>Select your username and location</h2>
          {!! Form::open(array('route' => 'username.set', 'data-toggle' => 'validator', 'method' => 'POST', 'files' => false)) !!}
            <div class="form-group">
              <label>Username</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="ion-person"></i></span>
                <input name="username" pattern="[a-zA-Z0-9 ]+" id="username" minlength="2" maxlength="16" type="username" class="form-control" required data-ng-model="username">
              </div>
              <div class="custom-help-block help-block with-errors">{{ Lang::get('messages.usernameError') }}</div> 
            </div>
            <div class="form-group">
              <label>Location</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="ion-ios-location"></i></span>
                <input type="text" id="location" name="location" class="form-control" placeholder="">
                <input type="hidden" id="locationSet" class="form-control" placeholder="">
                <input type="hidden" id="lat" name="lat" class="form-control" placeholder="">
                <input type="hidden" id="lng" name="lng" class="form-control" placeholder="">
              </div>
            </div>
            <button disabled type="submit" id="createAccount" class="main-btn stroke-btn">SAVE</button>
          {!! Form::close() !!}
        </div>
        <div class="column cancel-account">
          &nbsp;
        </div>
      </div>
    </section>
  </div>
@endsection