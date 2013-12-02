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
<?php use_helper("Custom","Number")?>
<?php echo __("El grupo de consumo %&% acaba de confirmar el pedido %y%",array("%&%"=>$order->ConsumerGroup->name,"%y%"=>$order->name))?><?php echo PHP_EOL?>
<?php echo __("El precio final del pedido es %&%", array("%&%"=>format_currency($order->getTotalPrice(),"EUR",$sf_user->getCulture())))?><?php echo PHP_EOL?>
<?php echo __("Para ver el detalle del pedido debes aceptarlo. Entra en la web para ello.")?><?php echo PHP_EOL?>
