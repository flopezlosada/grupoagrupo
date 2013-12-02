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
   
<?php echo image_tag("admin/provider_search.png",array("class"=>"fr"))?>
		<div class="search_head">
		    
			<span class="title_search"><?php echo __($title)?></span>	
			
		</div>
		
    	<form id=provider_search action="<?php echo url_for('home/search?type='.$type)?>" 	method="post">
    	    <?php if (!$form->getObject()->isNew()): ?> 
				<input type="hidden" name="sf_method" value="put" /> 
	        <?php endif; ?>
	        
    	    <?php echo $form->renderHiddenFields()?>  		
        	<?php /*echo $form['product_category_id']->renderLabel() ?>
        	<?php echo $form['product_subcategory_id']->renderLabel() ?>
        	<?php echo $form['product_id']->renderLabel() */?>
        	<div class="clear"></div>
        	<div class="label_state"><?php echo $form['product_category_id'] ?></div>
        	<div class="label_state"><?php echo $form['product_subcategory_id'] ?>	</div>    		
        	<div class="label_state"><?php echo $form['product_id'] ?>   </div> 	
        	<div class="clear"></div>
        	
        	
        	<div class="search_with_state">
        	<?php echo image_tag("admin/show.png", array("alt"=>__("Mostrar"),"title"=>__("Mostrar"), "class"=>"fr show","id"=>"show_close_search"))?>
        	            <?php echo image_tag("admin/hide.png", array("alt"=>__("Mostrar"),"title"=>__("Mostrar"), "class"=>"fr hide","id"=>"hide_close_search"))?>
        	<span class="title_search"><?php echo __("Búsqueda por cercanía")?></span>
        	<div class="close_search">
        	<p><?php echo __("Selecciona una provincia y un municipio e indica la distancia de búsqueda")?></p>
        	    <?php /*echo $form['state_id']->renderLabel() ?>
                <?php echo $form['city_id']->renderLabel() */?>
                
                <div class="clear"></div>            
            	<div class="label_state"><?php echo $form['state_id'] ?></div>
                <div class="label_state"><?php echo $form['city_id'] ?></div>
                <div class="label_state_short">
                    <?php echo $form['length']->renderLabel(null,array("class"=>"label_short")) ?>
                    <?php echo $form['length'] ?> km
                </div>
            	<div class="clear"></div>
        	</div>
        	</div>

              
        	<input type="submit" class="button_search" value="<?php echo __("Buscar") ?>" /> 
    	</form>
    	<div class="clear"></div>
	
	<?php echo jquery_validate_form($form, "provider_search");?>     
	<script>
	$('#search_provider_map_length').rules('add', {
		required: false,
		number: true,
		min: 0.1,
		messages: {
			required: "<?php echo __("Indica la distancia de búsqueda")?>",
			number: "<?php echo __("Indica un número entero")?>",
			min: "<?php echo __("Indica un valor mayor de 0")?>"
		}
	});

	$('#search_provider_map_product_category_id').rules('add', {
		required: true,	
		messages: {
		required: "<?php echo __("Indica la categoría de búsqueda")?>",		
	}
	});
	
	$('#search_provider_map_product_id').rules('add', {
		required: false,	
		messages: {
		required: "<?php echo __("Indica el producto de búsqueda")?>",		
	}
	});
	
	$('#search_provider_map_state_id').rules('add', {
		required: true,	
		messages: {
			required: "<?php echo __("Indica la provincia de búsqueda")?>",		
		}
	});

	$('#search_provider_map_city_id').rules('add', {
		required: true,	
		messages: {
			required: "<?php echo __("Indica el municipio de búsqueda")?>",		
		}
	});
		
	

		$("#show_close_search").click(function(){
			$('#search_provider_map_close_search').val(1);
			$(this).hide("slow");
			$(".close_search").show("slow");
			$("#hide_close_search").show("slow");
			$('#search_provider_map_length').rules('add', {
	    		required: false,
	    		number: true,
	    		min: 0.1,
	    		messages: {
	    			required: "<?php echo __("Indica la distancia de búsqueda")?>",
	    			number: "<?php echo __("Indica un número entero")?>",
	    			min: "<?php echo __("Indica un valor mayor de 0")?>"
	    		}
	    	});

	    	$('#search_provider_map_state_id').rules('add', {
	    		required: true,	
	    		messages: {
	    			required: "<?php echo __("Indica la provincia de búsqueda")?>",		
	    		}
	    	});

	    	$('#search_provider_map_city_id').rules('add', {
	    		required: true,	
	    		messages: {
	    			required: "<?php echo __("Indica el municipio de búsqueda")?>",		
	    		}
	    	});
		});
		
		$("#hide_close_search").click(function(){
			$('#search_provider_map_close_search').val(0);
			$('#search_provider_map_length').rules('remove');
		     $('#search_provider_map_state_id').rules('remove');
		     $('#search_provider_map_city_id').rules('remove');
			$(this).hide("slow");
			$(".close_search").hide("slow");
			$("#show_close_search").show("slow");
		});
		</script>
		<?php if (isset($close_search)):?>
    		<?php if ($close_search==1):?>
        		<script>
        		$(document).ready(function () {		 				 	
        		    $(".close_search").show("slow");
        		    $("#show_close_search").hide();
        		    $("#hide_close_search").show();
        		});		
        	</script>
        	<?php endif;?>
    	<?php endif;?>