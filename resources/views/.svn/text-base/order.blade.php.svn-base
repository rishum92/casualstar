@extends('layouts.master')

@section('meta')
  <title>CasualStar</title>
@endsection

@section('scripts')
  
@endsection

@section('content')
  <section class="main subscription-main contact-main">
    <div class="wrap wrap-flex block-flex vertical-center-flex"> 
      <div class="description block-flex wrap-flex">
        <div class="sub-column">
          <h1>
            @if($order->status == 1)
              Payment <span class="success">{{$status}}</span>
              <span class="tagline">
                Your payment was successful. Thank you for your subscription!
              </span>
            @else
              Payment <span class="danger">{{$status}}</span>
              <span class="tagline">
                Unfortunately, your payment was unsuccessful.
              </span>
            @endif
          </h1>
        </div>
        <div class="sub-column">
          <p>Order #{{$order->id}}</p>
          <p>Plan: {{$order->plan->name}}</p>
          <p>Payment method: {{$order->payment_method}}</p>
          <p>Start date: {{date("d/m/Y", strtotime($order->created_at))}}</p>
          <p>End date: {{date("d/m/Y", strtotime($order->created_at->addMonth($order->plan->period)))}}</p>
        </div>
      </div>
    </div>
  </section>
@endsection