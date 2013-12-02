<?php
/*
© Copyright 2012 diphda.net && Sodepaz
info@diphda.net


Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia
Pública General de GNU según es publicada por la Free Software Foundation, bien de la versión 3 de dicha
Licencia o bien (según su elección) de cualquier versión posterior.

Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin la
garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la
Licencia Pública General de GNU para más detalles.

Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así,
escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, MA 02139, EEUU.

La licencia se encuentra en el archivo licencia.txt*/
?>
<?php use_helper("Date","Text")?>
<?php $link_name=ucfirst($type);?>
<?php $link_name.=$is_consumer_group_only ? ' del grupo de consumo':''?>
<?php $link_url=$is_consumer_group_only ? 'consumer_group_only=true':''?>

<?php  if($is_consumer_group_only):?>
    <?php include_partial("profile/util_consumer_group",array("link_name"=>$link_name,"announcement"=>$announcement,"type"=>$type,"link_url"=>$link_url))?>
<?php else:?>
    <?php include_partial("profile/util_general",array("link_name"=>$link_name,"announcement"=>$announcement,"type"=>$type))?>
<?php endif;?>



