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
<?php use_helper("jQueryValidator") ?>
<div class="sf_apply sf_apply_settings">
<h3><?php echo __("Nueva cesta de productos")?></h3>
<?php if ($form->isNew()):?>
    <span><?php echo __("Para crear una cesta de productos, el primer paso es indicar los datos generales de la cesta. Después te pediremos que incluyas los productos")?></span>
<?php endif;?>    
<form id="provider_add_basket"
	action="<?php echo url_for('product/' . ($form->getObject()->isNew() ? 'added_basket': 'modified_basket') . 
	(!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>"
	method="post"
	<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?> 
		<input type="hidden" name="sf_method" value="put" /> 
	<?php endif; ?>
	<?php echo $form->renderGlobalErrors() ?>
	<?php echo $form->renderHiddenFields() ?>	
	<ul>
	<li><?php echo $form['product_id']->renderError() ?> <?php echo $form['product_id']->renderLabel() ?><?php echo $form['product_id'] ?>
    <div class="help"><?php echo $form['product_id']->renderHelp()?></div>	
	<li><?php echo $form['short_description']->renderError() ?> <?php echo $form['short_description']->renderLabel() ?><?php echo $form['short_description'] ?>
    <div class="help"><?php echo $form['short_description']->renderHelp()?></div></li>
    
    <li><?php echo $form['content']->renderError() ?> <?php echo $form['content']->renderLabel() ?><?php echo $form['content'] ?>
    <div class="help"><?php echo $form['content']->renderHelp()?></div>
	</li>
	<li><?php echo $form['image']->renderError() ?> <?php echo $form['image']->renderLabel() ?><?php echo $form['image'] ?>
	<div class="help"><?php echo $form['image']->renderHelp()?></div>
	</li>
	<li><?php echo $form['price']->renderError() ?> <?php echo $form['price']->renderLabel() ?><?php echo $form['price'] ?>
	<div class="help"><?php echo $form['price']->renderHelp()?></div>
	</li>	
	<li><?php echo $form['is_in_stock']->renderError() ?> <?php echo $form['is_in_stock']->renderLabel() ?><?php echo $form['is_in_stock'] ?>
	<div class="help"><?php echo $form['is_in_stock']->renderHelp()?></div>
	</li>
	</ul>
    <input type="submit" value="<?php echo __("Enviar") ?>" /><?php echo link_to(__("Volver a tu perfil"),"profile/data")?>
</form>
</div>
<?php echo jquery_validate_form($form, "provider_add_basket");?>
<script>
	
$('#provider_product_short_description').rules('add', {
	required: true,
	maxlength: 150,
	messages: {
		required: "<?php echo __("Debes indicar una pequeña descripción o nombre para  la cesta")?>",
		maxlength: "<?php echo __("La longitud máxima es de 150 caracteres")?>"
	}
});

$('#provider_product_price').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Debes indicar el precio final de la cesta")?>"
	}
});
</script>
