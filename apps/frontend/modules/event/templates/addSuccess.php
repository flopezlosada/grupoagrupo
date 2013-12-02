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
<?php use_helper("I18N", "jQuery","jQueryValidator") ?>
<h3><?php echo __($form->isNew()? 'Nuevo Evento':'Editar Evento %&%',array('%&%'=>$form->getObject()->name))?> </h3>
<div class="sf_apply sf_apply_settings provider_form">
<form id="add_event_form"
	action="<?php echo url_for(sfContext::getInstance()->getModuleName().'/' . ($form->getObject()->isNew() ? 'added': 'update') .
	(!$form->getObject()->isNew() ? '?slug=' . $form->getObject()->getSlug() : '')) ?>"
	method="post"
	<?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<?php if (!$form->getObject()->isNew()): ?> 
		<input type="hidden" name="sf_method" value="put" /> 
	<?php endif; ?>
	<?php echo $form->renderGlobalErrors() ?>
	<?php echo $form->renderHiddenFields() ?>	
	<ul>
	    <li>
    		<?php echo $form['event_category_id']->renderError() ?>    		
    		<?php echo $form['event_category_id']->renderLabel() ?><?php echo $form['event_category_id'] ?>                                
    	</li>
    	<li>
    		<?php echo $form[$sf_user->getCulture()]['name']->renderError() ?>    		
    		<?php echo $form[$sf_user->getCulture()]['name']->renderLabel() ?><?php echo $form[$sf_user->getCulture()]['name'] ?>                                
    	</li>
    	<li>
    		<?php echo $form[$sf_user->getCulture()]['content']->renderError() ?>    		
    		<?php echo $form[$sf_user->getCulture()]['content']->renderLabel() ?><?php echo $form[$sf_user->getCulture()]['content'] ?>                                
    	</li>
    	
    	<!--<li>
    		<?php /*echo $form['venue_id']->renderError() ?>    		
    		<?php echo $form['venue_id']->renderLabel() ?><?php echo $form['venue_id'] */?>                                
    	</li>
    	--><li>
    		<?php echo $form['start_date']->renderError() ?>    		
    		<?php echo $form['start_date']->renderLabel() ?><?php echo $form['start_date'] ?>  
    		<div class="help"><?php echo $form['start_date']->renderHelp() ?></div> 		                                  
    	</li>
    	<li>
    		<?php echo $form['end_date']->renderError() ?>    		
    		<?php echo $form['end_date']->renderLabel() ?><?php echo $form['end_date'] ?>   
    		<div class="help"><?php echo $form['end_date']->renderHelp() ?></div> 		                                 
    	</li>
    	<li>
    		<?php echo $form['image']->renderError() ?>    		
    		<?php echo $form['image']->renderLabel() ?><?php echo $form['image'] ?>   
    		<div class="clear"></div>                                 
    	</li>
    	<li>
    		<?php echo $form['published']->renderError() ?>    		
    		<?php echo $form['published']->renderLabel() ?><?php echo $form['published'] ?>    
   			<div class="help"><?php echo $form['published']->renderHelp() ?></div> 		                           
    	</li>
    	<li>
    		<?php echo $form['publish_state_id']->renderError() ?>    		
    		<?php echo $form['publish_state_id']->renderLabel() ?><?php echo $form['publish_state_id'] ?>                                
    	</li>    
    </ul>
    <input type="button" id="submit_event" value="<?php echo __("Enviar") ?>" /> 
	<?php if (!$form->isNew()):?>
	<?php echo link_to(__('Cancelar'),"profile/data?id=".$form->getObject()->id)?>
	<?php endif;?>
  </form>
 </div>
 <?php echo jquery_validate_form($form, "add_event_form");?>
 <script>
 
 
	 
 $('#event_<?php echo $sf_user->getCulture()?>_name').rules('add', {
		required: true,
		messages: {
			required: "<?php echo __("Indica el nombre del evento")?>"
		}
	});
 $('#event_event_category_id').rules('add', {
		required: true,
		messages: {
			required: "<?php echo __("Indica la categoría del evento")?>"
		}
	});
 $('#event_start_date').rules('add', {
		required: true,
		messages: {
			required: "<?php echo __("Indica la fecha de inicio del evento")?>"
		}
	});
 $('#submit_event').click(function() {
	    var content = tinyMCE.activeEditor.getContent(); // get the content	    
	    if(!content&&$('#add_event_form').valid())
	    {
	    	alert("<?php echo __("Indica la descripción del evento")?>");	    	  
	    } else
	    {
	    	$('#add_event_form').submit();
	    }  
	});
$.timepicker.regional['<?php $sf_user->getCulture()?>'] = {
		timeOnlyTitle: 'Hora del evento',
		timeText: 'Hora',
		hourText: 'Horas',
		minuteText: 'Minutos',
		secondText: 'Segundos',
		millisecText: 'milisegundos',
		timezoneText: '',
		currentText: 'Hoy',
		closeText: 'Cerrar',
		prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;',
		timeFormat: 'HH:mm',
		amNames: ['AM', 'A'],
		pmNames: ['PM', 'P'],
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
   		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
   		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
   		'Jul','Ago','Sep','Oct','Nov','Dic'],
   		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
   		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
   		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
   		firstDay: 1,
		isRTL: false,
		alwaysSetTime: false,
		parse: 'loose'
	};
$.timepicker.setDefaults($.timepicker.regional['<?php $sf_user->getCulture()?>']);
$(function() {
    $( "#event_start_date").datetimepicker({
        timeFormat: 'HH:mm:ss',
        numberOfMonths: 1,
        dateFormat: 'yy-mm-dd',
        showButtonPanel: true,        
    });
});
$(function() {
    $( "#event_end_date").datetimepicker({
        timeFormat: 'HH:mm:ss',
        numberOfMonths: 1,
        dateFormat: 'yy-mm-dd',
        showButtonPanel: true
    });
});
    </script>