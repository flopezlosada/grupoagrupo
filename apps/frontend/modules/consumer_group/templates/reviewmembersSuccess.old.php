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
    
        <?php foreach($members as $member):?>
        	<div class="member">
        		<div class="image_profile">
	                <?php echo image_tag($member->image ? basename(sfConfig::get('sf_upload_dir')).'/'
    	            .basename(sfConfig::get('sf_provider_dir')).'/'
    	            .basename(sfConfig::get('sf_provider_thumbnail_dir')).'/'.$member->image:"consumer")?>
    	             <span><?php echo $member->name?> <?php echo $member->surname?></span> 
				</div>
        	   
        	     <?php if ($member->id!=$internal_user->ConsumerGroup->consumer_trust_id):?>
                <div class="member_admin">
        	        <?php echo link_to(image_tag("admin/mail", array("class"=>"admin_ico","title"=>__("Contactar"),
        	    	"alt"=>__("Contactar"))).__("Contactar"),"consumer_group/contact?id=".$member->id."&type=member")?>
        	    </div>
        	    <div class="member_admin">
       	    	    <?php echo link_to(image_tag("admin/consumer_delete", array("class"=>"admin_ico","title"=>__("Dar de baja"),
        	    	"alt"=>__("Dar de baja"))).__("Dar de baja"),"consumer_group/leave?consumer_id=".$member->id)?>
        	    	</div>   
        	    <?php else:?>
        	    	<div class="member_admin">
        	    	    <?php echo image_tag("admin/consumer_trust", array("class"=>"admin_ico","title"=>__("Responsable de grupo"),
        	    		"alt"=>__("Responsable de grupo"))).__("Responsable de grupo")?>
        	    	</div>
        	    <?php endif;?>
        	    <?php if ($member->isProviderTrust()):?>
        	    	<div class="member_admin">
        	    		<?php echo image_tag("admin/provider_trust", array("class"=>"admin_ico","title"=>__("Responsable de proveedora/or"),
        	    		"alt"=>__("Responsable de proveedora/or")))?>
        	    		<?php echo __("Responsable de %1%",array("%1%"=>count($member->getProviderTrust())))." ".
        	    		format_number_choice("[1]".__("proveedora/or:")."|[1,+Inf]".__("proveedoras/es:"),
        	    		    array(),count($member->getProviderTrust()))?>
        	    		    <ul>
        	    		        <?php foreach ($member->getProviderTrust() as $provider):?>
        	    		        	<li><?php echo link_to($provider->name,"provider/profile?id=".$provider->id)?></li>
        	    		        <?php endforeach;?>
        	    		    </ul>
        	    	</div>
        	    <?php endif;?>
        	    <div class="clear"></div>	    
        	</div>
        <?php endforeach;?>
    
</div>  