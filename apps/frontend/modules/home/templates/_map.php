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
<!--Hay que poner un slash delante de la variable $file para que encuentre el archivo-->

<div id="map" style="width: <?php echo $width?>px; height: 600px;"></div>

<script>
map = new OpenLayers.Map("map");
map.addLayer(new OpenLayers.Layer.OSM());

var lonLat = new OpenLayers.LonLat( <?php echo $city->longitude?>,<?php echo $city->latitude?> )
      .transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        map.getProjectionObject() // to Spherical Mercator Projection
      );

var zoom=6;
var pois = new OpenLayers.Layer.Text( "Usuarias/os",
        { location:"<?php echo "/".$file?>",
          projection: map.displayProjection
        });

var layer = new OpenLayers.Layer.Vector("POIs", {
    strategies: [new OpenLayers.Strategy.BBOX({resFactor: 1.1})],
    protocol: new OpenLayers.Protocol.HTTP({
        url: "<?php echo "/".$file?>",
        format: new OpenLayers.Format.Text()
    })
});
map.addLayer(layer);


map.setCenter (lonLat, zoom);

selectControl = new OpenLayers.Control.SelectFeature(layer);
map.addControl(selectControl);
selectControl.activate();
layer.events.on({
    'featureselected': onFeatureSelect,
    'featureunselected': onFeatureUnselect
});


function onPopupClose(evt) {
    // 'this' is the popup.
    var feature = this.feature;
    if (feature.layer) { // The feature is not destroyed
        selectControl.unselect(feature);
    } else { // After "moveend" or "refresh" events on POIs layer all 
             //     features have been destroyed by the Strategy.BBOX
        this.destroy();
    }
}
function onFeatureSelect(evt) {
    feature = evt.feature;
    popup = new OpenLayers.Popup.FramedCloud("featurePopup",
                             feature.geometry.getBounds().getCenterLonLat(),
                             new OpenLayers.Size(100,100),
                             "<span class='map_popup_title'>"+feature.attributes.title + "</span>" +
                             feature.attributes.description,
                             null, true, onPopupClose);
    feature.popup = popup;
    popup.feature = feature;
    map.addPopup(popup, true);
}
function onFeatureUnselect(evt) {
    feature = evt.feature;
    if (feature.popup) {
        popup.feature = null;
        map.removePopup(feature.popup);
        feature.popup.destroy();
        feature.popup = null;
    }
}
</script>
