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
<?php use_helper("Custom")?>
<?php echo __("El grupo de consumo %&% acaba de confirmar el pedido %y%",array("%&%"=>$order->ConsumerGroup->name,"%y%"=>$order->name))?><?php echo PHP_EOL?>
<?php echo __("Aquí tienes el pedido segregado. También puedes verlo a través de la web")?><?php echo PHP_EOL?>
<?php foreach ($order->getConsumers() as $consumer):?>
	<?php echo __("La/el consumidora/or %&% ha hecho el siguiente pedido:",array("%&%"=>$consumer->name))?>
	<?php foreach ($consumer->getProductsOrders($order->id) as $consumer_order):?>
		<?php echo $consumer_order->Product->name?>: <?php echo deleteRightZero($consumer_order->amount)?> <?php echo $consumer_order->getPurchaseUnitName()?><?php echo PHP_EOL?>
	<?php endforeach;?>
	<?php echo __("El precio total del pedido de %)% asciende a %&% €",array("%&%"=>$consumer->getTotalPriceOrder($order->id),"%)%"=>$consumer->name))?><?php echo PHP_EOL?>
<?php endforeach;?>