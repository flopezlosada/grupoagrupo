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


<div class="profile_util_list">
	<span class="util_title"><?php echo link_to(__("My %util%",array("%util%"=>$util)),"consumer_group/utilList")?></span>	
	
<?php if (count($sf_user->getGuardUser()->{ucfirst($util)})):?>
	<ul>
	<?php foreach ($sf_user->getUtils($util) as $entitie):?>
		<li><?php echo link_to(image_tag($util, array("class"=>"group_ico","alt"=>"$util", "title"=>"$util")).$entitie->name,"consumer_group/utilShow?type=$util&id=".$entitie->id)?></li>
	<?php endforeach;?>
	</ul>	
<?php endif;?>
	<p class="profile_util_add"><?php echo link_to(image_tag($util."_add", array("class"=>"group_ico","alt"=>"Add $util", "title"=>"Add $util")).__("Add $util"),"consumer_group/utilAdd?type=".$util)?></p>
</div>
