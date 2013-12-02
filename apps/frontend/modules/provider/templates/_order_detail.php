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

<div id="order_detail_<?php echo $state->id."_".$order->id?>" class="order_detail">
<!--Si es un consumidor podrá ver los comentarios internos del grupo. Si es un proveedor los comentarios
que le manda el grupo. 
Si el pedido es rechazado, todo el mundo puede ver los comentarios que hace el proveedor al rechazo.		-->
	<?php if ($sf_user->hasCredential("consumer")):?>
		<?php if ($order->group_comment!=''):?>			
	        <?php echo __("Comentarios: ")?><span class="order_comment"><?php echo $order->group_comment?></span>
	    <?php endif;?>
    <?php else:?>
        <?php if ($order->provider_comment!=''):?>			
	        <?php echo __("Comentarios: ")?><span class="order_comment"><?php echo $order->provider_comment?></span>
	    <?php endif;?>	    	
    <?php endif;?>
    <?php if ($order->reject_comment!=''):?>			
	        <?php echo __("Pedido rechazado: ")?><span class="order_comment"><?php echo $order->reject_comment?></span>
	    <?php endif;?>    
	    
    <?php if ($order->order_state_id>2):?>
		<p><?php echo __("Fecha de confirmación:")?> <?php echo format_datetime($order->group_send_to_provider_date,"P",$sf_user->getCulture())?></p>
	<?php endif;?>	    
	<?php if ($order->order_state_id>3):?>
		<p><?php echo __("Fecha de aceptación por la/el proveedor:")?> <?php echo format_datetime($order->provider_accept_date,"P",$sf_user->getCulture())?></p>
	<?php endif;?>	         
	<?php if ($order->order_state_id>8):?>
		<p><?php echo __("Fecha de finalización del pedido por la/el proveedor:")?> <?php echo format_datetime($order->provider_finalize_date,"P",$sf_user->getCulture())?></p>
	<?php endif;?>	         	
	<?php if ($order->order_state_id>9):?>
		<p><?php echo __("Fecha de envío del pedido por la/el proveedor:")?> <?php echo format_datetime($order->provider_send_to_group_date,"P",$sf_user->getCulture())?></p>
	<?php endif;?>	  
	<?php if ($order->order_state_id>10):?>
		<p><?php echo __("Fecha de recepción del pedido por el grupo:")?> <?php echo format_datetime($order->group_receive_date,"P",$sf_user->getCulture())?></p>
	<?php endif;?>	         
	<p><?php echo __("Forma de pago:")?> <?php echo $order->PaymentMethod->name?></p>
    <p><?php echo __("Método de envío:")?> <?php echo $order->ShippingMode->name?></p>
    <?php foreach ($order->getConsumers() as $consumer):?>
    	<div class="order_consumer_detail">
        	<span class="name_consumer large_title"><?php echo $consumer->name?></span>
        	<span class="name_consumer medium_title" id="price_consumer_<?php echo $consumer->id?>_<?php echo $order->id?>">
        	<?php echo format_currency($consumer->getTotalPriceOrder($order->id),"EUR",$sf_user->getCulture())?></span>
        	
        	<?php if (($sf_user->hasCredential("consumer")&&$sf_user->getInternalUser()->canManageOrder($order->id)&&in_array($order->order_state_id,array(1,2,3)))
        	||($sf_user->hasCredential("distributor")||$sf_user->hasCredential("producer"))&&in_array($order->order_state_id,array(4,5,8))||$sf_user->getInternalUser()->getId()==$consumer->id&&in_array($order->order_state_id,array(1,2,3))):?>
        	    <?php echo link_to(image_tag("basket_add"),"@provider_catalogue?slug=".$order->Provider->slug."&buy_consumer_id=".$consumer->id,array("title"=>"Añadir productos"))?>
        	<?php endif;?>
    	    <div class="clear"></div>
        	<?php foreach ($consumer->getProductsOrders($order->id) as $consumer_order):?>
    	    	
    	    	<div class="consumer_order_product">
        	        <span class="order_name_list"><?php echo $consumer_order->ProviderProduct->short_description?></span>
        	        <span class="order_name_short"><span id="order_consumer_<?php echo $consumer_order->id?>_amount">
        	            <?php echo deleteRightZero($consumer_order->amount)?>        	            
        	        	</span>
        	            <?php echo $consumer_order->getPurchaseUnitName()?>
    	            </span>
        	             	    
        	        <?php if(in_array($state->id,$limit_state->getRawValue())):?>        	        
        	        <span class="order_name_list medium_title">
        	        	<?php if (($sf_user->hasCredential("consumer")&&$sf_user->getInternalUser()->canManageOrder($order->id))
        	        	||$sf_user->hasCredential("producer")||$sf_user->hasCredential("distributor")||$sf_user->getInternalUser()->getId()==$consumer->id):?>
                		    <?php echo image_tag("basket_edit.png",array("id"=>"modify_order_".$consumer_order->id,"class"=>"group_ico open_detail",
                				"title"=>__("Modificar Producto"),"alt"=>__("Modificar Producto")))?>
                		    <?php echo link_to(image_tag("basket-delete.png",array("id"=>"delete_order_".$consumer_order->id,"class"=>"group_ico",
                       			"title"=>__("Eliminar"),"alt"=>__("Eliminar"))),$url_delete."?consumer_order_id=".$consumer_order->id,
                        		array("onclick"=>"return confirm('".__("¿Estas segura/o?")."' )"))?>
                		<?php endif;?>
                	</span>
                	
                		<div id="order_consumer_modify_<?php echo $consumer_order->id?>" class="order_consumer_modify">        			
                            <?php echo jq_form_remote_tag(array(
                        		'update'   => 'order_consumer_'.$consumer_order->id."_amount",
                        		'url'      => $url.'?id='.$consumer_order->id,
                                ) , array("id"=>"form_modify_consumer_order_".$consumer_order->id, "name"=>"form_modify_consumer_order_".$consumer_order->id))?>
                      		<label for="amount"><?php echo __('Cantidad:')?></label>
                      		<input id ="amount_<?php echo $consumer_order->id?>" name="amount" type="text" class="amount"/>
                      		<input class="submit" type="submit" value="Modificar"/>
                    		</form>
                		</div>
            		<?php endif;?>
            		<div class="clear"></div>
        		</div>
        		<?php echo javascript_tag("var form_modify_consumer_order_".$consumer_order->id."Validator = 
        		jQuery('#form_modify_consumer_order_".$consumer_order->id."').validate();");?>
        		<script>
            		$('#modify_order_<?php echo $consumer_order->id?>').click(function() {
    	  			$('#order_consumer_modify_<?php echo $consumer_order->id?>').toggle('slow');
    				});
            		$('#amount_<?php echo $consumer_order->id?>').rules('add', {
            			required: true,
            			number: true,
            			min: 0.1,
            			messages: {
            				required: "<?php echo __("Indica la cantidad de unidades de producto a comprar")?>",
            				number: "<?php echo __("Indica un número entero. <br>Para decimales utiliza el punto y no la coma")?>",
            				min: "<?php echo __("Debes poner un valor mayor de 0")?>"
            			}
            		});
				</script>
    	    <?php endforeach;?>
    	    
	    </div>
    <?php endforeach;?>
	<script>
		$('.open_detail_<?php echo $state->id."_".$order->id?>').click(function() {
	  	$('#order_detail_<?php echo $state->id."_".$order->id?>').toggle('slow');
		});		
	</script>
	 
    <?php if(in_array($state->id,$limit_state->getRawValue())):?>
	    <?php if (($sf_user->hasCredential("consumer")&&$sf_user->getInternalUser()->canManageOrder($order->id))
	        ||$sf_user->hasCredential("producer")||$sf_user->hasCredential("distributor")):?>
    	        <?php if (count($order->getConsumerNoOrder())):?>
    	        <span class="open_detail" id="open_list_consumer_no_order"><?php echo __("Añadir productos para otras/os consumidoras/es");?></span>
    	        <?php // echo link_to(image_tag("basket_add.png", array("class"=>"group_ico")).__($order_link),"consumer_group/addProduct?order_id=".$order->id)?>
    	            <div id="list_consumer_no_order">
    	            	<?php foreach($order->getConsumerNoOrder() as $consumer):?>
    	            		<span class="name_consumer large_title"><?php echo $consumer->name?></span>
    	            		<?php echo link_to(image_tag("basket_add"),"@provider_catalogue?slug=".$order->Provider->slug."&buy_consumer_id=".$consumer->id,array("title"=>"Añadir productos"))?>
    	            		<div class="clear"></div>
    	            	<?php endforeach;?>
    	            </div>
    	            <script>
    	            $('#open_list_consumer_no_order').click(function() {
    	    		  	$('#list_consumer_no_order').toggle('slow');
    	    			});
    	            </script>	        
    	    <?php endif;?>
	    <?php endif;?>
    <?php endif;?>        
    
</div>