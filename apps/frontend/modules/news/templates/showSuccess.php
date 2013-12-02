<?php
/*
 © Copyright 2010 Francisco López Losada && Sodepaz
 flopezlosada@yahoo.es


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
<?php use_helper("Date")?>
<div id=newShow>
	<h3><?php echo $new->name?></h3>
	<p><?php echo format_datetime($new->created_at,"P",$sf_user->getCulture())?></p>
	<?php echo image_tag(basename(sfConfig::get('sf_upload_dir_name'))."/".$new->image, array("alt"=>$new->name,"class"=>"fr"))?>
	<?php echo $new->getContent("&",ESC_RAW)?>
	<div class=clearer></div>
	<?php //include_partial("news/social")?>
</div>