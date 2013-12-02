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

<?php if ($state->id==6):?>
	<span class="message_notice"  style="display:none" id="modify_<?php echo $order->id?>"><?php echo __("El pedido ha sido modificado")?></span>
<?php endif;?> 
<!-- Este es para la opción de desplegar cada detalle del pedido en la misma página 
<span class="order_name large_title open_detail open_detail_<?php //echo $state->id."_".$order->id?>"><?php //echo $order->name?></span> 
-->	
<!-- Este para ver el detalle en otra página -->
<span class="order_name large_title"><?php echo link_to($order->name,'@orders_show?slug='.$order->slug)?></span> 
<span class="order_name large_title"><?php echo $order->Provider->name?></span>	
<span class="order_name price_title"><?php echo format_datetime($order->date_in,"p",$sf_user->getCulture(),"utf-8")?></span>	
<span class="order_name price_title"><?php echo format_datetime($order->date_out,"p",$sf_user->getCulture(),"utf-8")?></span>
<span class="order_name price_title"><span id="total_price_<?php echo $order->id?>"><?php echo format_currency($order->getTotalPrice(),
"EUR",$sf_user->getCulture())?></span></span>		
<div class="clear"></div>     		    	              							    
<?php // include_partial("consumer_group/order_actions",array("state"=>$state,"order"=>$order))?>   
<div class="clear"></div>
<?php //include_partial("provider/order_detail",array("state"=>$state,"order"=>$order,"limit_state"=>array(1,2,6,7),"url"=>"consumer_group/change_order_consumer","url_delete"=>"consumer_group/deleteconsumerorder"))?>
<div class="clear"></div>
  
  