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
<?php use_helper("Custom","jQuery","Number","jQueryValidator")?>
<script>	
$(document).ready(function() {
    $("#tabs-left").tabs()
    });
	</script>
	
<h4><?php echo __("Listado de pedidos") ?></h4>

<div id="tabs-left">
    <ul>
        <?php foreach($order_states as $i=>$state):?>
        	<?php if ($consumer_group->hasOrderState($state->id)):?>
        		<li><a href="#tabs-<?php echo $state->id?>"><?php echo $state->name?></a>
        		</li>
        	<?php endif;?>    
        <?php endforeach;?>
    </ul>
    <?php foreach($order_states as $i=>$state):?>
    	<?php if ($consumer_group->hasOrderState($state->id)):?>
            <div id="tabs-<?php echo $state->id?>">
            	<div class="header_order_list">
                	<span class="order_name_header large_title"><?php echo __("Pedido")?></span>
                	<span class="order_name_header large_title"><?php echo __("Proveedora/or")?></span>
                	<span class="order_name_header"><?php echo __("Apertura")?></span>
                	<span class="order_name_header"><?php echo __("Cierre")?></span>
                	<span class="order_name_header"><?php echo __("Precio")?></span>
                	<!--<span class="order_name_header"><?php echo __("Acciones")?></span>
                	-->
                	<div class="clear"></div>
            	</div>
        		<?php foreach ($consumer_group->getOrdersState($state->id) as $order):?>
        			<div id="content_order_<?php echo $order->id?>" class="content_order">
        			    <?php include_partial("consumer_group/order_detail",array("state"=>$state,"order"=>$order))?>
        			    <div class="clear"></div>
        			</div>	    		    	              							    
        		<?php endforeach;?>
	       	</div>    		
    	<?php endif;?>    
    <?php endforeach;?>	  
    <div class="clear"></div>  
</div>  
<?php if ($sf_user->getInternalUser()->isProviderTrust()):?>
<div class="app_links">
	<div class="admin_box"><?php echo link_to(image_tag("admin/open_order.png",array("class"=>"admin_ico")).__("Abrir pedido"),"consumer_group/providerlist?type=trust")?></div>
	<div class="clear"></div>
</div>  
<?php endif;?>