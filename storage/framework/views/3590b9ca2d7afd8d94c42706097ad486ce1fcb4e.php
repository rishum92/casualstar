<?php $__env->startSection('meta'); ?>
  <title>Privacy policy » CasualStar</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <section class="main collection-main contact-main">
    <div class="wrap wrap-flex block-flex vertical-center-flex">
      <div class="description">
        <h1>Privacy policy</h1>
        <p>
          Please find our privacy policy attached:<br>
          <a href="<?php echo e(URL::asset('docs/CasualStarPrivacyPolicy2017.docx')); ?>"><i class="fa fa-file-pdf-o"></i> privacy_policy.docx</a>
        </p>
      </div>
    </div>
  </section>
  <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>