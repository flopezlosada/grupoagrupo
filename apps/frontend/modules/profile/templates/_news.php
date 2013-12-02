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
<div class="novelty login_data">
<span><?php echo __("Novedades")?></span>
<?php echo image_tag("admin/novelty", array ("class"=>"fr"))?>
<?php if (count($providers)):?>
    <em><?php echo __("Nuevas/os proveedoras/es")?></em>
    <ul>
        <?php foreach ($providers as $provider):?>
            <li><?php echo link_to($provider->name,"@provider_profile?slug=".$provider->slug)?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>
<?php if (count($consumer_groups)):?>
    <em><?php echo __("Nuevos grupos de consumo")?></em>
    <ul>
        <?php foreach ($consumer_groups as $consumer_group):?>
            <li><?php echo link_to($consumer_group->name,"consumer_group/profile?id=".$consumer_group->id)?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>
<?php if (count($provider_products)):?>
    <em><?php echo __("Productoras/es que acaban de actualizar su catálogo")?></em>
    <ul>
        <?php foreach ($provider_products as $provider_product):?>
            <li><?php echo link_to($provider_product->Provider->name,"@provider_catalogue?slug=".$provider_product->Provider->slug)?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>
<?php if (count($new_provider_products)):?>
    <em><?php echo __("Nuevos productos en venta")?></em>
    <ul>
        <?php foreach ($new_provider_products as $provider_product):?>
            <li><?php echo link_to($provider_product->short_description,"@provider_product?provider_slug=".$provider_product->Provider->slug."&provider_product_slug=".$provider_product->slug)?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>    
<div class="clear"></div>
</div>