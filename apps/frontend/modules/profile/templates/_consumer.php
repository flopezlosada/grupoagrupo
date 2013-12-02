<?php
/*
© Copyright 2011 diphda.net && Sodepaz
flopezlosada@yahoo.es


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
<?php if ($consumer->belongConsumerGroup()):?>
	<h3><?php echo __('Tablón del grupo de consumo %5%',array("%5%"=>$consumer->ConsumerGroup->name))?></h3>
    <?php if ($consumer->ConsumerGroup->hasOrder()):?>
        <?php include_partial("consumer_group/orderlist",array("order_states"=>$order_states, "consumer_group"=>$consumer->ConsumerGroup))?>
    <?php endif;?>
    <div class="consumer_group_home_utilities">
    <?php include_component("profile","utilities",array("type"=>"Announcement","is_consumer_group_only"=>true))?>
    <?php include_component("event","consumer_group_events",array("consumer_group_id"=>$consumer->consumer_group_id))?>
    <div class="clear"></div>
    <?php include_component("profile","utilities",array("type"=>"File","is_consumer_group_only"=>true))?>
    <?php include_partial("consumer_group/news",array("consumer_group"=>$consumer->ConsumerGroup))?>
    <div class="clear"></div>
    <?php include_partial("consumer_group/latest_post",array("consumer_group"=>$consumer->ConsumerGroup))?>
    <div class="clear"></div>
    </div>
<?php else:?>
<?php endif;?>