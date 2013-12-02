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
<?php if ($provider->hasCatalogue()):?>
<div class="admin_box"><?php echo link_to(image_tag("admin/catalogue.png",array("class"=>"admin_ico")) .__($text),"@provider_catalogue?slug=".$provider->slug)?></div>
<?php else:?>
<div class="admin_box"><?php echo image_tag("admin/catalogue_off.png",array("class"=>"admin_ico")) .__("No ha definido el catálogo")?></div>
<?php endif;?>