<?php use_helper('I18N') ?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<div class="sf_apply sf_apply_reset_request">
<form method="POST" action="<?php echo url_for('sfApply/resetRequest') ?>"
  name="sf_apply_reset_request" id="sf_apply_reset_request">
<p>
<?php echo __(<<<EOM
Has olvidado tu nombre de usuario o contraseña: No te preocupes, introduce tu nombre de usuaria/o <strong>o</strong>
tu dirección de correo electrónico y clica "Restablecer mi contraseña." Recibirás un email conteniendo tu nombre de usuaria/o y 
un enlace que te permitirá cambiar tu contraseña.
EOM
) ?>
</p>
<ul>
<?php echo $form ?>
<li>
<input type="submit" value="<?php echo __("Reset My Password") ?>"> 
<?php echo __("or") ?> 
<?php echo link_to(__('Cancel'), sfConfig::get('app_sfApplyPlugin_after', '@homepage')) ?>
</li>
</ul>
</form>
</div>
