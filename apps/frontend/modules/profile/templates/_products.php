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
<?php $month=sfConfig::get("app_month_list")?>
<span class="title">Listado de productos</span>
<ul class="provider_product_list">
    <?php foreach ($provider->ProviderProduct as $product):?>
    	<li><span><?php echo $product->Product->name?></span>
    	<?php if ($product->image):?>
    		<?php $image=$product->image?>
    	<?php else:?>
    		<?php $image=$product->Product->image?>
    	<?php endif;?>
    	<?php echo image_tag(basename(sfConfig::get('sf_upload_dir'))."/".basename(sfConfig::get('sf_product_dir'))."/"
            .basename(sfConfig::get('sf_product_thumbnail_dir')).'/'.$image, 
            array("alt"=>$product->Product->name, "title"=>$product->Product->name, "class"=>"provider_thumb"))?>
    	<?php echo link_to(image_tag("edit", array("class"=>"image_icon","alt"=>__("Editar"), "title"=>__('Editar'))),"product/modify?id=".$product->id)?>
    	<?php echo link_to(image_tag("delete", array("class"=>"image_icon","alt"=>__("Borrar"), "title"=>__('Borrar'))),"product/delete?id=".$product->id)?>
    	<br />
    	<?php echo __("Inicio de temporada: ").$month[$product->seasson_start]?><br/>
    	<?php echo __("Fin de temporada: ").$month[$product->seasson_end]?>
    	</li>
    	
    <?php endforeach;?>
</ul>