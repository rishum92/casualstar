
<?php foreach($my_logged_interested_users as $logged_user): ?>
<div class="row"> 
  <div class="col-md-12">
    <div> 
      <?php if($logged_user->img == ''): ?>
      <img class="view_pro_pic" src="img/female.jpg" />
      <?php else: ?>
      <img class="view_pro_pic" src="img/users/<?php echo e($logged_user->username); ?>/previews/<?php echo e($logged_user->img); ?>" />
      <?php endif; ?>
    </div>
    <div class="view_users_link">
       <h3><a href="<?php echo e(url('users/'.$logged_user->username)); ?>" class="view_users_link"><span><?php echo e($logged_user->username); ?></span></a></h3>
    </div> 
  </div>
</div>
<?php endforeach; ?>