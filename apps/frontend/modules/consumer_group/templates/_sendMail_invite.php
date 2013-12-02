<?php
/*
 © Copyright 2012diphda.net && sodepaz.org
info@diphda.net
sodepaz@sodepaz.org


Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia
Pública General de GNU según es publicada por la Free Software Foundation, bien de la versión 3 de dicha
Licencia o bien (según su elección) de cualquier versión posterior.

Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin l
garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la
Licencia Pública General de GNU para más detalles.

Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así,
escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, MA 02139, EEUU.

La licencia se encuentra en el archivo licencia.txt*/
?>
<?php echo __("La/el responsable del grupo de consumo %y% te ha enviado una invitación para unirte a su grupo en Grupo a grupo",array("%y%"=>$consumer_group->name))?><?php echo PHP_EOL?>
<?php echo __("Para aceptar la invitación sólo tienes que pinchar en este enlace %y% y rellenar tus datos",array("%y%"=>url_for($consumer_group_invitation->getLink(),true)))?><?php echo PHP_EOL?>
<?php echo __("Muchas gracias por participar en http://grupoagrupo.net")?><?php echo PHP_EOL?>