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
<h3><?php echo __('Perfil de la/el proveedora/or')?> <?php echo $provider->name?></h3>
<div id="personal_data">
	<p><?php echo __("Dirección: ").$provider->address?> -<?php echo $provider->cp?><br/> 
	<?php echo $provider->City->name?> (<?php echo $provider->State->name?>)<br/> 
	<?php echo __("Teléfono: ").$provider->phone?><br />
	<?php echo __("Móvil: ").$provider->celular?><br />
	<?php echo __("Email: ").$provider->email?><br />
	<?php echo __("Web: ").$provider->web?><br />
	
	<?php echo __("Fecha de participación: ").format_datetime($provider->created_at,"P",$sf_user->getCulture())?></p>
	<p><?php echo link_to(__('Modificar datos'),"register/edit?id=".$provider->id)?></p>
</div>
<div class="provider_product_list provider_list">
<?php if ($provider->hasProducts()):?>
	<?php include_partial("profile/products", array("provider"=>$provider))?>
<?php endif;?>
<p><?php echo link_to(__("Añadir productos"),"product/add")?></p>
</div>
<div class="provider_image_list provider_list">
<?php if ($provider->hasProviderImages()):?>	
	<?php include_partial("profile/images", array("provider"=>$provider))?>	
<?php endif;?>
<div class=clearer></div>
<p><?php echo link_to(__("Añadir imágenes"),"provider_image/add")?></p>
<div class=clearer></div></div>	