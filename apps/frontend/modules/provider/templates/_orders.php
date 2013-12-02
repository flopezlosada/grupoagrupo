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
<div id="tabs-left">
    <ul>
        <?php foreach($order_states as $i=>$state):?>
        	<?php if ($provider->hasOrderState($state->id)):?>
        		<li><a href="#tabs-<?php echo $state->id?>"><?php echo $state->name?></a>
        		<div class="clear"></div>
        		</li>
        	<?php endif;?>    
        <?php endforeach;?>
    </ul>
	<?php foreach($order_states as $i=>$state):?>
    	<?php if ($provider->hasOrderState($state->id)):?>
            <div id="tabs-<?php echo $state->id?>">
            	<div class="header_order_list">
            		<span class="order_name_header large_title"><?php echo __("Pedido")?></span>
                	<span class="order_name_header large_title"><?php echo __("Grupo de consumo")?></span>
                	<span class="order_name_header"><?php echo __("Apertura")?></span>
                	<span class="order_name_header"><?php echo __("Cierre")?></span>
                	<span class="order_name_header"><?php echo __("Precio")?></span>
                	<!--<span class="order_name_header"><?php echo __("Acciones")?></span>
            		-->
            		<div class="clear"></div>
            	</div>
            	
            	    <?php foreach ($provider->getOrderState($state->id) as $order):?>
            	    	<div class="content_order" id="content_order_<?php echo $order->id?>">
                			<?php if ($state->id==4):?>
                				<div class="clear"></div><span class="message_notice"  style="display:none" id="modify_<?php echo $order->id?>">
                				<?php echo __("El pedido ha sido modificado")?></span>
                			<?php endif;?> 
                			<span class="order_name large_title">
                    			<?php if (in_array($state->id,array(3,4,5,6,7,9,10,11,14))):?>
                    			  <?php echo link_to($order->name,'@orders_show?slug='.$order->slug)?>
                    			<?php else:?>
                    			  <?php echo $order->name?>
                    			<?php endif?>
                			</span>
                        	<span class="order_name large_title"><?php echo $order->ConsumerGroup->name?></span>	
                            <span class="order_name price_title"><?php echo format_datetime($order->date_in,"p",$sf_user->getCulture(),"utf-8")?></span>	
                            <span class="order_name price_title"><?php echo format_datetime($order->date_out,"p",$sf_user->getCulture(),"utf-8")?></span>
                            <span class="order_name price_title"><span id="total_price_<?php echo $order->id?>">
                            <?php echo format_currency($order->getTotalPrice(),"EUR",$sf_user->getCulture())?></span></span>
                			 <div class="clear"></div>      
                			<?php if (in_array($state->id,array(3,4,5,6,7,9,10,11,14))):?>		
                    			<div class="actions_order" id="actions_order_<?php echo $order->id?>" style="display:none">
                    			<?php if ($state->id==3):?>
                    				<?php echo link_to(image_tag("order_accept.png",array("class"=>"order_actions","alt"=>__("Aceptar Pedido"),
                    				"title"=>__("Aceptar Pedido"))).__("Aceptar"),"provider/orderaccept?order_id=".$order->id,'confirm='.__("Al aceptar el pedido estás aceptando que Grupo a Grupo lo incluya en tu cuenta de resultados y te cobre por ello. ¿Estás segura/o?"))?>
                    				<?php echo link_to(image_tag("order_reject.png",array("class"=>"order_actions","alt"=>__("Rechazar Pedido"),
                    				"title"=>__("Rechazar Pedido"))).__("Rechazar"),"provider/orderreject?order_id=".$order->id,'confirm='.__("¿Estás segura/o?"))?>
                    			<?php elseif ($state->id==4):?>
                    				<?php echo link_to(image_tag("order_go.png",array("class"=>"order_actions","alt"=>__("Finalizar Pedido"),
                    				"title"=>__("Finalizar Pedido"))).__("Finalizar"),"provider/finalizeorder?order_id=".$order->id,
                    				array('confirm'=>__("Al finalizar el pedido indicas que ya has iniciado su preparación. ¿Estás segura/o?"),"id"=>"send_order_".$order->id))?>
                    			<?php endif;?>
                    			<?php if ($state->id==4||$state->id==5):?>
                    				<span id="go_back_<?php echo $order->id?>" <?php echo $state->id==4 ? 'style="display:none"':''?>>
                    				<?php echo link_to(image_tag("order_go_back.png",array("class"=>"order_actions","alt"=>__("Retornar el pedido al grupo"),
                    				"title"=>__("Retornar el pedido al grupo"))).__("Retornar al grupo"),"provider/gobackorder?order_id=".$order->id,'confirm='.__("¿Estás segura/o?")) ?></span>
                    			<?php endif;?>
                    			<?php if ($state->id==9):?>
        	                        <?php echo link_to(image_tag("order_send.png",array("class"=>"order_actions","alt"=>__("Ya está enviado"),
        	                        "title"=>__("Ya está enviado"))).__("Ya está enviado"),"provider/sendorder?order_id=".$order->id,
        	                        'confirm='.__("Al clicar en \"Ya está enviado\" indicas que el pedido ya ha sido enviado al grupo. ¿Estás segura/o?"))?>
                    			<?php endif;?>
                    			<?php if (in_array($state->id,array(4,5,6,7,9,10,11,14))):?>
                    				<span class="open_detail open_detail_<?php echo $state->id."_".$order->id?>">
                    				<?php echo image_tag("order_detail.png",array("class"=>"order_actions","alt"=>"Ver detalle del pedido","title"=>__("Ver detalle del pedido"))).__("Detalle")?></span>            				
                    			<?php endif;?>
                    			</div>
<!--                     			<script> 
                                $("#content_order_<?php //echo $order->id?>").click(function(){
                                	$("#actions_order_<?php //echo $order->id?>").toggle("slow");                                	
                                });
                                </script>    -->                        
                				<div class="clear"></div>
                				<?php endif;?>
                				<?php if (in_array($state->id,array(4,5,6,7,9,10,11,14))):?>	
                			    <?php include_partial("provider/order_detail",array("state"=>$state,"order"=>$order,
                			    "limit_state"=>array(4,5,8),"url"=>"provider/modifyorder","url_delete"=>"provider/deleteconsumerorder"))?>
                			<?php endif;?>
                			<div class="clear"></div>
            			</div>
            			
            		<?php endforeach;?>
            		<div class="clear"></div>
        		
	       	</div>    		
    	<?php endif;?>    
    <?php endforeach;?>	
    <div class="clear"></div>
</div>	
