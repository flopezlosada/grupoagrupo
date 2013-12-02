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
<?php include_partial("provider/flashes")?>
<?php if ($type=="consumer_group"):?>
		<?php $template="consumer"?>
	<?php else:?>
		<?php $template=$type?>
	<?php endif;?>
<h3><?php echo __("Resultados de la búsqueda")?></h3>
<div class="search_list">
	<div class="provider_search">	 
	<?php include_partial("home/form_search_".$template,array("form"=>$form,"type"=>$type,"title"=>$title,"close_search"=>@$close_search))?>
	</div>	
	<?php /* include_partial("home/form_search_consumer_group",array("form"=>$form_search,"type"=>"consumer_group","title"=>"Búsqueda de grupos de consumo"))?>
    <?php include_partial("home/form_search_consumer_group",array("form"=>$form_search_consumer,"type"=>"consumer","title"=>"Búsqueda de consumidoras/es individuales"))*/ ?>
	<div class="clear"></div>
</div> 
<div class="search_param">
<?php if (count($result)):?>
	
	<?php include_partial("home/search_".$template, array("result"=>$result,"search_param"=>$search_param,"type"=>$type,"file"=>$file,"city"=>$city))?>
	  

<?php else:?>
<span><?php echo __("La consulta no devuelve ningún resultado")?></span>
<?php echo link_to(__("Prueba de nuevo"),"@homepage")?>
<?php endif;?>
<div class="clear"></div>
</div>
<div class="clear"></div>


<?php if (isset($category_id)):?>
    <script>
    $('#search_provider_map_product_category_id').val(<?php echo $category_id?>);
    </script>
<?php endif;?>