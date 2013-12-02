<?php
/*
 © Copyright 2012diphda.net && sodepaz.org
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
<?php use_helper("Custom","jQuery","TextPurifier")?>
<?php include_partial("provider/flashes")?>
<div class="product_detail">
	<h3>
		<?php echo $provider_product->short_description ?>
		<?php echo $provider_product->is_in_stock?"":__("(No disponible)")?>

		<?php if ($provider_product->is_highlight):?>
		<?php echo image_tag("admin/highlight_product.png", array("class"=>"fr","alt"=>__("Cesta destacada"),"title"=>__("Cesta destacada")))?>
		<?php endif;?>

	</h3>
	<?php echo image_tag(basename(sfConfig::get('sf_upload_dir'))."/".basename(sfConfig::get('sf_product_dir'))."/".$provider_product->image,
        array("alt"=>$provider_product->short_description, "title"=>$provider_product->short_description, "class"=>"provider_thumb fr"))?>
	<p>
		<?php echo __("<strong>Precio:</strong> %&% €",array("%&%"=>$provider_product->price))?>
	</p>
	<strong><?php echo __("Descripción:")?> </strong><br />
	<?php echo cleanPurifier($provider_product->getContent("&",ESC_RAW))?>
	
	
	<?php if ($provider_product->hasProducts()):?>
	<div class="basket_product_list">	
	<span class="list_title"><?php echo __("Listado de productos de la cesta")?></span>
	<?php foreach ($provider_product->BasketProviderProduct as $provider_product_provider_product):?>
	    <?php include_partial("product/product_basket_detail",array("basket_provider_product"=>$provider_product_provider_product))?>
	<?php endforeach;?>
	</div>
	<?php endif;?>	
	<div class="clearer"></div>
	<?php if ($sf_user->getInternalClassName()=="Consumer"):?>
    <div class="order catalogue_product">	
        <?php if (isset($buyConsumer)&&$buyConsumer->canBuyProduct($provider_product->provider_id)&&$provider_product->is_in_stock):?>
            	
            <?php if (($sf_user->hasCredential("consumer")&&$sf_user->getInternalUser()->canManageOrder($order->id)&&in_array($order->order_state_id,array(1,2,6,7)))
        	||($sf_user->hasCredential("distributor")||$sf_user->hasCredential("producer"))&&in_array($order->order_state_id,array(4,5,8))||$sf_user->getInternalUser()->getId()==$buyConsumer->id&&in_array($order->order_state_id,array(1,2,6,7))):?>
            <form method="post" id="form_provider_product_order" action="<?php echo url_for('consumer_group/consumer_order_purchase?consumer_id='.$buyConsumer->id."&provider_product_id=".
		                                                $provider_product->id."&order_id=".$order->id."&redirect=true")?>">		                                                
			<label class="catalogue_medium"><?php echo __("Indica la cantidad de producto: ")?><input type="text" 
		    <?php echo $buyConsumer->hasBuyProduct($provider_product->id,$order->id)?
			'value="'.$buyConsumer->getBuyProduct($provider_product->id,$order->id)->amount.'"':''?>
			name="amount" id="amount_consumer_<?php echo $buyConsumer->id."_product_".$provider_product->product_id?>" /> 
		    <?php echo $provider_product->PurchaseUnit->name?></label>
			<label class="catalogue_short"><input type="submit" class="catalogue_add_submit" value="" title="<?php echo __("Añadir Producto")?>" /></label>
			</form>
			<?php echo javascript_tag("var form_provider_product_orderValidator = 
    		jQuery('#form_provider_product_order').validate();");?>
    		<script>            		
        		$('#amount_consumer_<?php echo $buyConsumer->id."_product_".$provider_product->product_id?>').rules('add', {
        			required: true,
        			number: true,
        			min: 0.1,
        			messages: {
        				required: "<?php echo __("Indica la cantidad de unidades de producto a comprar")?>",
        				number: "<?php echo __("Indica un número entero. <br>Para números decimales utiliza el punto y no la coma.")?>",
        				min: "<?php echo __("Debes poner un valor mayor de 0")?>"
        			}
        		});
    		</script>
		   <?php endif;?>                                  
        <?php endif;?>
    </div>
<?php endif;?>
	<div class="clearer"></div>
	<div class="consumer_group app_links">
    	<?php if ($sf_user->getInternalClassName()=="Provider"):?>
          <?php include_partial("provider/catalogue_link",array("provider"=>$provider,"text"=>"Volver al Catálogo"))?>
          <?php elseif(isset($buyConsumer)):?>
           <div class="admin_box"><?php echo link_to(image_tag("admin/catalogue.png",array("class"=>"admin_ico"))
           .__("Volver al catálogo"),"@provider_catalogue?slug=".$provider_product->Provider->slug."&buy_consumer_id=".$buyConsumer->id."&provider_id=".$provider_product->Provider->id)?></div>
          	
          <?php else:?>
          <div class="admin_box"><?php echo link_to(image_tag("admin/catalogue.png",array("class"=>"admin_ico"))
           .__("Volver al catálogo"),"@provider_catalogue?slug=".$provider_product->Provider->slug)?></div>
          	
        <?php endif;?>
	
		<?php if($sf_user->isAuthenticated()&&$sf_user->getInternalUser()->id==$provider_product->Provider->id):?>

		<?php if ($provider_product->is_highlight):?>
		<div class="admin_box">
			<?php echo link_to(image_tag("admin/remove_highlight.png", array("alt"=>__("Quitar destacado"),
			        "title"=>__("Quitar destacado"),"class"=>"admin_ico")).__("Quitar destacado"),"provider/highlight?type=remove&model=basket&id=".$provider_product->id)?>
		</div>
		<?php else:?>
		<div class="admin_box">
			<?php echo link_to(image_tag("admin/highlight.png", array("alt"=>__("Destacar cesta"),
			        "title"=>__("Destacar cesta"),"class"=>"admin_ico")).__("Destacar cesta"),"provider/highlight?id=".$provider_product->id."&model=basket")?>
		</div>
		<?php endif;?>
		<div class="admin_box">
			<?php echo link_to(image_tag("admin/edit.png", array("alt"=>__("Editar cesta"),
			        "title"=>__("Editar cesta"),"class"=>"admin_ico")).__("Editar cesta"),"product/modify_basket?id=".$provider_product->id)?>
		</div>
		<div class="admin_box">
			<?php echo link_to(image_tag("admin/product_delete.png", array("alt"=>__("Borrar cesta"),
			        "title"=>__("Borrar cesta"),"class"=>"admin_ico")).__("Borrar cesta"),"product/delete_basket?id=".$provider_product->id,
			        "confirm=".__("Si borras la cesta se borrarán todos los pedidos relacionados que no hayan sido finalizados. Tienes %&% pedidos de esta cesta",
		array("%&%"=>1)))?>
		</div>
		<?php if ($provider_product->is_in_stock):?>
		<div class="admin_box">
			<?php echo link_to(image_tag("admin/not_available.png", array("alt"=>__("Quitar disponibilidad"),
			        "title"=>__("Quitar disponibilidad"),"class"=>"admin_ico")).__("Quitar disponibilidad"),"product/available?id=".$provider_product->id."&type=quit&model=basket"
			        ,"confirm=".__("La cesta no se podrá comprar hasta que indiques que de nuevo está disponible, ¿Estás segura/o?"))?>
		</div>
		<?php else:?>
		<div class="admin_box">
			<?php echo link_to(image_tag("admin/available.png", array("alt"=>__("Poner cesta disponible"),
			        "title"=>__("Poner cesta disponible"),"class"=>"admin_ico")).__("Poner cesta disponible"),"product/available?id=".$provider_product->id."&model=basket"
			        ,"confirm=".__("La cesta se podrá comprar de nuevo, ¿Estás segura/o?"))?>
		</div>
		<?php endif;?>
        <div class="admin_box">
			<?php echo link_to(image_tag("admin/add_product_basket.png", array("alt"=>__("Añadir productos"),
			        "title"=>__("Añadir productos"),"class"=>"admin_ico")).__("Añadir productos a la cesta"),"product/basket_add_product?basket_id=".$provider_product->id)?>
		</div>
		<?php endif;?>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
    