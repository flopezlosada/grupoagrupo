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
<?php use_helper("Custom","jQuery","TextPurifier")?>
<?php include_partial("provider/flashes")?>
<div class="product_detail">
<h3>
     <?php echo $provider_product->short_description ?>
     <?php echo $provider_product->is_in_stock?"":__("(No disponible)")?> 
    
    <?php if ($provider_product->is_highlight):?>
    	<?php echo image_tag("admin/highlight_product.png", array("class"=>"fr","alt"=>__("Producto destacado"),"title"=>__("Producto destacado")))?>
    <?php endif;?>

</h3>
<?php if ($provider_product->Provider->getSfGuardUser()->hasPermission("distributor")&&$provider_product->Provider->getSfGuardUser()->hasPermission("producer")):?>
    <span class="production_type"><?php echo __("Este producto lo vendo como %&%",array("%&%"=>$provider_product->ProviderType->name))?></span>  
    <div class="clear"></div>  
<?php endif;?>

<?php if ($provider_product->image):?>
	<?php $image=$provider_product->image?>
<?php else:?>
	<?php $image=$provider_product->Product->image?>
<?php endif;?>

<?php echo image_tag(basename(sfConfig::get('sf_upload_dir'))."/".basename(sfConfig::get('sf_product_dir'))."/".$image, 
            array("alt"=>$provider_product->Product->name, "title"=>$provider_product->Product->name, "class"=>"provider_thumb fr"))?>
<?php if ($provider_product->getContent()):?>
	<?php $content=$provider_product->getContent("&",ESC_RAW)?>
<?php else:?>
	<?php $content=$provider_product->Product->getContent("&",ESC_RAW)?>
<?php endif;?>            
<p><strong><?php echo __("Categoría: ")?></strong><?php echo $provider_product->Product->ProductCategory->name?></p>
<p><strong><?php echo __("Subcategoría: ")?></strong><?php echo $provider_product->Product->ProductSubcategory->name?></p>


	<p><strong><?php echo __("Unidad de venta:")?></strong> <?php echo $provider_product->PurchaseUnit->name?></p>
	
	<p><?php echo __("<strong>Precio:</strong> %&% €",array("%&%"=>$provider_product->price))?></p>
	<?php /*echo $provider_product->product_size_id ? "<p>".__("Talla: %&%",array("%&%"=>$provider_product->ProductSize->name))."</p>": ''*/?>
	
<?php if ($provider_product->provider_type_id==2):?>
    <p>
        <?php echo __("<strong>Origen:</strong> %&% ",array("%&%"=>$provider_product->Country->name))?>
        <?php echo $provider_product->state_id? __('- %&%',array('%&%'=>$provider_product->State->name)):''?>
    </p>
<?php endif;?>
	<p><?php echo __("<strong>Tipo de producción:</strong> %&%",array("%&%"=>$provider_product->ProductionType->name))?></p>
	
	<strong><?php echo __("Descripción:")?></strong><br /><?php echo cleanPurifier($content)?>
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
<?php if ($sf_user->isAuthenticated()):?>
  <?php if($sf_user->getInternalUser()->id==$provider_product->Provider->id):?>
	
		<?php if ($provider_product->is_highlight):?>
		     <div class="admin_box"><?php echo link_to(image_tag("admin/remove_highlight.png", array("alt"=>__("Quitar destacado"),
		    "title"=>__("Quitar destacado"),"class"=>"admin_ico")).__("Quitar destacado"),"provider/highlight?type=remove&id=".$provider_product->id."&model=provider_product")?>	</div>	
		<?php else:?>
		    <div class="admin_box"><?php echo link_to(image_tag("admin/highlight.png", array("alt"=>__("Destacar producto"),
		    "title"=>__("Destacar producto"),"class"=>"admin_ico")).__("Destacar producto"),"provider/highlight?id=".$provider_product->id."&model=provider_product")?>   </div>
		<?php endif;?>		
		<div class="admin_box"><?php echo link_to(image_tag("admin/edit.png", array("alt"=>__("Editar producto"),
		    "title"=>__("Editar producto"),"class"=>"admin_ico")).__("Editar producto"),"product/modify?id=".$provider_product->id)?></div>
		<div class="admin_box"><?php echo link_to(image_tag("admin/product_delete.png", array("alt"=>__("Borrar producto"),
		    "title"=>__("Borrar producto"),"class"=>"admin_ico")).__("Borrar producto"),"product/delete?id=".$provider_product->id,
		"confirm=".__("Si borras el producto se borrarán todos los pedidos relacionados que no hayan sido finalizados. Tienes %&% pedidos de este producto",
		array("%&%"=>$provider_product->Provider->getOrdersProduct($provider_product->product_id))))?></div>
	    <?php if ($provider_product->is_in_stock):?>
    		<div class="admin_box"><?php echo link_to(image_tag("admin/not_available.png", array("alt"=>__("Quitar disponibilidad"),
    		    "title"=>__("Quitar disponibilidad"),"class"=>"admin_ico")).__("Quitar disponibilidad"),"product/available?id=".$provider_product->id."&type=quit&model=provider_product"
    		,"confirm=".__("El producto no se podrá comprar hasta que indiques que de nuevo está disponible, ¿Estás segura/o?"))?></div>
	    <?php else:?>
    		    <div class="admin_box"><?php echo link_to(image_tag("admin/available.png", array("alt"=>__("Poner producto disponible"),
    		    "title"=>__("Poner producto disponible"),"class"=>"admin_ico")).__("Poner producto disponible"),"product/available?id=".$provider_product->id."&model=provider_product"
    		,"confirm=".__("El producto se podrá comprar de nuevo, ¿Estás segura/o?"))?></div>
    	<?php endif;?>
		<div class="admin_box"><?php echo link_to(image_tag("admin/product_add", array("class"=>"admin_ico")).__("Añadir productos"),"product/add")?></div>
  <?php endif;?>
<?php endif;?>
<div class="clear"></div>    
</div>
</div>