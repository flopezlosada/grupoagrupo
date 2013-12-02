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
<?php use_helper("TextPurifier","Text")?>
<?php echo link_to(image_tag(basename(sfConfig::get('sf_upload_dir'))."/".basename(sfConfig::get('sf_product_dir'))."/".basename(sfConfig::get('sf_product_thumbnail_dir'))."/".$basket->image, 
            array("alt"=>$basket->short_description, "title"=>$basket->short_description, "class"=>"provider_thumb")),"product/show_basket?basket_id=".$basket->id)?>
<?php //echo __("Este producto ha sido comprado %&% veces",array("%&%"=>$provider_product->getConsumerOrderCount()))?>
<span><?php echo link_to($basket->short_description,"product/show_basket?basket_id=".$basket->id)?></span>
<?php echo cleanPurifier(truncate_text($basket->getContent("&",ESC_RAW),100,"...",false))?>
<?php if (!$basket->hasProducts()):?>
    <?php echo link_to(image_tag("admin/basket-put", array("class"=>"group_ico")).__("Añadir productos"),'product/basket_add_product?basket_id='.$basket->id)?>
<?php endif;?>
         