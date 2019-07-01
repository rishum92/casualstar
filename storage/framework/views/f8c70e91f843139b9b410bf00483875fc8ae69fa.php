<!DOCTYPE html>
<html lang="<?php echo e(App::getLocale()); ?>">
    <head>
    	<meta charset="utf-8">
    </head>
    <body>
        <h3>Banner ad <?php if($type != 'removed'): ?> request <?php endif; ?> <?php echo e($type); ?></h3>
        <?php if($reason): ?>
            <h4>Reason:</h4>
            <p><?php echo e($reason); ?></p>
        <?php endif; ?>
        <h4>Username:</h4>
        <p><?php echo e($bannerAdRequest->user->username); ?></p>
        <h4>E-mail:</h4>
        <p><?php echo e($bannerAdRequest->user->email); ?></p>
        <h4>Type:</h4>
        <p><?php echo e($bannerAdRequest->type); ?></p>
        <h4>Status:</h4>
        <p><?php echo e($type); ?></p>
        <h4>Live date:</h4>
        <p><?php echo e($bannerAdRequest->bannerAds[0]->day); ?></p>
        <h4>Extra promotions:</h4>
        <p><?php echo e($bannerAdRequest->extra_promotions == 1 ? 'Yes' : 'No'); ?></p>
    </body>
</html>