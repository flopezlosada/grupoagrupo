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
<?php include_partial("provider/flashes")?>

<h3><?php echo __("Utilidades")?></h3>
<?php if ($internal_user->consumer_state_id==1||$internal_user->consumer_state_id==3):?>
	<p><?php echo __('Aún no formas parte de un grupo de consumo.')?></p>	    
	<div class="consumer_group consumer_links">
	        <?php if ($internal_user->hasInvitationToConsumerGroup()):?>
    		  <div class="invitation_box admin_box"><?php echo link_to(image_tag("admin/invited", array("class"=>"admin_ico")).__("Tienes una invitación de un grupo de consumo"),"consumer_group/invited_user")?></div>
    		<?php endif;?>  
        	<div class="admin_box"><?php echo link_to(image_tag("admin/group_add", array("class"=>"admin_ico")).__("Crear grupo de consumo"),"consumer_group/add")?></div>
        	<div class="admin_box"><?php echo link_to(image_tag("admin/search_group", array("class"=>"admin_ico")).__("Buscar grupos cercanos"),"consumer_group/lookfor?type=group")?></div>
        	<div class="admin_box"><?php echo link_to(image_tag("admin/search", array("class"=>"admin_ico")).__("Buscar gente cercana"),"consumer_group/lookfor?type=consumer")?></div>
        	<div class="admin_box "><?php echo link_to(image_tag("admin/user_edit", array("class"=>"admin_ico")).__("Modificar mis datos"),"register/edit")?></div>
        	<div class="admin_box ">    	
    	        <?php echo link_to(image_tag("admin/user_delete", array("class"=>"admin_ico")).__("Darse de baja de grupoagrupo.net"),"register/delete",
    	        "confirm=".__("Al darte de baja perderás todos los datos ¿estás segura/o?"))?> 
    		</div>  	
        <div class="clear"></div>
    </div>
