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
<?php if ($consumer->publish_state_id==7):?>
	<?php if ($sf_user->hasCredential("consumer")&&$sf_user->getInternalUser()->belongMyConsumerGroup($consumer)):?>
		<?php include_partial("consumer",array("consumer"=>$consumer))?>
	<?php else:?>
		<p><?php echo __("El perfil de este usuario no es público")?></p>
	<?php endif;?>
<?php elseif ($consumer->publish_state_id==2):?>
	<?php if ($sf_user->isAuthenticated()):?>
	    <?php include_partial("consumer",array("consumer"=>$consumer))?>
	<?php else: ?>
		<p><?php echo __("El perfil de este usuario no es público")?></p>
	<?php endif;?>
<?php elseif ($consumer->publish_state_id==8):?>
    <p><?php echo __("El perfil de este usuario no es público")?></p>
<?php endif;?>