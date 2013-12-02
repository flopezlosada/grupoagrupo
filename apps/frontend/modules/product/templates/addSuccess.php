<?php
/*
© Copyright 2011 diphda.net && Sodepaz
flopezlosada@yahoo.es


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
<?php use_helper("I18N", "jQuery","jQueryValidator") ?>
<div class="sf_apply sf_apply_settings">
<h3><?php echo __("Nuevo producto")?></h3>
<form id="provider_add_product"
	action="<?php echo url_for('product/' . ($form->getObject()->isNew() ? 'added': 'modified') . 
	(!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>"
	method="post"
	<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?> 
		<input type="hidden" name="sf_method" value="put" /> 
	<?php endif; ?>
	<?php echo $form->renderGlobalErrors() ?>
	<?php echo $form->renderHiddenFields() ?>	
	<ul>	
	
	<li><?php echo $form['product_category_id']->renderError() ?> <?php echo $form['product_category_id']->renderLabel() ?><?php echo $form['product_category_id'] ?>
	</li>
	<li><?php echo $form['product_subcategory_id']->renderError() ?> <?php echo $form['product_subcategory_id']->renderLabel() ?><?php echo $form['product_subcategory_id'] ?>
	</li>
	<li><?php echo $form['product_id']->renderError() ?> <?php echo $form['product_id']->renderLabel() ?><?php echo $form['product_id'] ?>
	<div class="help"><?php echo $form['product_id']->renderHelp()?></div>
	</li>
	<li><?php echo $form['short_description']->renderError() ?> <?php echo $form['short_description']->renderLabel() ?><?php echo $form['short_description'] ?>
    <div class="help"><?php echo $form['short_description']->renderHelp()?></div></li>
    <?php if ($sf_user->hasCredential("distributor")):?>	    
	    <?php if ($sf_user->hasCredential("producer")):?>
	    <li><?php echo $form['provider_type_id']->renderError() ?> <?php echo $form['provider_type_id']->renderLabel() ?><?php echo $form['provider_type_id'] ?>
	       <div class="help"><?php echo $form['provider_type_id']->renderHelp()?></div>	       
	    <?php endif;?>
		</li>
		<li id="provider_product_country" class="no_display"><?php echo $form['country_id']->renderError() ?> <?php echo $form['country_id']->renderLabel() ?><?php echo $form['country_id'] ?>
		</li>	
		<li id="provider_product_state" class="no_display"><?php echo $form['state_id']->renderError() ?> <?php echo $form['state_id']->renderLabel() ?><?php echo $form['state_id'] ?>
		</li>	
	
	<?php endif;?>
    <li><?php echo $form['content']->renderError() ?> <?php echo $form['content']->renderLabel() ?><?php echo $form['content'] ?>
    <div class="help"><?php echo $form['content']->renderHelp()?></div>
	</li>
	<li><?php echo $form['image']->renderError() ?> <?php echo $form['image']->renderLabel() ?><?php echo $form['image'] ?>
	<div class="help"><?php echo $form['image']->renderHelp()?></div>
	</li>
	
	<li><?php echo $form['purchase_unit_id']->renderError() ?> <?php echo $form['purchase_unit_id']->renderLabel() ?><?php echo $form['purchase_unit_id'] ?>
	</li>
	<li><?php echo $form['price']->renderError() ?> <?php echo $form['price']->renderLabel() ?><?php echo $form['price'] ?>
	<div class="help"><?php echo $form['price']->renderHelp()?></div>
	</li>	
	<li><?php echo $form['is_in_stock']->renderError() ?> <?php echo $form['is_in_stock']->renderLabel() ?><?php echo $form['is_in_stock'] ?>
	<div class="help"><?php echo $form['is_in_stock']->renderHelp()?></div>
	</li>	
	<!--<li><?php // echo $form['product_size_id']->renderError() ?> <?php //echo $form['product_size_id']->renderLabel() ?><?php //echo $form['product_size_id'] ?>
	<div class="help"><?php // echo $form['product_size_id']->renderHelp()?></div>
	</li>	
	--><li><?php echo $form['production_type_id']->renderError() ?> <?php echo $form['production_type_id']->renderLabel() ?><?php echo $form['production_type_id'] ?>
	</li>
	
	</ul>
    <input type="submit" value="<?php echo __("Enviar") ?>" /><?php echo link_to(__("Volver a tu perfil"),"profile/data")?>
</form>
</div>
<?php echo jquery_validate_form($form, "provider_add_product");?>
<script>
	
		
//Certificate name field is only required if a certificate is requested
$.validator.addMethod('integer', function(value, element, param) {
            return (value > 0) && (value == parseInt(value, 10));
        }, '<?php echo __("Introduce un número mayor que cero sin decimales")?>');

$('#provider_product_product_category_id').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Indica la categoría del producto")?>"
	}
});
$('#provider_product_short_description').rules('add', {
	required: true,
	maxlength: 150,
	messages: {
		required: "<?php echo __("Indica la descripción corta del producto")?>",
		maxlength: "<?php echo __("La longitud máxima es de 150 caracteres")?>"
	}
});
$('#provider_product_product_subcategory_id').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Indica la subcategoría del producto")?>"
	}
});
$('#provider_product_product_id').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Indica el producto")?>"
	}
});
$('#provider_product_price').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Debes indicar el precio final del producto")?>"
	}
});

$('#provider_product_short_description').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Debes indicar una pequeña descripción o nombre para el producto")?>"
	}
});
<?php if ($sf_user->hasCredential("distributor")):?>
    <?php if ($sf_user->hasCredential("producer")):?>
        $('#provider_product_provider_type_id').rules('add', {
        	required: true,
        	messages: {
        		required: "<?php echo __("Debes indicar tu actividad respecto al producto")?>"
        	}
        });
        $('#provider_product_provider_type_id').change(function(){
            var value=$(this).val();
            if (value==2)
            {
        	    $('#provider_product_country').show("blind", 1000);
        	    $('#provider_product_country_id').rules('add', {
        	    	required: true,
        	    	messages: {
        	    		required: "<?php echo __("Debes indicar el país de procedencia del producto")?>"
        	    	}
        	    });
            }  
            else
        	    if($('#provider_product_country').is(":visible"))
        		    {
        		    $('#provider_product_country').hide("blind", 1000);
        		    }
        	});
    	<?php else:?>
        $('#provider_product_country').show("blind", 1000);
        $('#provider_product_country_id').rules('add', {
	    	required: true,
	    	messages: {
	    		required: "<?php echo __("Debes indicar el país de procedencia del producto")?>"
	    	}
	    });
    	<?php endif;?>
	$('#provider_product_country_id').change(function(){
    var value_country=$(this).val();
    if (value_country==198)
    {
	    $('#provider_product_state').show("blind", 1000);
	    $('#provider_product_state_id').rules('add', {
	    	required: true,
	    	messages: {
	    		required: "<?php echo __("Debes indicar la provincia de procedencia del producto")?>"
	    	}
	    });
    }  
    else 
    	  if($('#provider_product_state').is(":visible"))
	    	  {
    		  
	    	  $('#provider_product_state').hide("blind", 1000);
	    	  $("#provider_product_state option[value='']").attr('selected', true)
	    	  }
	});
	 if($('#provider_product_state').is(":hidden"))
	 {
		 if ($('#provider_product_country_id').val()==198)
			{
			 $('#provider_product_state').show();
			}
	 }

	 if($('#provider_product_country').is(":hidden"))
	 {
		 if ($('#provider_product_provider_type_id').val()==2)
			{
			 $('#provider_product_country').show();
			}
	 }
	
<?php endif;?>

</script>
