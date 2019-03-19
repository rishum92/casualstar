@extends('layouts.master')

@section('meta')
  <title>FAQ | CasualStar</title>
@endsection

@section('scripts')
  <script> 
    $(document).ready(function(){
  var animTime = 300,
      clickPolice = false;
  
  $(document).on('click', '.acc-btn', function(){
    if(!clickPolice){
       clickPolice = true;
      
      var currIndex = $(this).index('.acc-btn'),
          targetHeight = $('.acc-content-inner').eq(currIndex).outerHeight();
   
   
   
   
      $('.acc-btn h1').removeClass('selected');
      $(this).find('h1').addClass('selected');
      
      
    
      $('.acc-content').stop().animate({ height: 0 }, animTime);
      $('.acc-content').eq(currIndex).stop().animate({ height: targetHeight }, animTime);

      setTimeout(function(){ clickPolice = false; }, animTime);
    }
    
  });
  
});
    </script>
@endsection



@section('content')

    
    
<style>
@import url(https://fonts.googleapis.com/css?family=Lato:400,700);


* { 
  -webkit-box-sizing:border-box;
  -moz-box-sizing:border-box;
  -o-box-sizing:border-box;
  box-sizing:border-box;
}

html, body {
  background:#FFFFFF;
}

.acc-container {
  width:90%;
  margin:30px auto 0 auto;
  -webkit-border-radius:8px;
  -moz-border-radius:8px;
  -o-border-radius:8px;
  border-radius:8px;
  overflow:hidden;
}

.acc-btn { 
  width:100%;
  margin:0 auto;
  padding:20px 25px;
  cursor:pointer;
  background:#34495E;
  border-bottom:1px solid #2C3E50;
}

.acc-content {
  height:0px;
  width:100%;
  margin:0 auto;
  overflow:hidden;
  background:#2C3E50;
}

.acc-content-inner {
  padding:30px;
}

.open {
  height: auto;
}

h2 {
  color:#0a0a0a;
}
h1 {
  color:#cfd2d6;
}

p { 
  font:400 16px/24px 'Lato', sans-serif;
  color:#ffffff;
}

.selected {
  color:#f442a1;
}
    
    
</style>
     
      <div class="description">
       

<div class="acc-container">
    
     <h2><certer>Frequently Asked Questions</center><h2>
        <br>
        <hr>
    
<div class="acc-btn"><h1>Payment - How it Works.</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>Casualstar does not have a built-in payment system, if we did we would have to pass on the ossociated fees and charges to our users. To collect payment for any services or content, you must speak with the person requesting your content and direct them to first make payment to your Paypal or other payment method account. You then need to check the relevant account, and confirm receipt of the payment BEFORE granting any content or service.</p>
  </div>
</div>

<div class="acc-btn"><h1>Sending Videos & Images</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>In the event you need to send files such as videos or images, we recommend that you send it via email to the recipient, using an email address separate to your personal one and dedicated to your findom services.</p>
  </div>
</div>

<div class="acc-btn"><h1>I’m not from the UK is it worth me still joining Casualstar.uk?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>Yes, absolutely. Casualstar.uk is a global brand and has various users worldwide. </p>
  </div>
</div>

<div class="acc-btn"><h1>How to remove my profile picture?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>Navigate to your “Settings” page located in your menu header bar at the top of each page. Once on the page identify and click the “Remove Photo” button near the top of the page, to remove profile page.   </p>
  </div>
</div>
  <div class="acc-btn"><h1>How do I accept all currencies?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>To accept any currency from anywhere in the world, simply leave your currency select function blank, which is located at the top of your services page.</p>
  </div>
</div>
  <div class="acc-btn"><h1>How to add images to Private Gallery?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>First you need to navigate to your "Services" page located in the header menu.
Secondly you add your currency type you wish to accept. Then click the "All Services" tab to drop down the options of services. You then find the "Private gallery" service and enter your fee amount and time period variable from the drop list. After doing so you then click "Add" to add the service to your profile page. At this point your private gallery upload button will then be activated and ready for uploads. 
</p>
  </div>
</div>
  <div class="acc-btn"><h1>How do I verify my account?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>Navigate to your “Verification” page then follow the steps outlined within the page. The verification process will normally take up to 3 working days to be reviewed and verified. </p>
  </div>
</div>
  <div class="acc-btn"><h1>How do I add my payment details?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>Navigate to your Casualstar “Account Details” page where you can easily complete your extensions of one or both payment methods, options being Cash.me and PayPal.me. For example if your www.PayPal.me/QueenAlice you would only need to enter “QueenAlice” and then click the tick button to activate your blue PAY ME button on your profile page. </p>
  </div>
</div>
  <div class="acc-btn"><h1>How do I change my password?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>Navigate to your “Settings” page located in your menu header bar at the top of each page. Identify the update “Change password” area where you can then change your password.</p>
  </div>
</div>
  <div class="acc-btn"><h1>How do I update my email address?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>Navigate to your “Settings” page located in your menu header bar at the top of each page. Once on the page identify the “Update Contact Details” area where you can then update your email address.</p>
  </div>
</div>

<div class="acc-btn"><h1>How do I update my location?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>Navigate to you profile page, from there you will be able to see your current location displayed below your profile image. Click on your current location to change it as desired.</p>
  </div>
</div>
  
  <div class="acc-btn"><h1>Can I add my own unique service to offer on my profile?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>Yes; at the bottom of the services table are 2 sections where you can add your own unique service name and service variable, after which it is added to your profile page as normal.</p>
  </div>
</div>
  
  <div class="acc-btn"><h1>How do I change my username?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>To have your username changed please contact the Casualstar admin team, via the contact form on the contact page or by emailing Admin@Casualstar.uk. </p>
  </div>
</div>
  
  <div class="acc-btn"><h1>Why can I not reply to a conversation in my messages? </h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>This happens when the conversation has been deleted by the other person, preventing you from sending them any more messages, until they have sent you a new one. This is a technical issue and we are working to fix the problem. Sorry for any inconvenience caused.</p>
  </div>
</div>
  
  <div class="acc-btn"><h1>If I report another user will they know it was me?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>In most cases we will not reveal your identity and will treat your reports with confidentiality. There may be some instances where it is necessary to reveal your identity to the accused. However this will not be done without notifying you first.</p>
  </div>
</div>
  
  <div class="acc-btn"><h1>If I add a user to my favourites, will they be notified?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>No, this is only for you to know, so the user you add will not find out.  </p>
  </div>
</div>
  
  <div class="acc-btn"><h1>Why is my profile photo not displaying?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>If you uploaded a photo when you registered and it is not displaying then try to re-upload it again from your profile page. If the problem continues please contact Admin@Casualstar.uk for further assistance.</p>
  </div>
</div>
  

<div class="acc-btn"><h1>Why cant I login to my account?</h1></div>
<div class="acc-content">
  <div class="acc-content-inner">
    <p>If you originally registered via Twitter or Facebook then you will only be able to login to your Casualstar account by using the network you first used.</p>
  </div>
</div>
</div>

 {!! Form::close() !!}
@endsection