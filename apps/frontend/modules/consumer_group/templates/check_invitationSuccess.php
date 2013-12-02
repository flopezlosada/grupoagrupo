<?php
/*
 © Copyright 2012diphda.net && sodepaz.org
info@diphda.net
sodepaz@sodepaz.org


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
<?php if(!$sf_user->isAuthenticated()):?>
    <?php if ($invitation->invitation_status_id==1):?>
        <div class="sf_apply sf_apply_settings provider_form">
            <p><span><?php echo __("Has recibido una invitación para participar en el grupo de consumo %&%.",array("%&%"=>$invitation->ConsumerGroup->name)) ?></span></p>
            <p><span><?php echo __("Para activar la invitación, en primer lugar debes elegir un nombre de usuaria/o y contraseña. ")?></span></p>
            <form id="consumer_group_register_form" 
            	action="<?php echo url_for('consumer_group/checked_invitation?code='.$invitation->invitation_code)?>"
            	method="post">
            	<?php echo $form->renderGlobalErrors() ?>
            	<?php echo $form->renderHiddenFields() ?>	
                <ul>
                	<li><?php echo $form["username"]->renderError()?><?php echo $form["username"]->renderLabel()?><?php echo $form["username"]?></li>
                	<li><?php echo $form["password"]->renderError()?><?php echo $form["password"]->renderLabel()?><?php echo $form["password"]?></li>
                	<li><?php echo $form["password2"]->renderError()?><?php echo $form["password2"]->renderLabel()?><?php echo $form["password2"]?></li>
                </ul>
                <input type="submit" value="<?php echo __("Enviar") ?>" /> 
            </form>
        </div>
    <?php endif;?>
<?php endif;?>
