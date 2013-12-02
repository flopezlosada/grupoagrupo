<?php
/*
 © Copyright 2012diphda.net && sodepaz.org
info@diphda.net
sodepaz@sodepaz.org


Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia
Pública General de GNU según es publicada por la Free Software Foundation, bien de la versión 3 de dicha
Licencia o bien (según su elección) de cualquier versión posterior.

Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin l
garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la
Licencia Pública General de GNU para más detalles.

Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así,
escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, MA 02139, EEUU.

La licencia se encuentra en el archivo licencia.txt*/
?>
    <div class="<?php echo $class?>_list">
    <?php foreach ($products as $i=>$provider_product):?>
    	<div class="<?php echo $class?>_product">
    		<?php include_partial ("provider/product",array("provider_product"=>$provider_product,"buyConsumer"=>isset($buyConsumer)?$buyConsumer:null))?>    		
    	</div>
    	<?php if ($i==2):?>
    		<div class="clear"></div>
    	<?php endif;?>
    <?php endforeach;?>
    <div class="clear"></div>
    </div>
        <div class="clear"></div>