<?php use_helper('I18N', 'Url') ?>
<?php echo __(<<<EOM
Gracias por crear una cuenta en %1%.

Para evitar el abuso del sitio, es necesario que active la cuenta haciendo clic en el siguiente enlace:

%2%

Gracias de nuevo por estar con nosotr@s.
EOM
, array("%1%" => $sf_request->getHost(),
  "%2%" => url_for("sfApply/confirm?validate=$validate", true))) ?>
