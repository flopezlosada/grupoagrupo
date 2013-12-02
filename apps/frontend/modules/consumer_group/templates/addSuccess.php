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
<?php if ($form->isNew()):?>
	<p><?php echo __('Indica a continuación los datos del nuevo grupo de consumo.')?></p>
<?php endif;?>
<div class="sf_apply sf_apply_settings provider_form">
<form id="consumer_group_register_form" 
	action="<?php echo url_for('consumer_group/' . ($form->getObject()->isNew() ? 'added': 'modified') . 
	(!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>"
	method="post"
	<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?> 
		<input type="hidden" name="sf_method" value="put" /> 
	<?php endif; ?>
	<?php echo $form->renderGlobalErrors() ?>
	<?php echo $form->renderHiddenFields() ?>	
	<ul>
    	<li>
    		<?php echo $form['name']->renderError() ?>    		
    		<?php echo $form['name']->renderLabel() ?><?php echo $form['name'] ?>                                
    	</li>
		<li>
    		<?php echo $form['content']->renderError() ?>    		
    		<?php echo $form['content']->renderLabel() ?><?php echo $form['content'] ?>                                
    	</li>
    	<li><?php echo $form['image']->renderError() ?> <?php echo $form['image']->renderLabel() ?><?php echo $form['image'] ?>
		<div class="help"><?php echo $form['image']->renderHelp()?></div>
		</li>	
    	<li>
    		<?php echo $form['email']->renderError() ?>    		
    		<?php echo $form['email']->renderLabel() ?><?php echo $form['email'] ?> 
    		<div class="help"><?php echo $form['email']->renderHelp()?></div>                               
    	</li>
    		<li>
    		<?php echo $form['web']->renderError() ?>    		
    		<?php echo $form['web']->renderLabel() ?><?php echo $form['web'] ?> 
    		<div class="help"><?php echo $form['web']->renderHelp()?></div>                               
    	</li>
    	<li>
    		<?php echo $form['address']->renderError() ?>    		
    		<?php echo $form['address']->renderLabel() ?><?php echo $form['address'] ?>                                
    	</li>
		
		<li>
    		<?php echo $form['state_id']->renderError() ?>    		
    		<?php echo $form['state_id']->renderLabel() ?><?php echo $form['state_id'] ?>                                
    	</li>	
    	<li>
    		<?php echo $form['city_id']->renderError() ?>    		
    		<?php echo $form['city_id']->renderLabel() ?><?php echo $form['city_id'] ?>                                
    	</li>
    	<!--
    	<li>
    		<?php //echo $form['distance']->renderError() ?>    		
    		<?php //echo $form['distance']->renderLabel() ?><?php //echo $form['distance'] ?>     
    		<div class="help"><?php //echo $form['distance']->renderHelp()?></div>                           
    	</li>
    	-->
    	<li>
    		<?php echo $form['cp']->renderError() ?>    		
    		<?php echo $form['cp']->renderLabel() ?><?php echo $form['cp'] ?>                                
    	</li>    
    	<!--<li><?php //echo $form['segregated_orders']->renderError() ?> <?php //echo $form['segregated_orders']->renderLabel() ?><?php //echo $form['segregated_orders'] ?>
			<div class="help"><?php //echo $form['segregated_orders']->renderHelp()?></div>
		</li>
		-->
		<li>
    		<?php echo $form['publish_state_id']->renderError() ?>    		
    		<?php echo $form['publish_state_id']->renderLabel() ?><?php echo $form['publish_state_id'] ?>                                
    	</li> 	
	</ul> 
	<input type="submit" value="<?php echo __("Enviar") ?>" /> 
	<?php if (!$form->isNew()):?>
	<?php echo link_to(__('Cancelar'),"profile/data?id=".$form->getObject()->id)?>
	<?php endif;?>
</form>
</div>
<?php echo jquery_validate_form($form, "consumer_group_register_form");?>
<script>
//Certificate name field is only required if a certificate is requested
$('#consumer_group_name').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Indica tu nombre")?>"
	}
});
$('#consumer_group_city_id').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Indica tu municipio")?>"
	}
});
$('#consumer_group_distance').rules('add', {
	required: false,
	messages: {
		required: "<?php echo __("Es necesario indicar una distancia para que el sistema sepa realizar búsquedas por cercanía")?>"
	}
});
$('#consumer_group_state_id').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Indica tu provincia")?>"
	}
});

$('#consumer_group_email').rules('add', {
	email: true,
	messages: {
		email: "<?php echo __("Por favor, indica un email válido")?>"
	}
});
</script>

