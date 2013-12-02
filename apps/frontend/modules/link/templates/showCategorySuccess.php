<?php
/*
© Copyright 2011 Francisco López Losada && Sodepaz
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
<?php use_helper('I18N') ?>
<h3><?php echo __("Enlaces de la categoría %&%",array("%&%"=>$category->name))?></h3>

<?php //echo image_tag("links/".sfInflector::underscore(sfInflector::camelize($category->slug)),array("class"=>"fr"))?>
<p><?php echo $category->getContent("&",ESC_RAW)?></p>
<div class="clear"></div>
<?php if ($category->haslinks()):?>  
<p><em><?php echo __('Esta categoría cuenta con ')?> <?php echo $category->getLinks();?> <?php echo __(' enlaces')?></em></p>
	<?php foreach($category->Link as $link):?>
	    <div class=link_list><?php include_partial("link/link",array("link"=>$link))?></div>
	<?php endforeach;?>
<?php else:?>
	<span class='collection_title'><?php echo __('Esta categoría no tiene enlaces')?></span>
<?php endif;?>

