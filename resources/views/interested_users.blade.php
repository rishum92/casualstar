<?php //echo '<pre>';print_r($interested_users);exit;
foreach ($interested_users as $user) {
?>
<div class="row"> 
	<div class="col-md-12">
	  <div>	
	    <img class="view_pro_pic" src="img/{{$user->img}}" />
	  </div>
	  <div class="view_users_link">
	     <h3><a href="{{url('users/'.$user->username)}}" class="view_users_link"><span>{{$user->username}}</span></a></h3>

	  </div> 
	</div>
</div>
<?php 
}
?>