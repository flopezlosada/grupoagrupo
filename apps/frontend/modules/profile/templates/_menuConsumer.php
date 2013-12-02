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
<h3><?php echo __("Grupos de Consumo")?></h3>
<?php if ($internal_user->consumer_state_id==1):?>
	<div class="consumer_group consumer_links">
        <?php echo __('Aún no formas parte de un grupo de consumo.')?>    
        <ul>
        	<li><?php echo link_to(image_tag("group_add", array("class"=>"group_ico")).__("Crear grupo de consumo"),"consumer_group/add")?></li>
        	<li><?php echo link_to(image_tag("search_group", array("class"=>"group_ico")).__("Buscar grupos cercanos"),"consumer_group/lookfor?type=group")?></li>
        	<li><?php echo link_to(image_tag("search_user", array("class"=>"group_ico")).__("Buscar gente cercana"),"consumer_group/lookfor?type=consumer")?></li>    	
        </ul>
    </div>
<?php elseif($internal_user->consumer_state_id==2):?>
	<p><?php echo __("Formas parte del grupo de consumo: ")?><strong><?php echo $internal_user->ConsumerGroup->name?></strong></p>    
    <?php if ($internal_user->id==$internal_user->ConsumerGroup->consumer_trust_id):?>
    	<div class="consumer_group admin_links">
    	    <span class="menu_consumer_box"><?php echo __("Administración")?></span>
    	    <ul>
    	    	<li>
        	    	<?php if($internal_user->ConsumerGroup->getJoinRequestPending()):?>
        	    	    <?php echo link_to(image_tag("pending_request", array("class"=>"group_ico")).__("Revisar peticiones pendientes"),
        	    	    "consumer_group/pendingrequest?id=".$internal_user->ConsumerGroup->id)?> (<?php echo $internal_user->ConsumerGroup->getJoinRequestPending()?>)
        	    	<?php else:?>
        	    	    <?php echo image_tag("pending_request_off", array("class"=>"group_ico")).__("No hay peticiones pendientes")?>
        	    	<?php endif;?>
    	    	</li>
    	    	<li>
    	    		<?php if($internal_user->ConsumerGroup->getTotalMembers()>1):?>
    	    	        <?php echo link_to(image_tag("change_trust", array("class"=>"group_ico")).
    	    	        __("Cambiar persona responsable"),"consumer_group/changetrust?id=".$internal_user->ConsumerGroup->id)?>
    	    	    <?php else:?>
    	    	    	<?php echo image_tag("change_trust_off", array("class"=>"group_ico")).
    	    	        __("Cambiar persona responsable")?>
    	    	    <?php endif;?>
    	    	</li>
    	    	<li><?php echo link_to(image_tag("group_review", array("class"=>"group_ico"))
    	    	    .__("Revisar miembros"),"consumer_group/reviewmembers?id=".$internal_user->ConsumerGroup->id)?> 
    	    		(<?php echo $internal_user->ConsumerGroup->getTotalMembers()?>)</li>
    	    	<li><?php echo link_to(image_tag("edit", array("class"=>"group_ico")).
    	    	    __("Modificar datos del grupo"),"consumer_group/modify?id=".$internal_user->ConsumerGroup->id)?></li>
    	    	<li><?php echo link_to(image_tag("order_edit.png", array("class"=>"group_ico")).__("Gestión de pedidos"),"consumer_group/orderlist")?></li>
    	    </ul>
    	</div>
    <?php endif;?>
	<div class="consumer_group app_links">
		<span class="menu_consumer_box"><?php echo __("Utilidades")?></span>
		<ul>
    		<?php if ($internal_user->isOrderTrust()):?>
    			<li><?php echo link_to(image_tag("order_edit.png", array("class"=>"group_ico")).__("Gestión de pedidos"),"consumer_group/orderlist")?></li>
    		<?php endif;?>
			<li><?php echo link_to(image_tag("forum", array("class"=>"group_ico")).__("Foro"),"consumer_group/forum")?></li>
			<li><?php echo link_to(image_tag("file", array("class"=>"group_ico")).__("Archivos"),"consumer_group/util?type=file&id=".$internal_user->ConsumerGroup->id)?></li>
			<li><?php echo link_to(image_tag("adverti", array("class"=>"group_ico")).__("Anuncios"),"consumer_group/util?type=announcement&id=".$internal_user->ConsumerGroup->id)?></li>
			<li><?php echo link_to(image_tag("calendar", array("class"=>"group_ico")).__("Eventos"),"consumer_group/util?type=event&id=".$internal_user->ConsumerGroup->id)?></li>
		</ul>
	</div>
	<div class="consumer_group other_links">
	<span class="menu_consumer_box"><?php echo __("Otras")?></span>
    <ul>
    	<li><?php echo link_to(image_tag("search_user", array("class"=>"group_ico")).__('Buscar gente cercana al grupo'),"consumer_group/lookfor?type=consumers_by_group")?></li>
    	<li><?php echo link_to(image_tag("mail_g", array("class"=>"group_ico")).__('Contactar con todo el grupo'),"consumer_group/contact?type=all&id=".$internal_user->ConsumerGroup->id)?></li>
    	 <?php if ($internal_user->id!=$internal_user->ConsumerGroup->consumer_trust_id):?>
    	<li><?php echo link_to(image_tag("consumer_delete", array("class"=>"group_ico")).__("Darse de baja del grupo"),"consumer_group/leave")?></li>
    	<?php endif;?>
    </ul>
    </div>
    <div class="consumer_group admin_links">
	<span class="menu_consumer_box"><?php echo __("Proveedoras/es aceptadas/os")?></span>
    <ul>
    	<?php foreach($internal_user->ConsumerGroup->getAceptedProviders() as $provider):?>
    		<li><?php echo link_to($provider->name,"provider/profile?id=".$provider->id)?></li>
    	<?php endforeach;?>
    </ul>
    </div>
     <div class="consumer_group other_links">
	<span class="menu_consumer_box"><?php echo __("Pedidos abiertos")?></span>
    <ul>
    	<?php foreach($internal_user->ConsumerGroup->getOpenOrders() as $order):?>
    		<li><?php echo link_to($order->name,"@provider_catalogue?slug=".$order->Provider->slug)?></li>
    	<?php endforeach;?>
    </ul>
    </div>
    
<?php elseif($internal_user->consumer_state_id==4):?>
	<div class="consumer_group pending_links">
    	<p><?php echo __("Estás a la espera de formar parte del grupo ")?><strong><?php echo $internal_user->ConsumerGroup->name?></strong></p>
    	<ul>
    		<li><?php echo link_to(image_tag("mail_g", array("class"=>"group_ico")).__("Contactar"),"consumer_group/contact?id=".$internal_user->ConsumerGroup->id."&type=group")?></li>
    		<li><?php echo link_to(image_tag("group_join_request", array("class"=>"group_ico")).__("Recordar petición"),"consumer_group/joinrequest?id=".$internal_user->ConsumerGroup->id."&repeat=yes")?></li>
    		<li><?php echo link_to(image_tag("group_join_request_delete", array("class"=>"group_ico")).__("Anular petición"),"consumer_group/deleterequest")?></li>
    	</ul> 
	</div>   
<?php endif;?> 
<!--Para todos igual-->
<div class="consumer_group pending_links">
	<ul>
    	<li><?php echo link_to(image_tag("user", array("class"=>"group_ico")).__("Ir a tu perfil de usuaria/o"),"profile/data")?></li>
    </ul>
</div>