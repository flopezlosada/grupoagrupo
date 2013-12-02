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
<?php include_partial('profile/flashes') ?>
<div class="members_list">
    <h3><?php echo __("Listado de peticiones pendientes de incorporación al grupo.")?></h3>
    <ul>
        <?php foreach($members as $member):?>
        	<li>
        	    <span class="consumer_name"><?php echo $member->name?> <?php echo $member->surname?></span> 
        	    <?php echo link_to(image_tag("mail_g", array("class"=>"group_ico fr","title"=>__("Contactar"),
        	    	"alt"=>__("Contactar"))),"consumer_group/contact?id=".$member->id."&type=member")?>
       	    	<?php echo link_to(image_tag("cancel", array("class"=>"group_ico fr","title"=>__("Rechazar"),
        	    	"alt"=>__("Rechazar"))),"consumer_group/processjoinrequest?consumer_id=".$member->id."&process=reject")?>
        	    <?php echo link_to(image_tag("accept", array("class"=>"group_ico fr","title"=>__("Aceptar"),
        	    	"alt"=>__("Aceptar"))),"consumer_group/processjoinrequest?consumer_id=".$member->id."&process=validate")?>
        	</li>
        <?php endforeach;?>
    </ul>
</div>    