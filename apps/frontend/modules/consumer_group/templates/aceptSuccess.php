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
<?php use_helper("I18N", "jQuery","jQueryValidator") ?>
<?php //include_stylesheets_for_form($form)  ?>
<?php //include_javascripts_for_form($form)  ?>
<h3><?php echo __("Aceptar Proveedora/or")?></h3>
<?php if ($form->isNew()):?>
	<p><?php echo __('Selecciona a continuación la/el responsable de la/el proveedora/or.')?></p>
<?php endif;?>
<div class="sf_apply sf_apply_settings provider_form">
<form id=acept_provider_form
	action="<?php echo url_for('consumer_group/' . ($form->getObject()->isNew() ? 'acepted': 'changedtrustprovider') . 
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
    		<?php echo $form['provider_id']->renderError() ?>    		
    		<?php echo $form['provider_id']->renderLabel() ?><?php echo $form['provider_id'] ?>                                
    	</li>
    	<li>
    		<?php echo $form['consumer_group_id']->renderError() ?>    		
    		<?php echo $form['consumer_group_id']->renderLabel() ?><?php echo $form['consumer_group_id'] ?>                                
    	</li>
    	<li>
    		<?php echo $form['provider_consumer_trust_id']->renderError() ?>    		
    		<?php echo $form['provider_consumer_trust_id']->renderLabel() ?><?php echo $form['provider_consumer_trust_id'] ?>                                
    	</li>
    </ul>
    <div class="clear"></div>
    <input type="submit" value="<?php echo __("Enviar") ?>" /> 
  </form>
</div>

<?php echo jquery_validate_form($form, "acept_provider_form");?>
<script>
//Certificate name field is only required if a certificate is requested
$('#acepted_provider_consumer_group_provider_consumer_trust_id_1').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Selecciona la persona responsable")?>"
	}
});
</script>