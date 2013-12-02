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
<?php echo __("El grupo de consumo %s% acaba de abrir un pedido con el nombre de %&%",array("%s%"=>$order->Consumer->ConsumerGroup->name,"%&%"=>$order->name))?><?php echo PHP_EOL?>
<?php echo __("La fecha de apertura del pedido es %&%",array("%&%"=>$order->date_in))?><?php echo PHP_EOL?>
<?php echo __("La fecha de cierre del pedido es %&%",array("%&%"=>$order->date_out))?><?php echo PHP_EOL?>
<?php echo __("La forma de pago es %&%",array("%&%"=>$order->PaymentMethod->name))?><?php echo PHP_EOL?>
<?php echo __("El método de envío es %&%",array("%&%"=>$order->ShippingMode->name))?><?php echo PHP_EOL?>
<?php echo __("La persona responsable del pedido es %&% y su email es %T%",array("%&%"=>$order->Consumer->name,"%T%"=>$order->Consumer->email))?><?php echo PHP_EOL?>
<?php if ($order->provider_comment):?>
    <?php echo __("Comentarios al pedido: %&%",array("%&%"=>$order->provider_comment))?>
<?php endif;?>