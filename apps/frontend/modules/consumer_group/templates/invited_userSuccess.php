<?php
/*
 © Copyright 2013diphda.net && sodepaz.org
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
<h3><?php echo __("Listado de invitaciones para la/el usuaria/o %&%",array("%&%"=>$sf_user->getInternalUser()->getFullName()))?></h3>
<?php foreach ($invitations as $invitation):?>
  <div class="member"><?php echo __("Invitación del grupo de consumo %&%", array("%&%"=>$invitation->ConsumerGroup->name))?>
               
       <?php echo link_to(image_tag("admin/small/reject_invitation.png", array("class"=>"fr","title"=>__("Rechazar Invitación"),
            	    	    "alt"=>__("Rechazar Invitación"))),"consumer_group/process_invitation?type=reject&invitation_id=".$invitation->id)?>      
         <?php echo link_to(image_tag("mail_p", array("class"=>"fr","title"=>__("Contactar con el grupo"),
            	    	"alt"=>__("Contactar con el grupo"))),"consumer_group/contact?id=".$invitation->ConsumerGroup->id."&type=group")?>
<?php echo link_to(image_tag("admin/small/accept_invitation.png", array("class"=>"fr","title"=>__("Aceptar Invitación"),
            	    	    "alt"=>__("Aceptar Invitación"))),"consumer_group/process_invitation?type=accept&invitation_id=".$invitation->id)?>                 	    	        	    		    	    	    
  </div>
<?php endforeach;?>