<?php
/*
© Copyright 2011 diphda.net && Sodepaz
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
<h3><?php echo __("Nuevo Archivo")?></h3>
<div class="sf_apply sf_apply_settings provider_form">
<form
	action="<?php echo url_for(sfContext::getInstance()->getModuleName().'/' . ($form->getObject()->isNew() ? 'utilAdded': 'utilUpdate') . '?type='.$type.
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
    		<?php echo $form[$sf_user->getCulture()]['name']->renderError() ?>    		
    		<?php echo $form[$sf_user->getCulture()]['name']->renderLabel() ?><?php echo $form[$sf_user->getCulture()]['name'] ?>                                
    	</li>
    	<li>
    		<?php echo $form[$sf_user->getCulture()]['content']->renderError() ?>    		
    		<?php echo $form[$sf_user->getCulture()]['content']->renderLabel() ?><?php echo $form[$sf_user->getCulture()]['content'] ?>                                
    	</li>
    	<li>
    		<?php echo $form['file']->renderError() ?>    		
    		<?php echo $form['file']->renderLabel() ?><?php echo $form['file'] ?>                                
    	</li>
    	<li>
    		<?php echo $form['published']->renderError() ?>    		
    		<?php echo $form['published']->renderLabel() ?><?php echo $form['published'] ?>    
   			<div class="help"><?php echo $form['published']->renderHelp() ?></div> 		                           
    	</li>
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