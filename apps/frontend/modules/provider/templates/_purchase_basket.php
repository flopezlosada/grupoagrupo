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
<?php echo jq_form_remote_tag(array('update'   => 'order_consumer_detail_action',
                            				'url'      => 'consumer_group/consumer_order_purchase?consumer_id='.$buyConsumer->id."&provider_product_id=".
    		                                                $provider_product->id."&order_id=".$order->id,
                                    ), array("id"=>"form_add_consumer_".$buyConsumer->id."_product_".$provider_product->product_id.'provider_product_'.$provider_product->id, 
                                    "name"=>"form_add_consumer_".$buyConsumer->id."_product_".$provider_product->product_id.'_provider_product_'.$provider_product->id))?>
                          		
    		<label class="catalogue_medium"><input type="text" 
    		<?php echo $buyConsumer->hasBuyProduct($provider_product->id,$order->id)?
    		'value="'.$buyConsumer->getBuyProduct($provider_product->id,$order->id)->amount.'"':''?>
    		name="amount" id="amount_consumer_<?php echo $buyConsumer->id."_product_".$provider_product->product_id.'_provider_product_'.$provider_product->id?>" /> 
    		<?php echo $provider_product->PurchaseUnit->name?></label>
    		<label class="catalogue_short"><input type="submit" class="catalogue_add_submit" value="" title="<?php echo __("Añadir Producto")?>" /></label>
    		</form>
    		<?php echo javascript_tag("var form_add_consumer_".$buyConsumer->id."_product_".$provider_product->product_id.'_provider_product_'.$provider_product->id."Validator = 
    		jQuery('#form_add_consumer_".$buyConsumer->id."_product_".$provider_product->product_id."_provider_product_".$provider_product->id."').validate();");?>
    		<script>            		
        		$('#amount_consumer_<?php echo $buyConsumer->id."_product_".$provider_product->product_id.'_provider_product_'.$provider_product->id?>').rules('add', {
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