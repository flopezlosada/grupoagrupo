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
<?php echo deleteRightZero($consumer_order->amount)?>
<?php if ($amount>0):?>    
	<script>
	$('#total_price_<?php echo $consumer_order->Orders->id?>').text('<?php echo format_currency($consumer_order->Orders->getTotalPrice(),"EUR",$sf_user->getCulture())?>');
	$('#price_consumer_<?php echo $consumer_order->Consumer->id?>_<?php echo $consumer_order->order_id?>').text('<?php echo __("Total Pedido: ").format_currency($consumer_order->Consumer->getTotalPriceOrder($consumer_order->Orders->id),"EUR",$sf_user->getCulture())?>');
	$('#total_provider_product_<?php echo $consumer_order->ProviderProduct->id?>_consumer_<?php echo $consumer_order->consumer_id?>').text('<?php echo format_currency($consumer_order->ProviderProduct->price*$consumer_order->amount,"EUR",$sf_user->getCulture())?>');
	$('#total_order_<?php echo $consumer_order->Orders->id?>_provider_product_<?php echo $consumer_order->ProviderProduct->id?>').text('<?php echo format_currency($consumer_order->ProviderProduct->getAmountInOrder($consumer_order->Orders->id)*$consumer_order->ProviderProduct->price,"EUR",$sf_user->getCulture())?>');
	$('#total_amount_order_<?php echo $consumer_order->Orders->id?>_provider_product_<?php echo $consumer_order->ProviderProduct->id?>').text('<?php echo deleteRightZero($consumer_order->ProviderProduct->getAmountInOrder($consumer_order->Orders->id))?> <?php echo $consumer_order->ProviderProduct->PurchaseUnit->name?>');
	$('.sum_total_price_order_all_consumers').text('<?php echo format_currency($consumer_order->Orders->getTotalPrice(),"EUR",$sf_user->getCulture())?>');
	$('#order_consumer_modify_<?php echo $consumer_order->id?>').toggle('slow');
	$('#send_order_<?php echo $consumer_order->Orders->id?>').hide();
	$('#go_back_<?php echo $consumer_order->Orders->id?>').show();
	$('#modify_<?php echo $consumer_order->Orders->id?>').show();
	</script>
<?php endif;?>
