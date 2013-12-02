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
<?php echo image_tag("admin/search_".$type.".png",array("class"=>"fr"))?>
	<div class="param_list">    	
    	<div class="results_list">    	
        	<span class="results">
        	<?php if ($type=="consumer"):?>
        	    <?php echo __("Se han encontrado <strong>%&%</strong> consumidoras/es",array("%&%"=>count($result)))?>
        	<?php elseif($type=="consumer_group"):?>
        	    <?php echo __("Se han encontrado <strong>%&%</strong> grupos de consumo",array("%&%"=>count($result)))?>
        	<?php endif;?>
        	</span>
        	<?php if($sf_user->isAuthenticated()):?>
        	<script>
                    $(function() {
                        $( "#tabs_search" ).tabs();
                    });
                </script>
            	<div id="tabs_search">
                    <ul>
                        <li><a href="#tabs-1"><?php echo __("Ver mapa")?></a></li>                        
                        <li><a href="#tabs-2"><?php echo __("Ver listado")?></a></li>
                    </ul>
                    <div id="tabs-1">
                    	<?php include_partial("home/map",array("city"=>$city,"file"=>$file,"width"=>575))?>
                    </div>
                    <div id="tabs-2">
                		<ul class="result_list">
                    		<?php foreach ($result as $consumer):?>
                    			<li><?php echo link_to($consumer->name,$type."/profile?id=".$consumer->id)?></li>
                    		<?php endforeach;?>
                		</ul> 
            		</div>
                </div>           	
            <?php else:?>
            	<span><?php echo __("Debes estár registrada/o para ver los resultados")?></span>
            	<span><?php echo link_to(__("Acceder"),"@sf_guard_signin")?></span>
        	<?php endif;?>
    	</div>
    </div>