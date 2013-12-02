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
<?php use_helper("Number","Custom")?>

<h4><?php echo __("Detalle del pedido")?></h4>
<div class="consumer_order_detail_header">
<label class="detail_large"><?php echo __("Producto")?></label>
<label class="detail_short"><?php echo __("Cantidad")?></label>
<label class="detail_short"><?php echo __("Euros")?></label>
</div>
<div class="clear"></div>
<?php foreach ($consumer->getProductsOrders($order->id) as $consumer_order):?>
	<label class="detail_large" ><?php echo $consumer_order->getProviderProduct()->short_description?></label>
	<label class="detail_short"><?php echo deleteRightZero($consumer_order->amount)?> <?php echo $consumer_order->getPurchaseUnitName()?></label>
	<label class="detail_short"><?php echo format_currency($consumer_order->getMoneyConsumerOrder(),"EUR",$sf_user->getCulture())?></label>	
	<div class="clear"></div>
<?php endforeach;?>
<div class="total_detail"><strong><?php echo __("Total:")?></strong> <?php echo format_currency($consumer->getTotalPriceOrder($order->id),"EUR",$sf_user->getCulture())?></div>
<div class="finish_detail"><?php echo link_to(image_tag("admin/finish_order.png", array("title"=>__("Finalizar tu pedido"), "class"=>"fr")),"orders/show?slug=".$order->slug)?></div>
<div class="clear"></div>