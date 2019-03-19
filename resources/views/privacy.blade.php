@extends('layouts.master')

@section('meta')
  <title>Privacy policy » CasualStar</title>
@endsection

@section('scripts')
  
@endsection

@section('content')
  <section class="main collection-main contact-main">
    <div class="wrap wrap-flex block-flex vertical-center-flex">
      <div class="description">
        <h1>Privacy policy</h1>
        <p>
          Please find our privacy policy attached:<br>
          <a href="{{ URL::asset('docs/CasualStarPrivacyPolicy2017.docx') }}"><i class="fa fa-file-pdf-o"></i> privacy_policy.docx</a>
        </p>
      </div>
    </div>
  </section>
  {!! Form::close() !!}
@endsection