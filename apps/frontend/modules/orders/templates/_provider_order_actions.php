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
<?php //'confirm='.__("Al aceptar el pedido estás aceptando que Grupo a Grupo lo incluya en tu cuenta de resultados y te cobre por ello. ¿Estás segura/o?"?>
<ul>
<?php if ($state->id==3):?>
	<li><?php echo link_to(image_tag("order_accept.png",array("class"=>"order_actions_img","alt"=>__("Aceptar Pedido"),
	"title"=>__("Aceptar Pedido"))).__("Aceptar"),"provider/orderaccept?order_id=".$order->id,
	    'confirm='.__("¿Estás segura/o?"))?>
	<?php echo link_to(image_tag("order_reject.png",array("class"=>"order_actions_img","alt"=>__("Rechazar Pedido"),
	"title"=>__("Rechazar Pedido"))).__("Rechazar"),"provider/orderreject?order_id=".$order->id,'confirm='.__("¿Estás segura/o?"))?></li>
<?php elseif ($state->id==4):?>
	<li><?php echo link_to(image_tag("order_go.png",array("class"=>"order_actions_img","alt"=>__("Finalizar Pedido"),
	"title"=>__("Finalizar Pedido"))).__("Finalizar"),"provider/finalizeorder?order_id=".$order->id,
	array('confirm'=>__("Al finalizar el pedido indicas que ya has iniciado su preparación. ¿Estás segura/o?"),"id"=>"send_order_".$order->id))?></li>
<?php endif;?>
<?php if ($state->id==4||$state->id==5):?>
	<li><span id="go_back_<?php echo $order->id?>" <?php echo $state->id==4 ? 'style="display:none"':''?>>
	<?php echo link_to(image_tag("order_go_back.png",array("class"=>"order_actions_img","alt"=>__("Retornar el pedido al grupo"),
	"title"=>__("Retornar el pedido al grupo"))).__("Retornar al grupo"),"provider/gobackorder?order_id=".$order->id,'confirm='.__("¿Estás segura/o?")) ?></span></li>
<?php endif;?>
<?php if ($state->id==9):?>
        <li><?php echo link_to(image_tag("order_send.png",array("class"=>"order_actions_img","alt"=>__("Ya está enviado"),
        "title"=>__("Ya está enviado"))).__("Ya está enviado"),"provider/sendorder?order_id=".$order->id,
        'confirm='.__("Al clicar en \"Ya está enviado\" indicas que el pedido ya ha sido enviado al grupo. ¿Estás segura/o?"))?></li>
<?php endif;?>
  <li><?php echo link_to(image_tag('mail_p',array("class"=>"order_actions_img","alt"=>__("Contactar con el grupo"),
        "title"=>__("Contactar con el grupo"))).__("Contactar con el grupo"),'consumer_group/contact?id='.$order->ConsumerGroup->id."&type=group",array('title'=>__("Contactar")))?></li>
<?php if ($state->id>3):?>
    	    <li><?php echo link_to(image_tag("admin/order_print.png",array("class"=>"order_actions_img","title"=>__("Imprimir pedido"),
	    	"alt"=>__("Imprimir Pedido"))).__("Imprimir pedido"),"orders/print?slug=".$order->slug)?></li>
	    <?php endif;?>        
</ul>