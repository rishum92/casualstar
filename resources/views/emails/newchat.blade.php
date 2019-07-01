<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h3>Hello, {{Auth::user()->username}},
        	<br>
	        You have received a new private message from <a href="{{ $_SERVER['HTTP_HOST'] . '/users/' . $user->username }}">{{ $user->username }}</a>. Please login to your account to view the message.
	        <br>
	        <br>
	        <a href="https://www.casualstar.uk">CasualStar</a>
        </h3>
    </body>
</html>
