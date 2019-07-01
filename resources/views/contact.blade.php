@extends('layouts.master')

@section('meta')
  <title>Contact | CasualStar</title>
@endsection

@section('scripts')
  
@endsection

@section('content')
  <section class="main collection-main contact-main">
    <div class="wrap wrap-flex block-flex vertical-center-flex">
      <div class="description">
        
        <h1>Contact us</h1>
        <p>If you have any questions or issues please contact us using the form below... BUT first, we recommend that you visit our <a href="https://www.casualstar.uk/faq"><b>Frequently Asked Questions</b></a> page, where you may receive the answer to your question, much quicker.
        </p>
      </div>
    </div>
  </section>
  
  {!! Form::open(array('route' => 'send.contact', 'data-toggle' => 'validator', 'method' => 'POST', 'files' => false)) !!}
  <section class="contact"> 
    <div class="wrap">
      <form>
        <div class="block-flex wrap-flex space-between-flex">
          <div class="form-group">
            <label>Casualstar Username*</label>
            <input type="text" name="name" class="form-control" data-error="You must enter a valid name or username" required />
            <div class="help-block with-errors"></div>
          </div></hr>
          <div class="form-group">
            <label>Email*</label> 
            <input type="text" name="email" class="form-control" data-error="You must enter a valid email" required />
            <div class="help-block with-errors"></div>
          </div>
        </div>
        <div class="block-flex wrap-flex space-between-flex">
          <div class="form-group">
            <label>Telephone No.</label>
            <input type="text" name="telephone" class="form-control" placeholder="(optional)" />
            <div class="help-block with-errors"></div>
          </div>
        </div>
        <div class="form-group textarea-group">
          <label>Your Message*</label>
          <textarea name="message" class="form-control" required data-error="You can't submit without a message." ></textarea>
          <div class="help-block with-errors"></div>
        </div>
        <button type="submit" class="main-btn form-btn">send message</button> 
      </form>
    </div>
  </section>
  {!! Form::close() !!}

  <section class="contact"> 
    <div class="wrap">
      <ul class="contact-details block-flex wrap-flex space-between-flex">
        <li>
          <p><b>Email</b></p>
          <p>Admin@CasualStar.uk - General use.</p>
        <p>Abuse@CasualStar.uk - Reporting abuse.</p>

        </li>
        <li>
          <p><b>Address</b></p>
          <p>CasualStar</p>
          <p>11 KMG Business Complex</p>
          <p>London</p>
          <p>NW6 7RD</p>
        </li>
        <li>
          <p><b>Whatsapp Only</b></p>
           <p>07404963138</p>
</br>
<a href="https://www.twitter.com/casualstars" target="_blank"><b>Twitter: @CasualStars</b> <alt="casualstarTwitter"<a/></br>
<a href="https://www.instagram.com/casualstarr" target="_blank"><b>Instagram: CasualStarr</b> <alt="casualstarInstagram"<a/>
        </li>
      </ul> 
    </div>
  </section>
  
@endsection