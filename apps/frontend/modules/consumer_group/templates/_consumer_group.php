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
<?php use_helper("Date")?>

<div class="personal_data">
	<p><?php echo __("Dirección: ").$consumer_group->address?> -<?php echo $consumer_group->cp?><br/> 
	<?php echo $consumer_group->City->name?> (<?php echo $consumer_group->State->name?>)<br/> 
	
	<?php echo __("Email: ").$consumer_group->email?><br />
	<?php echo __("Web: ").$consumer_group->web?><br />
<!--	<?php //echo __("Distancia de relación: ").$consumer_group->distance?> km<br />		-->
	
	<?php echo __("Fecha de creación: ").format_datetime($consumer_group->created_at,"P",$sf_user->getCulture())?></p>
	
	<div class=clearer></div>
</div>
<div class="app_links">
    <div class="admin_box">
        <?php echo link_to(image_tag("admin/mail", array("class"=>"admin_ico","title"=>__("Contactar"),
         	"alt"=>__("Contactar"))).__("Contactar"),"consumer_group/contact?id=".$consumer_group->Consumer->id."&type=member")?>
    </div>
    <?php if ($sf_user->hasCredential("consumer")):?>
        <?php if ($sf_user->getGuardUser()->Consumer->consumer_state_id==1):?>
            <div class="admin_box">
                <?php echo link_to(image_tag("admin/group_new_join_request", array("class"=>"admin_ico")).__("Pedir incorporación"),"consumer_group/joinrequest?id=".$consumer_group->id)?>
            </div>
        <?php endif;?>        	    	
    <?php endif;?>
</div>