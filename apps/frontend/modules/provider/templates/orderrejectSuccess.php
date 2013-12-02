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
<h3><?php echo __("Pedido rechazado: ")?> <?php echo $order->name?></h3>
<div class="sf_apply sf_apply_settings provider_form">
<p><?php echo __("Para rechazar el pedido debes indicar las razones en el siguiente cuadro:")?></p>
<form name="reject_order_form" id="reject_order_form" action="<?php echo url_for('provider/orderrejected?order_id='.$order->id)?>" method="post">
    <ul>
    	<li><label><?php echo __("Comentarios:")?></label>
    	<textarea name="reject_comments" id="reject_comments" class="required" rows="5" cols="60"></textarea></li>
    </ul>
    <input type="submit" value="<?php echo __("Enviar") ?>" /> 
    <?php echo link_to(__('Cancelar'),"profile/data")?>
</form>
</div>
<script>
$(document).ready(function(){
    $("#reject_order_form").validate();
    $('#reject_comments').rules('add', {
    	required: true,
    	messages: {
    		required: "<?php echo __("Debes indicar las razones por las que rechazas este pedido")?>"
    	}
    });
  });



</script>