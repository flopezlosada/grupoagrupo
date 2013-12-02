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
<?php use_helper("jQuery","jQueryValidator")?>
<?php include_partial("provider/flashes")?>
<h3>
	<?php echo __("Añadir productos a la cesta %&%",array("%&%"=>$basket->short_description))?>
</h3>
<p><?php echo __("Selecciona los productos que quieras e indica la cantidad de producto en caso de ser necesario.")?></p>

<form id="provider_add_basket_product" action="<?php echo url_for('product/basket_added_product?basket_id='.$basket->id)?>"	method="post">

<div id="basket_product_list">

	<?php foreach ($provider_products as $i=>$provider_product):?>
    	<div class="basket_product_list"  id="content_product_provider_basket_<?php echo $provider_product->id?>">
    	    <?php echo image_tag("admin/delete_basket.png",array("id"=>"img_delete_product_provider_basket_".$provider_product->id,"class"=>"delete_product_basket","title"=>__("Quitar de la cesta")))?>
    	    <div id="product_provider_basket_<?php echo $provider_product->id?>" class="description_product_basket">
    	        <?php include_partial("product/product_basket",array("provider_product"=>$provider_product))?>
        	    
        	    <input type="hidden" name="product_selected[<?php echo $provider_product->id?>]" id ="selected_product_provider_basket_<?php echo $provider_product->id?>" value="0">
        	    <div class="detail_amount_basket"  id="detail_amount_product_provider_basket_<?php echo $provider_product->id?>">
        	        <label class="label_amount_basket"><?php echo __("Cantidad:")?></label>
        	        <input type="text" class="amount_basket" name="product[<?php echo $provider_product->id?>]"  id ="amount_product_provider_basket_<?php echo $provider_product->id?>"> <?php echo $provider_product->PurchaseUnit->name?>
        	    </div>
    	    </div>
    	            
    	    
    	</div>
    	<?php if($i>0&&($i+1)%4==0):?>    	    
    	       <div class="clear"></div>
    	    <?php endif;?>
	<?php endforeach;?>

</div>
<div class="clear"></div>
<div class="holder"></div>
<input type="submit" value="<?php echo __("Enviar") ?>" />
</form>

<script>
$(function(){
	  $("div.holder").jPages({
		    containerID : "basket_product_list",
		    first       : "<?php echo __("Primero")?>",				    
	    	previous    :"<?php echo __("Anterior")?>",
        	next        : "<?php echo __("Siguiente")?>",
        	last        : "<?php echo __("Último")?>",
        	perPage : 8
	  });	 
});

$(document).ready(function(){
    $("#provider_add_basket_product").validate({
    	groups: {username: "<?php foreach ($provider_products as $i=>$provider_product):?><?php echo " product[".$provider_product->id."]"?><?php endforeach;?>"},
    	errorPlacement: function(error, element) {error.insertBefore("#basket_product_list")},
    	});
  });


<?php foreach ($provider_products as $provider_product):?>
$("#product_provider_basket_<?php echo $provider_product->id?>").click(function(){
    $("#content_product_provider_basket_<?php echo $provider_product->id?>").addClass("selected");
    $("#img_delete_product_provider_basket_<?php echo $provider_product->id?>").show("blind");
    $("#detail_amount_product_provider_basket_<?php echo $provider_product->id?>").show("blind");
    $("#selected_product_provider_basket_<?php echo $provider_product->id?>").val("1");
    $('#amount_product_provider_basket_<?php echo $provider_product->id?>').rules('add', {
		required: false,
		number: true,
		min: 0,
		messages: {			
			number: "<?php echo __("Indica un número entero. Para números decimales utiliza el punto y no la coma.")?>",
			min: "<?php echo __("Debes poner un valor positivo")?>"
		}
	});
});


$("#img_delete_product_provider_basket_<?php echo $provider_product->id?>").click(function(){
	$("#content_product_provider_basket_<?php echo $provider_product->id?>").removeClass('selected');
	if ($(this).is (":visible")){
	    $(this).hide("blind");
	}
	$("#detail_amount_product_provider_basket_<?php echo $provider_product->id?>").hide("blind");
	$("#selected_product_provider_basket_<?php echo $provider_product->id?>").val("0");	
    $('#amount_product_provider_basket_<?php echo $provider_product->id?>').rules('remove');
    $('#amount_product_provider_basket_<?php echo $provider_product->id?>').val("");
});


<?php endforeach;?>
</script>