<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
    	<meta charset="utf-8">
    </head>
    <body>
        <h3>Banner ad @if($type != 'removed') request @endif {{ $type }}</h3>
        @if($reason)
            <h4>Reason:</h4>
            <p>{{ $reason }}</p>
        @endif
        <h4>Username:</h4>
        <p>{{$bannerAdRequest->user->username}}</p>
        <h4>E-mail:</h4>
        <p>{{$bannerAdRequest->user->email}}</p>
        <h4>Type:</h4>
        <p>{{$bannerAdRequest->type}}</p>
        <h4>Status:</h4>
        <p>{{ $type }}</p>
        <h4>Live date:</h4>
        <p>{{$bannerAdRequest->bannerAds[0]->day}}</p>
        <h4>Extra promotions:</h4>
        <p>{{$bannerAdRequest->extra_promotions == 1 ? 'Yes' : 'No'}}</p>
    </body>
</html>