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
<?php if ($form->isNew()):?>
	<p><?php echo __('Indica a continuación los datos del pedido.')?></p>
<?php endif;?>
<div class="sf_apply sf_apply_settings provider_form">
<form id=consumer_add_product_form
	action="<?php echo url_for('consumer/' . ($form->getObject()->isNew() ? 'added': 'modified') ."?product_id=".$product->id. 
	(!$form->getObject()->isNew() ? '&consumer_order_id=' . $form->getObject()->getId() : '')) ?>"
	method="post"
	<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?> 
		<input type="hidden" name="sf_method" value="put" /> 
	<?php endif; ?>
	<?php echo $form->renderGlobalErrors() ?>
	<?php echo $form->renderHiddenFields() ?>	
	<ul>
    	<li>
    		<?php echo $form['product_id']->renderError() ?>    		
    		<?php echo $form['product_id']->renderLabel() ?><?php echo $form['product_id'] ?>                                
    	</li>
    	<li>
    		<?php echo $form['provider_id']->renderError() ?>    		
    		<?php echo $form['provider_id']->renderLabel() ?><?php echo $form['provider_id'] ?>                                
    	</li>
    	<li>
    		<?php echo $form['amount']->renderError() ?>    		
    		<?php echo $form['amount']->renderLabel() ?><?php echo $form['amount'] ?>  
    		<div class="help"><?php echo $form['amount']->renderHelp()?></div>                              
    	</li>
    </ul>
   <input type="submit" value="<?php echo __("Enviar") ?>" /> 
	<?php if (!$form->isNew()):?>
	<?php echo link_to(__('Cancelar'),"profile/data?id=".$form->getObject()->id)?>
	<?php endif;?>
</form>
</div>
<?php echo jquery_validate_form($form, "consumer_add_product_form");?>
<script>
//Certificate name field is only required if a certificate is requested
$('#consumer_order_amount').rules('add', {
	required: true,
	number: true,
	messages: {
		required: "<?php echo __("Indica la cantidad de unidades de producto a comprar")?>",
		number: "<?php echo __("Indica un número entero")?>"
	}
});

</script>

   