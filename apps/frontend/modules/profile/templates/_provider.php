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

<?php use_helper("Number","Date","Custom","jQuery")?>
<script>	
$(document).ready(function() {
    $("#tabs-left").tabs({selected:<?php echo $provider->getTabOrderState()?>})
    });
	</script>
	
<h4><?php echo __("Listado de pedidos") ?></h4>
<?php if ($provider->hasOrders()):?>
    <?php include_partial("provider/orders",array("order_states"=>$order_states,"provider"=>$provider))?>
<?php else :?>
	<p><?php echo __("No hay ningún pedido.")?></p>
<?php endif;?>

<div class="catalogue">
    <?php if ($provider->hasHighlight()):?>
    <h3><?php echo __("Productos destacados")?></h3>
        <div class="highlight_list">
        <?php foreach ($provider->getHighlightProducts(6) as $provider_product):?>
        	<div class="highlight_product">
        		<?php include_partial ("provider/product",array("provider_product"=>$provider_product,"buyConsumer"=>isset($buyConsumer)?$buyConsumer:null))?>
        	</div>
        <?php endforeach;?>
        <div class="clear"></div>
        </div>
        <div class="clear"></div>
    <?php endif;?>    
<?php include_partial("provider/admin")?>
</div>
