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
<?php include_partial('profile/flashes') ?>
<h3><?php echo __('Perfil del grupo de consumo')?> <?php echo $consumer_group->name?></h3>
<div class="personal_data">
<div class="image_profile">
	<?php echo image_tag($consumer_group->image ? basename(sfConfig::get('sf_upload_dir')).'/'
    	.basename(sfConfig::get('sf_provider_dir')).'/'
    	.basename(sfConfig::get('sf_provider_thumbnail_dir')).'/'.$consumer_group->image:"consumer_group")?>
</div>

	<p><?php echo __("Dirección: ").$consumer_group->address?> -<?php echo $consumer_group->cp?><br/> 
	<?php echo $consumer_group->City->name?> (<?php echo $consumer_group->State->name?>)<br/> 
	<?php echo __("Email: ").$consumer_group->getEmailAddress()?><br />	
	<?php echo __("Distancia de relación: ").$consumer_group->distance?> km<br />		
	
	<?php echo __("Fecha de creación: ").format_datetime($consumer_group->created_at,"P",$sf_user->getCulture())?></p>
	<?php echo $consumer_group->getContent("&",ESC_RAW)?>
	
</div>