
@foreach($my_logged_interested_users as $logged_user)
<div class="row"> 
  <div class="col-md-12">
    <div> 
      @if($logged_user->img == '')
      <img class="view_pro_pic" src="img/female.jpg" />
      @else
      <img class="view_pro_pic" src="img/users/{{$logged_user->username}}/previews/{{$logged_user->img}}" />
      @endif
    </div>
    <div class="view_users_link">
       <h3><a href="{{url('users/'.$logged_user->username)}}" class="view_users_link"><span>{{$logged_user->username}}</span></a></h3>
    </div> 
  </div>
</div>
@endforeach