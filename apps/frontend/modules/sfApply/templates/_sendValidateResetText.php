<?php use_helper('I18N', 'Url') ?>
<?php echo __(<<<EOM
We have received your request to recover your username and possibly your password on:

%1%

Tu nombre de usuaria/o es: %USERNAME%

Si has perdido tu contraseña o quieres cambiarla, pincha en el siguiente enlace:

%2%

Y podrás cambiar la contraseña.

Tu contraseña no cambiará a menos que pinches en el enlace y completes el formulario.
EOM
, array("%1%" => url_for($sf_request->getUriPrefix()),
  "%2%" => url_for("sfApply/confirm?validate=$validate", true),
  "%USERNAME%" => $username)) ?>

