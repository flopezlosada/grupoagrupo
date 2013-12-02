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
<?php if (count($announcement)):?>

<div class="login_data">
	<span><?php echo __($link_name)?> </span>
	<?php echo image_tag("admin/".strtolower($type), array ("class"=>"fr"))?>
	<ul>
		<?php foreach($announcement as $ann):?>
    		<li>
        		<?php if ($type=="Event"):?>
        		    <?php echo format_datetime($ann->start_date,"U","es_ES")?><br />        		    
        		<?php endif;?>        		
    		    <?php echo link_to($ann->name,"@util_show_".strtolower($type)."?slug=".$ann->slug,array("class"=>"comments_link"))?>
    		    <br />
    		    <?php echo truncate_text(strip_tags($ann->getContent("&",ESC_RAW)),30,"...",false)?>
    		    <?php if ($type!="Event"):?>
    		      <br /><?php echo  __("Enviado por %&%",array("%&%"=>$ann->sfGuardUser->username))?>
    		    <?php endif?>
		    </li>
		<?php endforeach;?>
	</ul>
	<div class=clearer></div>
	<?php echo link_to(__("Ver todos"),"@util_list_".strtolower($type))?>
</div>
<?php endif;?>