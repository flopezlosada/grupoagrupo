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

<?php use_helper("TextPurifier","Text")?>
<?php if ($provider_product->image):?>
	<?php $image=$provider_product->image?>
<?php else:?>
	<?php $image=$provider_product->Product->image?>
<?php endif;?>
<?php echo link_to(image_tag(basename(sfConfig::get('sf_upload_dir'))."/".basename(sfConfig::get('sf_product_dir'))."/".basename(sfConfig::get('sf_product_thumbnail_dir'))."/".$image, 
            array("alt"=>$provider_product->Product->name, "title"=>$provider_product->short_description, "class"=>"provider_thumb")),
            isset($buyConsumer)?"@provider_product?provider_slug=".$provider_product->Provider->slug."&provider_product_slug=".$provider_product->slug."&buy_consumer_id=".$buyConsumer->id:"@provider_product?provider_slug=".$provider_product->Provider->slug."&provider_product_slug=".$provider_product->slug)?>
<?php //echo __("Este producto ha sido comprado %&% veces",array("%&%"=>$provider_product->getConsumerOrderCount()))?>
<span><?php echo link_to($provider_product->short_description." (".$provider_product->Product->ProductCategory->name.")",
        isset($buyConsumer)?"@provider_product?provider_slug=".$provider_product->Provider->slug."&provider_product_slug=".$provider_product->slug."&buy_consumer_id=".$buyConsumer->id:"@provider_product?provider_slug=".$provider_product->Provider->slug."&provider_product_slug=".$provider_product->slug)?></span>
<?php echo cleanPurifier(truncate_text($provider_product->getDescription("&",ESC_RAW),100,"...",false))?>
            