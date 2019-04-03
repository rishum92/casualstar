<?php //echo '<pre>';print_r($interested_users);exit;
foreach ($interested_users as $user) {
?>
<div class="row"> 
	<div class="col-md-12">
	  <div>	
	  	<?php if($user->img == ''): ?>
	  		<img class="view_pro_pic" src="img/59ce3646d240c.png" />
	  	<?php else: ?>	
	    	<img class="view_pro_pic" src="img/<?php echo e($user->img); ?>" />
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