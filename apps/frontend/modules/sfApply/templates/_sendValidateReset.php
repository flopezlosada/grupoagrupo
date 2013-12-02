<?php use_helper('I18N', 'Url') ?>
<?php echo __(<<<EOM
<p>
Hemos recibido una petición para recuperar tu nombre de usuaria/o y/o contraseña en: 
%1%
</p>
<p>
Tu nombre de usuaria/o es: %USERNAME%
</p>
<p>
Si has perdido tu contraseña o quieres cambiarla, pincha en el siguiente enlace:
</p>
<p>
%2%
</p>
<p>
Y podrás cambiar la contraseña.</p>
<p>Tu contraseña no cambiará a menos que pinches en el enlace y completes el formulario.
</p>
EOM
, array("%1%" => link_to($sf_request->getHost(), $sf_request->getUriPrefix()),
  "%2%" => link_to(url_for("sfApply/confirm?validate=$validate", true), "sfApply/confirm?validate=$validate", array("absolute" => true)),
  "%USERNAME%" => $username)) ?>

