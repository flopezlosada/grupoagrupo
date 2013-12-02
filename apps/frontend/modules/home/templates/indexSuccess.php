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
<?php use_helper("I18N", "jQuery") ?>
<?php include_partial("provider/flashes")?>
<div class="search_list">
  
	<div class="provider_search">	 
	    <?php include_partial("home/form_search_provider",array("form"=>$form,"type"=>"provider","title"=>"Búsqueda de proveedoras/es"))?>
	</div>
	<div class="consumer_group_search">	
		<?php include_partial("home/form_search_consumer",array("form"=>$form_search,"type"=>"consumer_group","title"=>"Búsqueda de grupos de consumo"))?>
	</div>
	<div class="consumer_search">
		<?php include_partial("home/form_search_consumer",array("form"=>$form_search_consumer,"type"=>"consumer","title"=>"Búsqueda de consumidoras/es individuales"))?>		
	</div>
	<div class="clear"></div>
</div> 



<?php include_partial("home/map",array("city"=>$city,"file"=>$file,"width"=>636))?>

<div class="home_text"><?php include_partial("seo_text")?></div>          

<?php include_partial("home/social")?>