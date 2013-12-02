<?php
/*
 © Copyright 2013diphda.net && sodepaz.org
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
<div class="order_general_data">
      <?php if ($order->order_state_id==4):?>
        <span class="message_notice"  style="display:none" id="modify_<?php echo $order->id?>">
        <?php echo __("El pedido ha sido modificado")?></span>
      <?php endif;?> 
  <?php if ($sf_user->hasCredential("consumer")):?>
    <p><strong><?php echo __('Proveedora/or:')?></strong> 
        <?php echo link_to($order->Provider->name,"@provider_profile?slug=".$order->Provider->slug)?>
      </p>
  <?php elseif ($sf_user->hasCredential("producer")||$sf_user->hasCredential("distributor")):?>
  <p><strong><?php echo __('Grupo de consumo:')?></strong>  <?php echo $order->ConsumerGroup->name?>  
  <?php endif;?>
  <p><strong><?php echo __("Coste Total:")?></strong> <span class="sum_total_price_order_all_consumers"><?php echo format_currency($order->getTotalPrice(),"EUR",$sf_user->getCulture())?></span></p>
  <p><strong><?php echo __("Fecha de apertura:")?></strong> <?php echo format_datetime($order->date_in,"P",$sf_user->getCulture())?></p>
  <p><strong><?php echo __("Fecha de cierre:")?></strong> <?php echo format_datetime($order->date_out,"P",$sf_user->getCulture())?></p>
  <?php if ($sf_user->hasCredential("consumer")):?>
    <?php if ($order->group_comment!=''):?>			
        <p><strong><?php echo __("Comentarios: ")?></strong><span class="order_comment"><?php echo cleanPurifier($order->group_comment)?></span></p>
    <?php endif;?>
  <?php elseif ($sf_user->hasCredential("producer")||$sf_user->hasCredential("distributor")):?>
      <?php if ($order->provider_comment!=''):?>			
        <p><strong><?php echo __("Comentarios: ")?></strong><span class="order_comment"><?php echo cleanPurifier($order->provider_comment)?></span></p>
    <?php endif;?>	    	
  <?php endif;?>
  <?php if ($order->reject_comment!=''):?>			
        <p><strong><?php echo __("Pedido rechazado: ")?></strong><span class="order_comment"><?php echo cleanPurifier($order->reject_comment)?></span></p>
    <?php endif;?>    
    
  <?php if ($order->order_state_id>2):?>
  <p><strong><?php echo __("Fecha de confirmación:")?></strong> <?php echo format_datetime($order->group_send_to_provider_date,"P",$sf_user->getCulture())?></p>
  <?php endif;?>	    
  <?php if ($order->order_state_id>3):?>
  <p><strong><?php echo __("Fecha de aceptación por la/el proveedor:")?></strong> <?php echo format_datetime($order->provider_accept_date,"P",$sf_user->getCulture())?></p>
  <?php endif;?>	         
  <?php if ($order->order_state_id>8):?>
  <p><strong><?php echo __("Fecha de finalización del pedido por la/el proveedor:")?></strong> <?php echo format_datetime($order->provider_finalize_date,"P",$sf_user->getCulture())?></p>
  <?php endif;?>	         	
  <?php if ($order->order_state_id>9):?>
  <p><strong><?php echo __("Fecha de envío del pedido por la/el proveedor:")?></strong> <?php echo format_datetime($order->provider_send_to_group_date,"P",$sf_user->getCulture())?></p>
  <?php endif;?>	  
  <?php if ($order->order_state_id>10):?>
  <p><strong><?php echo __("Fecha de recepción del pedido por el grupo:")?></strong> <?php echo format_datetime($order->group_receive_date,"P",$sf_user->getCulture())?></p>
  <?php endif;?>	         
  <p><strong><?php echo __("Forma de pago:")?></strong> <?php echo $order->PaymentMethod->name?></p>
  <p><strong><?php echo __("Método de envío:")?></strong> <?php echo $order->ShippingMode->name?></p>
</div>  