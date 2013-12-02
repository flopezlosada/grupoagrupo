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
<?php use_helper("Date")?>
<?php include_partial('profile/flashes') ?>

<div class="order_list">

<?php if ($sf_user->getInternalUser()->isConsumerTrust()):?>
<h3><?php echo __("Listado de pedidos del grupo de consumo ").$sf_user->getInternalUser()->ConsumerGroup->name?></h3>
	<?php foreach($order_states as $state):?>    
        <?php if ($sf_user->getInternalUser()->isOrderState($state->id)):?>
        	<span class="state_title"><?php echo __("Pedidos en estado:")?> <?php echo $state->name?></span>        	
    		<!-- Le pasamos el valor de $i para controlar cada pedido y utilizarlo en el jquery para ocultar o mostra el pedido correspondiente -->
    	    <?php foreach($sf_user->getInternalUser()->getOrderState($state->id) as $i=>$order_trust):?>
    	        <?php include_partial("order",array("order_trust"=>$order_trust,"state"=>$state,"i"=>$i))?>    			
    	    <?php endforeach;?>
	    
	    
    	<?php endif;?>	
    <?php endforeach;?>
	
<?php else:?>
<h3><?php echo __("Listado de pedidos que gestiona la/el usuaria/o ").$sf_user->getInternalUser()->getName()?></h3>
    <?php foreach($order_states as $state):?>    
        <?php if ($sf_user->getInternalUser()->isOrderTrustState($state->id)):?>
        	<span class="state_title"><?php echo __("Pedidos en estado:")?> <?php echo $state->name?></span>
        	
        	<!-- Le pasamos el valor de $i para controlar cada pedido y utilizarlo en el jquery para ocultar o mostra el pedido correspondiente -->
        	    <?php foreach($sf_user->getInternalUser()->getOrderTrustState($state->id) as $i=>$order_trust):?>
        	        <?php include_partial("order",array("order_trust"=>$order_trust,"state"=>$state,"i"=>$i))?>    			
        	    <?php endforeach;?>
    	    
    	<?php endif;?>	
    	
    <?php endforeach;?>
<?php endif;?>	
</div>