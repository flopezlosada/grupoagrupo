<?php
/*
 © Copyright 2011 diphda.net && Sodepaz
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
<div class="list_box">	
	<span><?php echo link_to($announcement->name,"@util_show_announcement?slug=".$announcement->slug)?></span>
	<?php echo link_to(image_tag(basename(sfConfig::get('sf_upload_dir_name')).'/'.basename(sfConfig::get('sf_thumbnail_dir'))
    		        ."/".$announcement->image, array("alt"=>$announcement->name, 'class'=>'admin_ico')),"@util_show_announcement?slug=".$announcement->slug)?>    
	<?php echo cleanPurifier(truncate_text($announcement->getContent("&",ESC_RAW),50,"...",true)) ?>
</div>
