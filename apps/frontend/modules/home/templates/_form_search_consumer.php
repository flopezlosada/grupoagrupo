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
<?php use_helper("jQueryValidator") ?>

<div class="search_head">
		    <?php echo image_tag("admin/search_".$type.".png",array("class"=>"fr"))?>
			<span class="title_search"><?php echo __($title)?></span>
			
		</div>
        <form id="<?php echo $type?>_search" action="<?php echo url_for('home/search?type='.$type)?>" 	method="post">
            <?php echo $form->renderHiddenFields()?>
            <?php //echo $form['state_id']->renderLabel() ?>
            <?php echo $form['state_id'] ?>
            
            <?php //echo $form['city_id']->renderLabel() ?>
        	<?php echo $form['city_id'] ?>
        	<div class="clear"></div>
        	<?php echo $form['length']->renderLabel(null,array("class"=>"label_short")) ?>
        	<?php echo $form['length'] ?> km
        	
        	<input type="submit" class="button_search" value="<?php echo __("Buscar") ?>" /> 
        </form>
<div class="clear"></div>
<?php echo jquery_validate_form($form, $type."_search");?>        
<script>
$('#search_<?php echo $type?>_map_length').rules('add', {
	required: false,
	number: true,
	min: 0.1,
	messages: {
		required: "<?php echo __("Indica la distancia de búsqueda")?>",
		number: "<?php echo __("Indica un número entero")?>",
		min: "<?php echo __("Debes poner un valor mayor de 0")?>"
	}
});

$('#search_<?php echo $type?>_map_state_id').rules('add', {
	required: true,	
	messages: {
		required: "<?php echo __("Indica la provincia de búsqueda")?>",		
	}
});

$('#search_<?php echo $type?>_map_city_id').rules('add', {
	required: true,	
	messages: {
		required: "<?php echo __("Indica el municipio de búsqueda")?>",		
	}
});

</script>        
