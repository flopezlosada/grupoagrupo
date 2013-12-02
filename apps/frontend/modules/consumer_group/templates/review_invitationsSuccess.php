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
<?php use_helper("Date")?>
<?php include_partial("provider/flashes")?>
<div class="invitation_list">
<h3>
	<?php echo __("Listado de invitaciones válidas enviadas")?>
</h3>	
<div class="invitations_list_header">
	<label class="catalogue_large"><?php echo __("Dirección correo")?></label>
	<label class="catalogue_medium"><?php echo __("Estado")?></label>
	<label class="catalogue_medium"><?php echo __("Fecha de envío")?></label>
	<label class="catalogue_medium"><?php echo __("Fecha de activación")?></label>
	<label class="catalogue_short"><?php echo __("Acciones")?></label>
</div>

	<?php foreach ($invitations as $invitation):?>		
	    <label class="catalogue_large"><?php echo $invitation->email?> </label>
	    <label class="catalogue_medium"><?php echo __($invitation->InvitationStatus->name)?></label>	    
	    <label class="catalogue_medium"><?php echo format_datetime($invitation->created_at,"p",$sf_user->getCulture(),"utf-8")?></label>
	    <label class="catalogue_medium">
	        <?php if ($invitation->invitation_status_id==2):?>
	            <?php echo format_datetime($invitation->updated_at,"p",$sf_user->getCulture(),"utf-8")?>
	        <?php endif;?>
	    </label>
	    <?php if ($invitation->invitation_status_id==3):?>
	        <label class="catalogue_short"><?php echo link_to(image_tag("resend_invitation.png", array("alt"=>__("Reenviar"),"title"=>__("Reenviar"))),"consumer_group/resend_invitation?consumer_group_invitation_id=".$invitation->id)?></label>
	    <?php endif;?>		
	    <div class="clear"></div>
	<?php endforeach;?>
</div>
