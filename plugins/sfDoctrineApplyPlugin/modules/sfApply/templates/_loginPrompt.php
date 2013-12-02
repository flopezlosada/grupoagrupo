<?php use_helper('I18N') ?>
<div class="login_data">
<span><?php echo __("Acceso a usuarias/os")?></span>

<form method="POST" action="<?php echo url_for("@sf_guard_signin") ?>" name="sf_guard_signin" id="sf_guard_signin_form" class="sf_apply_signin_inline">
  <?php echo $form ?>
  <input type="submit" class="submit" value="<?php echo __('Acceder') ?>" />
  <p>
  <?php echo link_to(__('Reset Your Password'), 'sfApply/resetRequest')  ?> <br />
  <?php echo link_to(__('Create a New Account'), 'sfApply/apply', array("class"=>"create_account"))
  ?>
  </p>
</form>
<div class="clear"></div>
</div>