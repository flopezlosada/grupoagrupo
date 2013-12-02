<?php use_helper('I18N') ?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<div class="sf_apply_notice">
<?php echo __(<<<EOM
<p>
Por razones de seguridad, hemos enviado un mensaje de confirmación a la 
dirección de correo electrónica asociada a esta cuenta. Por favor revisa
tu correo. Tienes que clicar en el link que te llegará en el mensaje para
poder cambiar tu contraseña. Si no ves el mensaje, revisa la carpeta "spam"
</p>
<p>
Disculpa las molestias
</p>
EOM
) ?>
<?php include_partial('sfApply/continue') ?>
</div>
