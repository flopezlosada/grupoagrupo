<?php if ($sf_user->hasFlash('notice')): ?>
  <div class="message_notice"><?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?></div>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error')): ?>
  <div class="message_error"><?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?></div>
<?php endif; ?>
