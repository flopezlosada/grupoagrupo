<?php
/*Página web de Espacio por un Comercio Justo
© Copyright 2010 Francisco López Losada && Sodepaz
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
<?php if (!$form->isNew()):?>
<div id=galery>
<h3><?php echo __('Lista de Noticias')?></h3>
<?php foreach ($category->getNewsList(0) as $new):?>
	<div id=imagePrev>
		<?php echo link_to(image_tag(basename(sfConfig::get('sf_upload_dir')).'/'
    	.basename(sfConfig::get('sf_thumbnail_dir')).'/'.$new->image),"news/edit?id=".$new->id)?>
    	<span><?php echo $new->name?></span>
	</div>
<?php endforeach;?>
</div>
<div id=clearer></div>
<?php endif;?>