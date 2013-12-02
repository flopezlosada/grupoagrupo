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
<?php use_helper("Date")?>
<h3><?php echo __('Perfil de la/el consumidora/or')?> <?php echo $consumer->name?></h3>
<div class="personal_data">
<div class="image_profile">
	<?php echo image_tag($consumer->image ? basename(sfConfig::get('sf_upload_dir')).'/'
    	.basename(sfConfig::get('sf_provider_dir')).'/'
    	.basename(sfConfig::get('sf_provider_thumbnail_dir')).'/'.$consumer->image:"consumer")?>
</div>

	<p><?php echo __("Dirección: ").$consumer->address?> -<?php echo $consumer->cp?><br/> 
	<?php echo $consumer->City->name?> (<?php echo $consumer->State->name?>)<br/> 
	<?php echo __("Teléfono: ").$consumer->phone?><br />
	<?php echo __("Móvil: ").$consumer->celular?><br />
	<?php echo __("Email: ").$consumer->email?><br />
	<?php echo __("Web: ").$consumer->web?><br />
	<?php echo __("Distancia de relación: ").$consumer->distance?> km<br />		
	
	<?php echo __("Fecha de participación: ").format_datetime($consumer->created_at,"P",$sf_user->getCulture())?></p>
	<p>
		<span class=consumer_group_access><?php echo link_to(image_tag("edit",array("class"=>"group_ico")).__('Modificar mis datos'),"register/edit?id=".$consumer->id)?></span>
    	<?php if($consumer->belongConsumerGroup()):?>
    	<span class=consumer_group_access><?php echo link_to(image_tag("group",array("class"=>"group_ico")).__('Acceder a tu grupo de consumo'),"consumer_group/show?id=".$consumer->ConsumerGroup->id)?></span>
   		<?php endif;?>
	</p>
	<div class=clearer></div>
</div>
<?php if (sfConfig::get("app_utilities_list")):?>
    <?php $utilities=sfConfig::get("app_utilities_list")?>
<?php endif;?>
<div class="my_utilities">
	<?php foreach ($utilities as $util):?>
		<?php include_partial("profile/util",array("util"=>$util, "internal_user"=>$consumer))?>
	<?php endforeach;?>
	<div class=clearer></div>
</div>
