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
    <h3><?php echo __("Listado de miembros del grupo de consumo.")?></h3>
    	<div class="member_list_header">
    		<span class="member_title member_large"><?php echo __("Nombre")?></span>
    		<span class="member_title"><?php echo __("Responsable")?></span>
    		<span class="member_actions"><?php echo __("Acciones")?></span>
    		 <div class="clear"></div>	    
    	</div>
        <?php foreach($members as $member):?>
        	<div class="member">        	
        		<span class="member_content member_large"><?php echo link_to($member->getCompletedName(),"consumer/profile?id=".$member->id)?></span>        	   	
        	    <span class="member_content">
        	        <?php if ($member->isProviderTrust()):?>        	    
        	    		<?php foreach ($member->getProviderTrust() as $provider):?>
        	    	    	<span class="member_trust"><?php echo link_to($provider->name,"provider/profile?id=".$provider->id)?></span>
                        <?php endforeach;?>
                    <?php endif;?>
                </span>
                <span class="member_actions">
            	     <?php if ($member->id!=$sf_user->getInternalUser()->id):?>                
            	        <?php echo link_to(image_tag("mail_p", array("class"=>"fr","title"=>__("Contactar"),
            	    	"alt"=>__("Contactar"))),"consumer_group/contact?id=".$member->id."&type=member")?>        	 
            	    	<?php if ($sf_user->getInternalUser()->id==$sf_user->getInternalUser()->ConsumerGroup->consumer_trust_id):?>                   
           	    	        <?php echo link_to(image_tag("consumer_delete", array("class"=>"fr","title"=>__("Dar de baja"),
            	    	    "alt"=>__("Dar de baja"))),"consumer_group/leave?consumer_id=".$member->id)?>        	    
            	    	<?php endif;?>	
            	    <?php endif;?>
            	    <?php if ($member->id==$sf_user->getInternalUser()->ConsumerGroup->consumer_trust_id):?>        	    
            	    	<?php echo image_tag("consumer_trust", array("class"=>"fr","title"=>__("Responsable de grupo"),
            	    		"alt"=>__("Responsable de grupo")))?>        	    
            	    <?php endif;?>
        	    </span>
        	    <div class="clear"></div>	    
        	</div>
        <?php endforeach;?>
    
</div>  