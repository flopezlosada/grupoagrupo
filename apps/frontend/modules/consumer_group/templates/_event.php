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
<?php use_helper("Date")?>
<p><?php echo link_to(image_tag(basename(sfConfig::get('sf_upload_dir_name')).'/'.basename(sfConfig::get('sf_thumbnail_dir'))
    		        ."/".$event->image, array("alt"=>$event->name)).$event->name,"event/show?id=".$event->id)?></p>
		<?php if($event->end_date):?>
		<p><?php echo __("Periodo de Realización:")?> <?php echo __("Del")?> <?php echo format_datetime($event->start_date, 'U',  $sf_user->getCulture())?> <?php echo __("al") ?> 
			<?php  echo format_datetime($event->end_date, 'U',  $sf_user->getCulture())?></p>
	<?php else:?>
		<p><?php echo __("Fecha de Realización:")?> <?php echo format_datetime($event->start_date, 'U',  $sf_user->getCulture())?></p>
	<?php endif;?>
	