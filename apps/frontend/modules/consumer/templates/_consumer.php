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
<h3><?php echo __('Perfil de la/el consumidora/or')?> <?php echo $consumer->name?></h3>
<div class="personal_data">

	<?php echo image_tag($consumer->image ? basename(sfConfig::get('sf_upload_dir')).'/'
    	.basename(sfConfig::get('sf_provider_dir')).'/'
    	.basename(sfConfig::get('sf_provider_thumbnail_dir')).'/'.$consumer->image:"consumer", array("class"=>"fr"))?>


	<p>
<!--	<?php  //echo __("Dirección: ").$consumer->address?> -<?php //echo $consumer->cp?><br/> -->
	<?php echo $consumer->City->name?> (<?php echo $consumer->State->name?>)<br/> 
<!--	<?php // echo __("Teléfono: ").$consumer->phone?><br />-->
<!--	<?php //echo __("Móvil: ").$consumer->celular?><br />	-->
	<?php echo __("Web: ").$consumer->web?><br />
<!--	<?php //echo __("Distancia de relación: ").$consumer->distance?> km<br />		-->
	
	<?php echo __("Fecha de participación: ").format_datetime($consumer->created_at,"P",$sf_user->getCulture())?></p>
	
	<div class=clearer></div>
</div>
<div class="app_links">
    <div class="admin_box">
        <?php echo link_to(image_tag("admin/mail", array("class"=>"admin_ico","title"=>__("Contactar"),
    	"alt"=>__("Contactar"))).__("Contactar"),"consumer_group/contact?id=".$consumer->id."&type=member")?>
    </div>
    <div class="clear"></div>
</div>