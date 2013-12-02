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
<?php include_partial("flashes")?>
<h3><?php echo __("Catálogo de la/el ").$provider->getSfGuardUser()->getProfile()->InternalClass->name." ".$provider->name?></h3>
<?php if ($sf_user->isAuthenticated()):?>  
  <?php if ($order):?>  
    <?php if (($sf_user->hasCredential("consumer")
        &&$sf_user->getInternalUser()->canManageOrder($order->id)
        &&in_array($order->order_state_id,array(1,2,6,7)))
        	    ||($sf_user->hasCredential("distributor")||$sf_user->hasCredential("producer"))&&in_array($order->order_state_id,array(4,5,8))||$sf_user->getInternalUser()->getId()==$buyConsumer->id&&in_array($order->order_state_id,array(1,2,6,7))):?>
   
 	<div id="order_consumer_detail">
	    <?php include_partial("consumer_group/consumer_order_detail",array("consumer"=>$buyConsumer,"order"=>$order))?>	
	</div>
    <?php endif;?>  
  <?php endif;?>
<?php endif;?>
<?php if (count($highlight_provider_products)):?>
<span class="highlight_products_title"><?php echo __("Productos destacados")?></span>
    <?php include_partial("provider/highlight", array("products"=>$highlight_provider_products,"buyConsumer"=>@$buyConsumer,"class"=>"highlight"))?>
<?php endif;?>

<?php if (count($last_provider_products)):?>
<span class="highlight_products_title"><?php echo __("Novedades")?></span>
    <?php include_partial("provider/highlight", array("products"=>$last_provider_products,"buyConsumer"=>@$buyConsumer,"class"=>"new"))?>
<?php endif;?>