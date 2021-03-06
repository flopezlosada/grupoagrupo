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
<!-- <div class="actions_order" id="actions_order_<?php echo $order->id?>" style="display:none">-->
<ul>
	<?php if($sf_user->getInternalUser()->canManageOrder($order->id)):?>
	   <?php if ($state->id==13):?>
	    	<li><?php echo link_to(image_tag("admin/order_edit_ico",array("class"=>"order_actions_img","title"=>__("Editar Pedido"),
	    	"alt"=>__("Editar Pedido"))).__("Editar"),"consumer_group/openorder?id=".$order->id."&provider_id=".$order->provider_id)?></li>
	    	<li><?php echo link_to(image_tag("admin/order_extend",array("class"=>"order_actions_img","title"=>__("Modificar fechas"),
	    	"alt"=>__("Modificar fechas"))).__("Modificar fechas"),"consumer_group/extendorder?id=".$order->id."&provider_id=".$order->provider_id)?></li>
	    	<li><?php echo link_to(image_tag("admin/order_delete.png",array("class"=>"order_actions_img","title"=>__("Eliminar pedido"),
	    	"alt"=>__("Eliminar pedido"))).__("Eliminar"),"consumer_group/deleteorder?order_id=".$order->id,
	    	"confirm=".__("Si eliminas el pedido, no podrás editarlo ni enviarlo a tu proveedora/or. ¿Estás segura/o?"))?></li>
	   <?php elseif ($state->id==1):?>
	    	<li><?php echo link_to(image_tag("admin/order_edit_ico",array("class"=>"order_actions_img","title"=>__("Editar Pedido"),
	    	"alt"=>__("Editar Pedido"))).__("Editar"),"consumer_group/openorder?id=".$order->id."&provider_id=".$order->provider_id)?></li>
	    	<li><?php echo link_to(image_tag("admin/order_close",array("class"=>"order_actions_img","title"=>__("Cerrar Pedido"),
	    	"alt"=>__("Cerrar Pedido"))).__("Cerrar"),"consumer_group/stateorder?state_id=2&order_id=".$order->id,
	    	"confirm=".__(" Al cerrar el pedido las/os miembros de tu grupo ya no podrán editar su pedido individual 
            (aunque el miembro responsable de esta/e proveedora/or sí podrá hacerlo). ¿Estás segura/o?"))?></li>
	    	<li><?php echo link_to(image_tag("admin/order_extend",array("class"=>"order_actions_img","title"=>__("Modificar fechas"),
	    	"alt"=>__("Modificar fechas"))).__("Modificar fechas"),"consumer_group/extendorder?id=".$order->id."&provider_id=".$order->provider_id)?></li>
	    	<li><?php echo link_to(image_tag("admin/order_delete.png",array("class"=>"order_actions_img","title"=>__("Eliminar pedido"),
	    	"alt"=>__("Eliminar pedido"))).__("Eliminar"),"consumer_group/deleteorder?order_id=".$order->id,
	    	"confirm=".__("Si eliminas el pedido, no podrás editarlo ni enviarlo a tu proveedora/or. ¿Estás segura/o?"))?>    	    </li>
	                     
        <?php elseif($state->id==2):?>
	    	<li><?php echo link_to(image_tag("admin/order_edit_ico",array("class"=>"order_actions_img","title"=>__("Editar Pedido"),
	    	"alt"=>__("Editar Pedido"))).__("Editar"),"consumer_group/openorder?id=".$order->id."&provider_id=".$order->provider_id)?></li>
	        <li><?php echo link_to(image_tag("admin/order_go",array("class"=>"order_actions_img","title"=>__("Confirmar Pedido"),
	        "alt"=>__("Confirmar Pedido"))).__("Confirmar"),"consumer_group/stateorder?state_id=3&order_id=".$order->id
	        ,"confirm=".__("Al confirmar el pedido se lo harás llegar a tu proveedora/or. ¿Estás segura/o?"))?></li>
	        <li><?php echo link_to(image_tag("admin/order_extend",array("class"=>"order_actions_img","title"=>__("Modificar fechas"),
	        "alt"=>__("Modificar fechas"))).__("Modificar fechas"),"consumer_group/extendorder?id=".$order->id."&provider_id=".$order->provider_id)?></li>
	        <li><?php echo link_to(image_tag("admin/order_delete.png",array("class"=>"order_actions_img","title"=>__("Eliminar pedido"),
	    	"alt"=>__("Eliminar pedido"))).__("Eliminar"),"consumer_group/deleteorder?order_id=".$order->id,
	    	"confirm=".__("Si eliminas el pedido, no podrás editarlo ni enviarlo a tu proveedora/or. ¿Estás segura/o?"))?></li>
	    <?php elseif ($state->id==3):?>
	        <li><?php echo link_to(image_tag("admin/order_delete.png",array("class"=>"order_actions_img","title"=>__("Eliminar pedido"),
	    	"alt"=>__("Eliminar pedido"))).__("Eliminar"),"consumer_group/deleteorder?order_id=".$order->id,
	    	"confirm=".__("Si eliminas el pedido, no podrás editarlo ni enviarlo a tu proveedora/or. ¿Estás segura/o?"))?>	</li>
	    <?php elseif ($state->id==6):?>	    	
	        <li><?php echo link_to(image_tag("admin/order_validate.png",array("class"=>"order_actions_img","title"=>__("Validar Pedido"),
	        "alt"=>__("Validar Pedido"))).__("Validar"),"consumer_group/stateorder?state_id=4&order_id=".$order->id,array("id"=>"send_order_".$order->id,
	        "confirm"=>__("Al clicar en \"Validar\" indicáis que aceptáis los cambios propuestos por la/el proveedora/or. ¿Estás segura/o?")))?></li>
	     <?php elseif ($state->id==10):?>	    	
	        <li><?php echo link_to(image_tag("admin/order_received.png",array("class"=>"order_actions_img","title"=>__("Pedido Recibido"),
	        "alt"=>__("Pedido Recibido"))).__("Recibido"),"consumer_group/stateorder?state_id=11&order_id=".$order->id,array("id"=>"send_order_".$order->id,
	        "confirm"=>__("Al clicar en \"Recibido\" indicáis que ya tenéis la mercancía. ¿Está segura/o?")))?></li>    	       
	    <?php endif;?>
	    <?php if ($state->id==6||$state->id==7):?>
	        <li><span id="go_back_<?php echo $order->id?>" <?php echo $state->id==6 ? 'style="display:none"':''?>>
	        <?php echo link_to(image_tag("admin/order_go_back.png",array("class"=>"order_actions_img","title"=>__("Confirmar de nuevo el pedido"),
	        "alt"=>__("Confirmar de nuevo el pedido"))).__("Reconfirmar")
	        ,"consumer_group/gobackorder?order_id=".$order->id,"confirm=".__("Al clicar en \"Reconfirmar\" indicáis que aceptáis los cambios propuestos por la/el proveedora/or. ¿Estás segura/o?")) ?></span></li>	    
	    <?php endif;?>	    
    <?php endif;?>   
    <?php if ($state->id>1):?>
    	    <li><?php echo link_to(image_tag("admin/order_print.png",array("class"=>"order_actions_img","title"=>__("Imprimir pedido"),
	    	"alt"=>__("Imprimir Pedido"))).__("Imprimir pedido"),"orders/print?slug=".$order->slug)?></li>
	    <?php endif;?>
    <?php if ($state->id==1):?>
        <?php if ($sf_user->getInternalUser()->hasStartOrder($order->id)):?>
    	   	<?php $order_link="Continuar tu pedido";?>
	    <?php else:?>
    	   	<?php $order_link="Hacer tu pedido";?>
	    <?php endif;?>	        
	    <li><?php echo link_to(image_tag("basket_add.png", array("class"=>"order_actions_img")).__($order_link),"@provider_catalogue?slug=".$order->Provider->slug,array("title"=>__($order_link)))?></li>
	<?php endif;?>
	<li><?php echo link_to(image_tag('mail_p',array("class"=>"order_actions_img","title"=>__("Contactar con la/el proveedora/or"),
	        "alt"=>__("Contactar con la/el proveedora/or"))).__("Contactar con la/el proveedora/or"),'consumer_group/contact?id='.$order->Provider->id."&type=provider",array('title'=>__("Contactar")))?></li>
</ul>  