<?php elseif($internal_user->consumer_state_id==2):?>
	<p><?php echo __("Formas parte del grupo de consumo: ")?><strong><?php echo $internal_user->ConsumerGroup->name?></strong></p>    
    <?php if ($internal_user->id==$internal_user->ConsumerGroup->consumer_trust_id):?>
    	<div class="consumer_group admin_links">
    	    <span class="menu_consumer_box"><?php echo __("Administración")?></span>
    	    <div class="admin_box ">
        	    	<?php if($internal_user->ConsumerGroup->getJoinRequestPending()):?>
        	    	    <?php echo link_to(image_tag("admin/clock.png", array("class"=>"admin_ico")).__("Revisar peticiones pendientes"),
        	    	    "consumer_group/pendingrequest?id=".$internal_user->ConsumerGroup->id)?> (<?php echo $internal_user->ConsumerGroup->getJoinRequestPending()?>)
        	    	<?php else:?>
        	    	    <?php echo image_tag("admin/clock_off.png", array("class"=>"admin_ico")).__("No hay peticiones pendientes")?>
        	    	<?php endif;?>
    	    	</div>
    	    	<div class="admin_box">
    	    		<?php if($internal_user->ConsumerGroup->getTotalMembers()>1):?>
    	    	        <?php echo link_to(image_tag("admin/change_trust", array("class"=>"admin_ico")).
    	    	        __("Cambiar persona responsable"),"consumer_group/changetrust?id=".$internal_user->ConsumerGroup->id)?>
    	    	    <?php else:?>
    	    	    	<?php echo image_tag("admin/change_trust_off", array("class"=>"admin_ico")).
    	    	        __("Cambiar persona responsable")?>
    	    	    <?php endif;?>
    	    	</div>    	    	
    	    	<div class="admin_box"><?php echo link_to(image_tag("admin/edit", array("class"=>"admin_ico")).
    	    	    __("Modificar datos del grupo"),"consumer_group/modify?id=".$internal_user->ConsumerGroup->id)?></div>
    	    	<div class="admin_box"><?php echo link_to(image_tag("admin/order_edit.png", array("class"=>"admin_ico")).__("Gestión de pedidos"),"consumer_group/orderlist")?></div>
    	    	<div class="admin_box"><?php echo link_to(image_tag("admin/provider_search.png", array("class"=>"admin_ico")).__("Buscar proveedoras/es"),"@homepage")?></div>    	    	
    	    	<div class="admin_box"><?php echo link_to(image_tag("admin/invite.png", array("class"=>"admin_ico")).__("Invitar a participar en el grupo"),"consumer_group/invite")?></div>
    	    	<div class="admin_box">
    	    	    <?php if ($internal_user->ConsumerGroup->hasActiveInvitations()):?>
    	    	        <?php echo link_to(image_tag("admin/review_invite.png", array("class"=>"admin_ico")).__("Revisar el estado de las invitaciones enviadas (%&%)",
    	    	                array("%&%"=>count($internal_user->ConsumerGroup->getConsumerGroupInvitation()))),"consumer_group/review_invitations")?>
    	    	     <?php else:?>
    	    	           <?php echo image_tag("admin/review_invite_off.png", array("class"=>"admin_ico")).__("No hay invitaciones enviadas")?>
    	    	     <?php endif;?>
    	    	  </div>
    	    	<div class="clear"></div>
    	</div>
    <?php endif;?>
	<div class="consumer_group app_links">
		<span class="menu_consumer_box"><?php echo __("Utilidades")?></span>
		
    		<?php if ($internal_user->isOrderTrust()&&!($internal_user->id==$internal_user->ConsumerGroup->consumer_trust_id)):?>    			
    	    	<div class="admin_box"><?php echo link_to(image_tag("admin/order_edit.png", array("class"=>"admin_ico")).__("Gestión de pedidos"),"consumer_group/orderlist")?></div>
    		<?php endif;?>			
    	    <div class="admin_box"><?php echo link_to(image_tag("admin/forum", array("class"=>"admin_ico")).__("Foro"),"consumer_group/forum")?></div>
    	    <div class="admin_box"><?php echo link_to(image_tag("admin/group_review", array("class"=>"admin_ico")).__("Revisar miembros"),"consumer_group/reviewmembers?id=".$internal_user->ConsumerGroup->id)?>(<?php echo $internal_user->ConsumerGroup->getTotalMembers()?>)</div>
    	    <div class="admin_box "><?php echo link_to(image_tag("admin/file_add", array("class"=>"admin_ico")).__("Publicar archivo"),"consumer_group/utilAdd?type=file")?></div>    
            <div class="admin_box "><?php echo link_to(image_tag("admin/event_add", array("class"=>"admin_ico")).__("Crear Evento"),"event/add")?></div>    
            <div class="admin_box "><?php echo link_to(image_tag("admin/announcement_add", array("class"=>"admin_ico")).__("Realizar Anuncio"),"consumer_group/utilAdd?type=announcement")?></div>    	      	    	
		    <div class="admin_box"><?php echo link_to(image_tag("admin/search", array("class"=>"admin_ico")).__('Buscar gente cercana al grupo'),"consumer_group/lookfor?type=consumers_by_group")?></div>
			<div class="admin_box"><?php echo link_to(image_tag("admin/mail_group", array("class"=>"admin_ico")).__('Contactar con todo el grupo'),"consumer_group/contact?type=all&id=".$internal_user->ConsumerGroup->id)?></div>
			<div class="admin_box "><?php echo link_to(image_tag("admin/user_edit", array("class"=>"admin_ico")).__("Modificar mis datos"),"register/edit")?></div>
            <?php if ($internal_user->id!=$internal_user->ConsumerGroup->consumer_trust_id):?>    	
            	<div class="admin_box"><?php echo link_to(image_tag("admin/consumer_delete", array("class"=>"admin_ico")).__("Darse de baja del grupo"),"consumer_group/leave")?></div>
            <?php endif;?>
            <div class="admin_box">  
			<?php if ($internal_user->ConsumerGroup->hasAcceptedProviders()):?>
            	<?php echo link_to(image_tag("admin/provider_list.png", array("class"=>"admin_ico")).__("Proveedoras/es aceptadas/os"),"consumer_group/providerlist?id=".$internal_user->ConsumerGroup->id)?>
            <?php else:?>
            	<?php echo image_tag("admin/provider_list_false.png", array("class"=>"admin_ico")).__("No hay proveedoras/es aceptadas/os") ?>
            <?php endif;?>
            </div>
            <div class="admin_box ">    	
    	        <?php echo link_to(image_tag("admin/user_delete", array("class"=>"admin_ico")).__("Darse de baja de grupoagrupo.net"),"register/delete",
    	        "confirm='".__(" Al darte de baja perderás todos los datos y se cancelarán tus pedidos en trámite (actualmente tienes %&% pedidos en trámite) ¿estás segura/o?",array("%&%"=>$sf_user->getInternalUser()->getPendingOrders()))."'")?> 
    		</div>
    		<div class="admin_box"><?php echo link_to(image_tag("admin/file", array("class"=>"admin_ico")).__("Ver Archivos"),"@util_list_file")?></div>
    	    <div class="admin_box"><?php echo link_to(image_tag("admin/adverti", array("class"=>"admin_ico")).__("Ver Anuncios"),"@util_list_announcement")?></div>
    	    <div class="admin_box"><?php echo link_to(image_tag("admin/calendar", array("class"=>"admin_ico")).__("Ver Eventos"),"event/index")?></div>
        <div class="clear"></div>
	</div>
<?php elseif($internal_user->consumer_state_id==4):?>	
    	<p><?php echo __("Estás a la espera de formar parte del grupo ")?><strong><?php echo $internal_user->ConsumerGroup->name?></strong></p>
    	<div class="consumer_group waiting_consumer_links">
        	<div class="admin_box"><?php echo link_to(image_tag("admin/mail_group", array("class"=>"admin_ico")).__("Contactar con el grupo"),"consumer_group/contact?id=".$internal_user->ConsumerGroup->id."&type=group")?></div>
        	<div class="admin_box"><?php echo link_to(image_tag("admin/group_join_request", array("class"=>"admin_ico")).__("Recordar petición"),"consumer_group/joinrequest?id=".$internal_user->ConsumerGroup->id."&repeat=yes")?></div>
        	<div class="admin_box"><?php echo link_to(image_tag("admin/group_join_request_delete", array("class"=>"admin_ico")).__("Anular petición"),"consumer_group/deleterequest")?></div>
        	<div class="admin_box "><?php echo link_to(image_tag("admin/user_edit", array("class"=>"admin_ico")).__("Modificar mis datos"),"register/edit")?></div>
        	<div class="admin_box ">    	
    	        <?php echo link_to(image_tag("admin/user_delete", array("class"=>"admin_ico")).__("Darse de baja de grupoagrupo.net"),"register/delete",
    	         "confirm=".__("Al darte de baja perderás todos los datos ¿estás segura/o?"))?> 
    		</div>
    		<?php if ($internal_user->hasInvitationToConsumerGroup()):?>
    		  <div class="admin_box "><?php echo link_to(image_tag("admin/user_edit", array("class"=>"admin_ico")).__("Modificar mis datos"),"register/edit")?></div>
    		<?php endif;?>
        	<div class="clear"></div>
		</div>   	 
<?php endif;?> 

