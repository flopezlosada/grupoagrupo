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
<?php echo __("Se acaba de modificar la fecha de cierre del pedido %&% para la/el %s% %y%",array("%s%"=>$provider->ProviderType->name,"%y%"=>$provider->name,"%&%"=>$order->name))?><?php echo PHP_EOL?>

<?php echo __("La nueva fecha de cierre del pedido es %&%",array("%&%"=>$order->date_out))?><?php echo PHP_EOL?>
<?php echo __("La persona responsable del pedido es %&% y su email es %T%",array("%&%"=>$order->Consumer->name,"%T%"=>$order->Consumer->email))?><?php echo PHP_EOL?>