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
<span class="title">Listado de imágenes</span>
<?php foreach ($provider->ProviderImage as $image):?>
	<div class='linkThumbImg'>
        <?php echo image_tag(basename(sfConfig::get('sf_upload_dir'))."/"
            .basename(sfConfig::get('sf_thumbnail_dir')).'/'.$image->image, 
            array("alt"=>$image->name, "title"=>$image->name, "class"=>"provider_thumb"));?>          
	<span><?php echo link_to($image->getName("&",ESC_RAW),"provider_image/show?id=".$image->id);?></span>
	</div>
	

	<?php endforeach;?>
