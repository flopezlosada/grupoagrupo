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
<?php use_helper("I18N", "jQuery","jQueryValidator") ?>
<div class="sf_apply sf_apply_settings provider_form">
    <h3><?php echo __("Contacto")?></h3>
    <p><?php echo __("grupoagrupo.net es un proyecto de SODEPAZ")?></p>
    <p><?php echo __("Estamos muy interesados en conocer tu opinión y tus sugerencias.")?></p>
    <p><?php echo __("Para ello puedes ")?><br />
    <?php echo __("Llamarnos por teléfono: 915228091")?><br />
    <?php echo __("Escribirnos un email: info@grupoagrupo.net")?> <br />
    <?php echo __("O rellenar el siguiente formulario:")?>
    </p>
    <h4><?php echo __("Formulario de contacto ")?></h4>
    <form  id=contact_guest_form action="<?php echo url_for('home/guestContacted')?>"	method="post">
        <?php echo $form->renderGlobalErrors() ?>
    	<?php echo $form->renderHiddenFields() ?>	
        <?php echo $form?>
        <div class="clear"></div>
        <p><input type="submit" value="<?php echo __("Enviar") ?>" /></p> 
    </form>
</div>
<?php echo jquery_validate_form($form, "contact_guest_form");?>

<script>
//Certificate name field is only required if a certificate is requested
$('#contact_subject').rules('add', {
	required: true,	
	messages: {
		required: "<?php echo __("Indica el asunto del mensaje")?>",		
	}
});

$('#contact_body').rules('add', {
	required: true,	
	messages: {
		required: "<?php echo __("Indica el cuerpo del mensaje")?>",		
	}
});

$('#contact_email').rules('add', {
	required: true,	
	email: true,
	messages: {
		required: "<?php echo __("Indica tu dirección de correo electrónico")?>",		
		email: "<?php echo __("Indica una dirección de correo electrónico válida")?>",
	}
});
</script>