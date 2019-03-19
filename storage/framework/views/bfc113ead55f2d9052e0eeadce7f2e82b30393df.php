<div class="btn-group photo-controls clearfix">
  <button onClick='cropperControl(this)' class="btn btn-primary photo-controls" data-method="setDragMode" data-option="move" title="<?php echo app('translator')->get('messages.cropper.move'); ?>" type="button">
    <i class="ion-arrow-move"></i>
  </button>
  <button onClick='cropperControl(this)' class="btn btn-primary photo-controls" data-method="setDragMode" data-option="crop" title="<?php echo app('translator')->get('messages.cropper.crop'); ?>" type="button">
    <i class="ion-crop"></i>
  </button>
  <button onClick='cropperControl(this)' class="btn btn-primary photo-controls" data-method="zoom" data-option="0.1" title="<?php echo app('translator')->get('messages.cropper.zoomIn'); ?>" type="button">
    <i class="ion-plus-circled"></i>
  </button>
  <button onClick='cropperControl(this)' class="btn btn-primary photo-controls" data-method="zoom" data-option="-0.1" title="<?php echo app('translator')->get('messages.cropper.zoomOut'); ?>" type="button">
    <i class="ion-minus-circled"></i>
  </button>
  <button onClick='cropperControl(this)' class="btn btn-primary photo-controls" data-method="rotate" data-option="-90" title="<?php echo app('translator')->get('messages.cropper.rotateLeft'); ?>" type="button">
    <i class="ion-reply"></i>
  </button>
  <button onClick='cropperControl(this)' class="btn btn-primary photo-controls" data-method="rotate" data-option="90" title="<?php echo app('translator')->get('messages.cropper.rotateRight'); ?>" type="button">
    <i class="ion-forward"></i>
  </button>
  <button onClick='cropperControl(this)' class="btn btn-primary photo-controls" data-method="rotate" data-option="-180" title="<?php echo app('translator')->get('messages.cropper.flip'); ?>" type="button">
    <i class="ion-loop"></i>
  </button>
  <button onClick='cropperControl(this)' class="btn btn-primary photo-controls" data-method="reset" type="button" title="<?php echo app('translator')->get('messages.cropper.reset'); ?>">
    <i class="ion-close-circled"></i>
  </button>
</div>
