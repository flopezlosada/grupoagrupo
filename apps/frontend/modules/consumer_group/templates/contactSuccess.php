<?php
/*
© Copyright 2011 Francisco López Losada && Sodepaz
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
<div class="sf_apply sf_apply_settings provider_form">
<h3><?php echo __("Formulario de contacto")?></h3>
    <form action="<?php echo url_for('consumer_group/contacted?type='.$type)?>"	method="post">
    <?php echo $form->renderGlobalErrors() ?>
	<?php echo $form->renderHiddenFields() ?>	
        <?php echo $form?>
    	<input type="submit" value="<?php echo __("Enviar") ?>" /> 
    </form>
</div>