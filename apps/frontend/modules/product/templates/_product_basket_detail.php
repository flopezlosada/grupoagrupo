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
<?php use_helper("Number","Custom")?>
<div class="basket_product_detail_list">
<span class="open_detail basket_product_title"
		id="open_detail_provider_product_<?php echo $basket_provider_product->provider_product_id?>">- <?php echo $basket_provider_product->ProviderProduct->short_description?>		
		<span id="basket_provider_product_<?php echo $basket_provider_product->id?>_amount">(
		<?php if ($basket_provider_product->amount>0):?>
			<?php echo deleteRightZero($basket_provider_product->amount)." ".$basket_provider_product->ProviderProduct->PurchaseUnit->name?>
		<?php else:?>
		    <?php echo __("Cantidad sin definir")?>		
		<?php endif;?>
		)</span>
	</span>
	<?php if ($sf_user->isAuthenticated()&&$sf_user->getInternalUser()->getId()==$basket_provider_product->ProviderProduct->Provider->id):?>
	        <div class="basket_product_detail_actions">
		    <?php echo image_tag("basket_edit.png",array("id"=>"modify_order_".$basket_provider_product->id,"class"=>"group_ico open_detail",
				"title"=>__("Modificar Producto"),"alt"=>__("Modificar Producto")))?>
		    <?php echo link_to(image_tag("basket-delete.png",array("id"=>"delete_order_".$basket_provider_product->id,"class"=>"group_ico",
       			"title"=>__("Eliminar"),"alt"=>__("Eliminar"))),"product/delete_basket_product?basket_provider_product_id=".$basket_provider_product->id,
        		array("onclick"=>"return confirm('".__("¿Estas segura/o?")."' )"))?>
            	
 		    <div id="order_consumer_modify_<?php echo $basket_provider_product->id?>" class="basket_product_modify">        			
                <?php echo jq_form_remote_tag(array(
            		'update'   => 'basket_provider_product_'.$basket_provider_product->id."_amount",
            		'url'      => 'product/modify_basket_product_amount?id='.$basket_provider_product->id,
                    ) , array("id"=>"form_modify_basket_product_amount_".$basket_provider_product->id, "name"=>"form_modify_basket_product_amount_".$basket_provider_product->id))?>
          		<label for="amount"><?php echo __('Cantidad:')?></label>
          		<input id ="amount_<?php echo $basket_provider_product->id?>" name="amount" type="text" class="amount"/>
          		<input class="submit" type="submit" value="Modificar"/>
        		</form>
    		</div>
    		<?php echo javascript_tag("var form_modify_basket_product_amount_".$basket_provider_product->id."Validator = 
        		jQuery('#form_modify_basket_product_amount_".$basket_provider_product->id."').validate();");?>
    		<script>
        		$('#modify_order_<?php echo $basket_provider_product->id?>').click(function() {
        		$('#order_consumer_modify_<?php echo $basket_provider_product->id?>').toggle('blind');
        		$('#amount_<?php echo $basket_provider_product->id?>').rules('add', {
        			required: true,
        			number: true,
        			min: 0,
        			messages: {
        				required: "<?php echo __("Indica la cantidad de unidades de producto a comprar. Indica 0 si no quieres definir la cantidad.")?>",
        				number: "<?php echo __("Indica un número entero. <br>Para decimales utiliza el punto y no la coma")?>",
        				min: "<?php echo __("Debes poner un valor mayor o igual a 0")?>"
        			}
        		});
        		});
	    </script>
	    <div class="clear"></div>
	    </div> 	
	<?php endif;?>
	<div class="clear"></div>
	<div class="product_basket_detail " id="detail_provider_product_<?php echo $basket_provider_product->provider_product_id?>">
	<?php if ($sf_user->hasCredential("distributor")&&$sf_user->hasCredential("producer")):?>
    <span class="production_type"><?php echo __("Este producto lo vendo como %&%",array("%&%"=>$basket_provider_product->ProviderProduct->ProviderType->name))?></span>    
<?php endif;?>
	<?php echo image_tag(basename(sfConfig::get('sf_upload_dir'))."/".basename(sfConfig::get('sf_product_dir'))."/".basename(sfConfig::get('sf_product_thumbnail_dir'))."/".$basket_provider_product->ProviderProduct->getRealImage(), 
            array("alt"=>$basket_provider_product->ProviderProduct->Product->name, "title"=>$basket_provider_product->ProviderProduct->Product->name, "class"=>"provider_thumb fr"))?>
		<p>
			<strong><?php echo __("Categoría: ")?> </strong>
			<?php echo $basket_provider_product->ProviderProduct->Product->ProductCategory->name?>
		</p>
		<p>
			<strong><?php echo __("Subcategoría: ")?> </strong>
			<?php echo $basket_provider_product->ProviderProduct->Product->ProductSubcategory->name?>
		</p>
<?php if ($basket_provider_product->ProviderProduct->provider_type_id==2):?>
    <p>
        <?php echo __("<strong>Origen:</strong> %&% ",array("%&%"=>$basket_provider_product->ProviderProduct->Country->name))?>
        <?php echo $basket_provider_product->ProviderProduct->state_id? __('- %&%',array('%&%'=>$basket_provider_product->ProviderProduct->State->name)):''?>
    </p>
<?php endif;?>
	<p><?php echo __("<strong>Tipo de producción:</strong> %&%",array("%&%"=>$basket_provider_product->ProviderProduct->ProductionType->name))?></p>

		<?php echo cleanPurifier($basket_provider_product->ProviderProduct->getDescription("&",ESC_RAW))?>

	<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
<script>
$("#open_detail_provider_product_<?php echo $basket_provider_product->provider_product_id?>").click(function(){
		$("#detail_provider_product_<?php echo $basket_provider_product->provider_product_id?>").toggle("blind 1000");
});

</script>
