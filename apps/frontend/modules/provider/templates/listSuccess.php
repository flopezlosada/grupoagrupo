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
<?php if (count($list_providers)):?>
<ul>
    <?php foreach ($list_providers as $provider):?>
    	<li>
        	<?php echo link_to($provider->name,"provider/profile?id=".$provider->id)?> 
        	--- <?php echo number_format($internal_user->getCityDistance($provider->City),2)?> km (<?php echo $provider->City->name?> 
        	- <?php echo $provider->State->name?>)
        	<span class="tag"><?php echo link_to(image_tag("search_user", array("class"=>"group_ico")).__("Ver ficha"),"provider/profile?id=".$provider->id)?></span>        	
    	</li>
    <?php endforeach;?>
</ul>
<div id="map" style="width: 550px; height: 400px;"></div>

<script>
map = new OpenLayers.Map("map");
map.addLayer(new OpenLayers.Layer.OSM());

var lonLat = new OpenLayers.LonLat( <?php echo $internal_user->City->longitude?>,<?php echo $internal_user->City->latitude?> )
      .transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        map.getProjectionObject() // to Spherical Mercator Projection
      );

var zoom=6;
var pois = new OpenLayers.Layer.Text( "Proveedores",
        { location:"/js/openlayers/datos.txt",
          projection: map.displayProjection
        });
map.addLayer(pois);


map.setCenter (lonLat, zoom);
</script>
<?php else:?>
<?php echo __("La búsqueda no devuelve ningún resultado")?>
<?php endif;?>