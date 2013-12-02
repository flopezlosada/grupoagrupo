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
	<h3><?php echo __('Apertura de pedido con la/el proveedora/or ').$provider->name?></h3>
<?php endif;?>
<div class="sf_apply sf_apply_settings provider_form">
<form id=create_order_form
	action="<?php echo url_for('consumer_group/' . ($form->getObject()->isNew() ? 'ordered': 'updateorder') . "?provider_id=".$provider->id. 
	(!$form->getObject()->isNew() ? '&id=' . $form->getObject()->getId() : '')) ?>"
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
    		<div class="help"><?php echo $form['name']->renderHelp()?></div>                             
    	</li>
    	<li>
    		<?php echo $form['date_in']->renderError() ?>    		
    		<?php echo $form['date_in']->renderLabel() ?><?php echo $form['date_in'] ?>                                
    	</li>
    	<li>
    		<?php echo $form['date_out']->renderError() ?>    		
    		<?php echo $form['date_out']->renderLabel() ?><?php echo $form['date_out'] ?>
			<!--<div class="help"><?php //echo $form['date_out']->renderHelp()?></div>-->
    	</li>    
    	<li>
    		<?php echo $form['shipping_mode_id']->renderError() ?>    		
    		<?php echo $form['shipping_mode_id']->renderLabel() ?><?php echo $form['shipping_mode_id'] ?>                                
    	</li>
    	<li>
    		<?php echo $form['payment_method_id']->renderError() ?>    		
    		<?php echo $form['payment_method_id']->renderLabel() ?><?php echo $form['payment_method_id'] ?>                                
    	</li>
    </ul>
    <!--<span id="show_comments"><?php //echo __("Mostrar comentarios")?></span>
    --><div id="order_comments">
    	<ul>
    	<li>
    		<?php echo $form['group_comment']->renderError() ?>    		
    		<?php echo $form['group_comment']->renderLabel() ?><?php echo $form['group_comment'] ?>
    		<div class="help"><?php echo $form['group_comment']->renderHelp()?></div>                                
    	</li>
    	<li>
    		<?php echo $form['provider_comment']->renderError() ?>    		
    		<?php echo $form['provider_comment']->renderLabel() ?><?php echo $form['provider_comment'] ?>
    		<div class="help"><?php echo $form['provider_comment']->renderHelp()?></div>                                
    	</li>	
    	</ul>	
    </div>
     <div class="clear"></div>
	<p>
    	<input type="submit" value="<?php echo __("Enviar") ?>" />
    	<?php if (!$form->isNew()):?>
    	<?php echo link_to(__('Cancelar'),sfContext::getInstance()->getRequest()->getReferer())?>
    	<?php endif;?>
	</p> 
</form>
</div>
<?php echo jquery_validate_form($form, "create_order_form");?>
<script>
//Certificate name field is only required if a certificate is requested
$('#orders_name').rules('add', {
	required: true,	
	messages: {
		required: "<?php echo __("Este campo es obligatorio")?>",		
	}
});
$('#orders_date_in').rules('add', {
	required: true,
	date: true,
	messages: {
		required: "<?php echo __("Indica la fecha de apertura del pedido")?>",
		date: "<?php echo __("Indica una fecha válida")?>"
	}
});
$('#orders_date_out').rules('add', {
	required: true,
	date: true,
	messages: {
		required: "<?php echo __("Indica la fecha de cierre del pedido")?>",
		date: "<?php echo __("Indica una fecha válida")?>"
	}
});
/*$("#show_comments").click(function(){
	$("#order_comments").toggle("slow");
});*/

</script>
    