<?php
/*
 © Copyright 2012 diphda.net && Sodepaz
info@diphda.net


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
<?php include_partial("provider/flashes")?>
<h3><?php echo __("Invitar a participar en el grupo de consumo %&%",array("%&%"=>$sf_user->getInternalUser()->ConsumerGroup->name))?></h3>
<div class="sf_apply sf_apply_settings provider_form">
<form id="consumer_group_register_form" 
	action="<?php echo url_for('consumer_group/invited')?>"
	method="post">
	<?php echo $form->renderGlobalErrors() ?>
	<?php echo $form->renderHiddenFields() ?>	
	<p><?php echo __("Indica los correos electrónicos de las personas que quieres invitar al grupo")?></p>
	<p><?php echo __("Las direcciones deben ir separadas por comas, punto y coma o cada una en una línea")?></p>
	
	<ul>
    	<li><?php echo $form["emails"]?></li>
    </ul>
<!--  <span><?php // echo __("Si quieres, puedes rellenar un mensaje de bienvenida")?></span>
        <ul>
    	    <li><?php //echo $form["body"]?></li>
        </ul> -->
    <input type="submit" value="<?php echo __("Enviar") ?>" /> 
</form>
</div>
    	