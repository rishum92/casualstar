<?php //echo '<pre>';print_r($interested_users);exit;
foreach ($interested_users as $user) {
?>
<div class="row"> 
	<div class="col-md-12">
	  <div>	
	  	<?php if($user->img == ''): ?>
	  		<img class="view_pro_pic" src="img/female.jpg" />
	  	<?php else: ?>	
	    	<img class="view_pro_pic" src="img/users/<?php echo e($user->username); ?>/previews/<?php echo e($user->img); ?>" />
	    <?php endif; ?>
	  </div>
	  <div class="view_users_link">
	     <h3><a href="<?php echo e(url('users/'.$user->username)); ?>" class="view_users_link"><span><?php echo e($user->username); ?></span></a></h3>

	  </div> 
	</div>
</div>
<?php 
}
?>