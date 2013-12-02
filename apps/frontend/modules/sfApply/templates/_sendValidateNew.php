<?php use_helper('I18N', 'Url') ?>
<?php echo __(<<<EOM
<p>
Gracias por crear una cuenta en %1%.
</p>
<p>
Para evitar el abuso del sitio, es necesario que active la cuenta haciendo clic en el siguiente enlace:
</p>
<p>
%2%
</p>
<p>
Gracias de nuevo por estar con nosotr@s.
</p>
EOM
, array("%1%" => link_to($sf_request->getHost(), $sf_request->getUriPrefix()),
  "%2%" => link_to(url_for("sfApply/confirm?validate=$validate", true), "sfApply/confirm?validate=$validate", array("absolute" => true)))) ?>
