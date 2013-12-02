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
<div class="clear"></div>
<script>	
$(document).ready(function() {
    $("#tabs").tabs({selected: <?php echo isset($detail)?$detail:0?>})
    });
	</script>
<div id="tabs">	
<ul>
  <li><a href="#tabs-1"><?php echo __("Resumen")?></a></li>
  <li><a href="#tabs-2"><?php echo __("Detallado")?></a></li>  
      
</ul>	
<div id='tabs-1'>
  <?php if(count($order->getAllProducts())):?>
    <div class="header_order_list">
      <span class="order_name_header big_title"><?php echo __("Producto")?></span>
      <span class="order_name_header"><?php echo __("Cantidad")?></span>
      <span class="order_name_header"><?php echo __("Precio")?></span>
      <span class="order_name_header large_title"><?php echo __("Total")?></span>
      <span class="order_name_header"><?php echo __("Consumidores")?></span>
      <div class="clear"></div>
    </div>
  <?php endif;?> 
  <?php foreach ($order->getAllProducts() as $i=>$provider_product):$odd = fmod(++$i, 2) ? 'odd' : 'even'?>
    <div class="product_resume_<?php echo $odd?>">
      <span class="order_name big_title">
        <?php echo link_to($provider_product->short_description,
        "@provider_product?provider_slug=".$provider_product->Provider->slug."&provider_product_slug=".$provider_product->slug)?>
      </span>
      <span class="order_name price_title" id="total_amount_order_<?php echo $order->id?>_provider_product_<?php echo $provider_product->id?>"><?php echo deleteRightZero($provider_product->getAmountInOrder($order->id))?> <?php echo $provider_product->PurchaseUnit->name?></span>
      <span class="order_name price_title"><?php echo format_currency($provider_product->price,"EUR",$sf_user->getCulture())?></span>
      <span class="order_name price_title large_title" id="total_order_<?php echo $order->id?>_provider_product_<?php echo $provider_product->id?>"><?php echo format_currency($provider_product->getAmountInOrder($order->id)*$provider_product->price,"EUR",$sf_user->getCulture())?></span>
      <span class="order_name price_title"><?php echo $provider_product->getConsumersInOrder($order->id)?></span>
      <div class="clear"></div>
    </div>
  <?php endforeach;?>
  <div class="order_total_price">
  <span><?php echo __("Total")?></span>
  <span class="sum_total_price_order_all_consumers"> <?php echo format_currency($order->getTotalPrice(),"EUR",$sf_user->getCulture())?></span>
  </div>
  <div class="clear"></div>
</div>
<div id="tabs-2">
    <div class="clear"></div>
    <?php if ($order->hasModifiedConsumerOrder()):?>
      <p><?php echo __("En rojo los productos que han sido modificados en el pedido")?></p>
    <?php endif;?>
    <?php foreach ($order->getConsumers() as $a=>$consumer):$odd = fmod(++$i, 2) ? 'odd' : 'even'?>
    	<div class="order_consumer_detail_<?php echo $odd?>">
        	<span class="name_consumer"><?php echo $consumer->name?></span>
        	
        	<div class="clear"></div>
        	
        	  <span class="text_header order_name_list"><?php echo __("Producto")?></span>
              <span class="order_name_list medium_title text_header"><?php echo __("Cantidad")?></span>
              <span class="order_name_short medium_title text_header"><?php echo __("Precio")?></span>
              <span class="order_name_short medium_title text_header"><?php echo __("Total")?></span>
              <?php if(in_array($state->id,$limit_state->getRawValue())):?>    
                <?php if (($sf_user->hasCredential("consumer")&&$sf_user->getInternalUser()->canManageOrder($order->id))
          	        	||$sf_user->hasCredential("producer")||$sf_user->hasCredential("distributor")||$sf_user->getInternalUser()->getId()==$consumer->id):?>
                <span class="order_name_short  medium_title text_header"><?php echo __("Acciones")?></span>
                <?php endif;?>
              <?php endif;?>
        	
        	
        	
        	
    	    <div class="clear"></div>
        	<?php foreach ($consumer->getProductsOrders($order->id) as $consumer_order):?>
    	    	
    	    	<div class="consumer_order_product <?php echo $consumer_order->hasModifyOrder()?'modified':''?>">    	    	 
        	        <span class="order_name_list"><?php echo $consumer_order->ProviderProduct->short_description?></span>        	        
        	        <span class="order_name_list medium_title"><span id="order_consumer_<?php echo $consumer_order->id?>_amount">
        	            <?php echo deleteRightZero($consumer_order->amount)?>        	            
        	        	</span>
        	            <?php echo $consumer_order->getPurchaseUnitName()?>
    	            </span>
    	            <span class="order_name_short medium_title"><?php echo format_currency($consumer_order->ProviderProduct->price,"EUR",$sf_user->getCulture())?></span>
        	        <span class="order_name_short medium_title" 
        	          id="total_provider_product_<?php echo $consumer_order->ProviderProduct->id?>_consumer_<?php echo $consumer_order->consumer_id?>">
        	        <?php echo format_currency($consumer_order->ProviderProduct->price*$consumer_order->amount,"EUR",$sf_user->getCulture())?></span>     	    
        	        <?php if(in_array($state->id,$limit_state->getRawValue())):?>        	        
        	        <span class="order_name_short medium_title">
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
                      		<label class='info' for="amount"><?php echo __('Cantidad:')?></label>
                      		<input id ="amount_<?php echo $consumer_order->id?>" name="amount" type="text" class="amount"/><br/>
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
            				number: "<?php echo __("Indica un número entero. Para decimales utiliza el punto y no la coma")?>",
            				min: "<?php echo __("Debes poner un valor mayor de 0")?>"
            			}
            		});
				</script>
    	    <?php endforeach;?>
    	    <span class="order_name_header big_title" id="price_consumer_<?php echo $consumer->id?>_<?php echo $order->id?>">
        	<?php echo __("Total Pedido: ")?><?php echo format_currency($consumer->getTotalPriceOrder($order->id),"EUR",$sf_user->getCulture())?>        	
        	</span>
        	<?php if (($sf_user->hasCredential("consumer")&&$sf_user->getInternalUser()->canManageOrder($order->id)&&in_array($order->order_state_id,array(1,2,6,7)))
        	||($sf_user->hasCredential("distributor")||$sf_user->hasCredential("producer"))&&in_array($order->order_state_id,array(4,5,8))||$sf_user->getInternalUser()->getId()==$consumer->id&&in_array($order->order_state_id,array(1,2,6,7))):?>
        	    <?php echo link_to(image_tag("basket_add"),"@provider_catalogue?slug=".$order->Provider->slug."&buy_consumer_id=".$consumer->id,array("title"=>"Añadir productos"))?>
        	<?php endif;?>
        	<div class="clear"></div>
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
    	            <ul>
    	            	<?php foreach($order->getConsumerNoOrder() as $consumer):?>
    	            		<li><span class="order_name_list large_title"><?php echo $consumer->name?></span>
    	            		<?php echo link_to(image_tag("basket_add"),"@provider_catalogue?slug=".$order->Provider->slug."&buy_consumer_id=".$consumer->id,array("title"=>"Añadir productos"))?>
    	            		</li>
    	            	<?php endforeach;?>
    	            	</ul>
    	            </div>
    	            <script>
    	            $('#open_list_consumer_no_order').click(function() {
    	    		  	$('#list_consumer_no_order').toggle('slow');
    	    			});
    	            </script>	        
    	    <?php endif;?>
	    <?php endif;?>
    <?php endif;?>     
       
    <div class="clear"></div>
  </div>
</div>