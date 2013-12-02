<?php
/*
 © Copyright 2011 diphda.net && Sodepaz
 flopezlosada@yahoo.es


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

<?php use_helper("I18N", "jQuery","jQueryValidator") ?>
<?php //include_stylesheets_for_form($form)  ?>
<?php //include_javascripts_for_form($form)  ?>
<div class="sf_apply sf_apply_settings provider_form">
<?php include_partial('profile/flashes') ?>
<form id=provider_register_form
	action="<?php echo url_for('register/' . ($form->getObject()->isNew() ? 'create': 'update') . 
	(!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>"
	method="post"
	<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?> 
	    <input type="hidden"	name="sf_method" value="put" /> 
	<?php endif; ?> 
	<?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>
	<?php echo $form->renderHiddenFields() ?>	
<ul>
	<li><?php echo $form['name']->renderError() ?> <?php echo $form['name']->renderLabel() ?><?php echo $form['name'] ?>
	</li>
	
	<li><?php echo $form['contact']->renderError() ?> <?php echo $form['contact']->renderLabel() ?><?php echo $form['contact'] ?>
	</li>	
	<li><?php echo $form['surname']->renderError() ?> <?php echo $form['surname']->renderLabel() ?><?php echo $form['surname'] ?>
	</li>

	
	
	<li><?php echo $form['image']->renderError() ?> <?php echo $form['image']->renderLabel() ?><?php echo $form['image'] ?>
	<div class="help"><?php echo $form['image']->renderHelp()?></div>
	</li>
	<li><?php echo $form['content']->renderError() ?> <?php echo $form['content']->renderLabel() ?><?php echo $form['content'] ?>
	</li>
	<li><?php echo $form['address']->renderError() ?> <?php echo $form['address']->renderLabel() ?><?php echo $form['address'] ?>
	</li>

	<li><?php echo $form['state_id']->renderError() ?> <?php echo $form['state_id']->renderLabel() ?><?php echo $form['state_id'] ?>
	</li>
	<li><?php echo $form['city_id']->renderError() ?> <?php echo $form['city_id']->renderLabel() ?><?php echo $form['city_id'] ?>
	</li>
	<!--<li>
    		<?php //echo $form['place_id']->renderError() ?>    		
    		<?php //echo $form['place_id']->renderLabel() ?><?php //echo $form['place_id'] ?>                                
    	</li>-->
	<li><?php echo $form['cp']->renderError() ?> <?php echo $form['cp']->renderLabel() ?><?php echo $form['cp'] ?>
	</li>
	<li><?php echo $form['phone']->renderError() ?> <?php echo $form['phone']->renderLabel() ?><?php echo $form['phone'] ?>
	</li>
	<li><?php echo $form['celular']->renderError() ?> <?php echo $form['celular']->renderLabel() ?><?php echo $form['celular'] ?>
	</li>
	<li><?php echo $form['web']->renderError() ?> <?php echo $form['web']->renderLabel() ?><?php echo $form['web'] ?>
	<div class="help"><?php echo $form['web']->renderHelp()?></div>
	</li>
	<!--<li><?php //echo $form['segregated_orders']->renderError() ?> <?php //echo $form['segregated_orders']->renderLabel() ?><?php //echo $form['segregated_orders'] ?>
	<div class="help"><?php //echo $form['segregated_orders']->renderHelp()?></div>
	</li>
	-->
	<!--<li><?php /*echo $form['publish_state_id']->renderError() ?> <?php echo $form['publish_state_id']->renderLabel() ?><?php echo $form['publish_state_id'] ?>
	<div class="help"><?php echo $form['publish_state_id']->renderHelp()*/?></div>
	</li>
	--><li><?php echo $form['shipping_mode_list']->renderError() ?> <?php echo $form['shipping_mode_list']->renderLabel() ?><?php echo $form['shipping_mode_list'] ?>
	<div class="help"><?php echo $form['shipping_mode_list']->renderHelp()?></div>
	</li>
	<li><?php echo $form['payment_method_list']->renderError() ?> <?php echo $form['payment_method_list']->renderLabel() ?><?php echo $form['payment_method_list'] ?>
	<div class="help"><?php echo $form['payment_method_list']->renderHelp()?></div>
	</li>
	

	<li><?php echo $form['information']->renderError() ?> <?php echo $form['information']->renderLabel() ?><?php echo $form['information'] ?>
	<div class="help"><?php echo $form['information']->renderHelp()?></div>
	</li>
	<?php if($form->isNew()):?>
    	<li><?php echo $form['data_protection']->renderError() ?> <?php echo $form['data_protection']->renderLabel() ?><?php echo $form['data_protection'] ?>
    	<div class="help"><?php echo $form['data_protection']->renderHelp()?></div>
    	</li>
	<?php endif;?>


</ul>
<input type="submit" value="<?php echo __("Enviar") ?>" /> 
    <?php if (!$form->isNew()):?>
    	<?php echo link_to(__('Cancelar'),"profile/data?id=".$form->getObject()->id)?>
    <?php endif;?>
</form>
</div>

<?php echo jquery_validate_form($form, "provider_register_form");?>
<script>
//Certificate name field is only required if a certificate is requested
$('#provider_name').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Indica tu nombre comercial")?>"
	}
});
$('#provider_city_id').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Indica tu municipio")?>"
	}
});
$('#provider_state_id').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Indica tu provincia")?>"
	}
});
$('#provider_data_protection').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Debes aceptar la política de protección de datos")?>"
	}
});
$('#provider_web').rules('add', {
	
	messages: {
		url: "<?php echo __("Por favor, indica una URL válida")?>"
	}
});
</script>
