<?php $__env->startSection('meta'); ?>
  <title>Safety Tips » CasualStar</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <section class="main collection-main contact-main">
    <div class="wrap wrap-flex block-flex vertical-center-flex">
      <div class="description">
        <h1>Safety tips</h1>
        <p>
          Please find our Safety Tips attached:<br>
          <a href="<?php echo e(URL::asset('docs/CSsafety.docx')); ?>"><i class="fa fa-file-pdf-o"></i> safety_tips.docx</a>
        </p>
      </div>
    </div>
  </section>
  <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>