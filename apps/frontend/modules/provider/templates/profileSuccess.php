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
<?php use_helper("TextPurifier","Date","Text")?>

<?php include_partial('provider/flashes') ?>
<h3><?php echo __('Perfil de la/el proveedora/or')?> <?php echo $provider->name?></h3>
<div class='profile_description'><?php echo image_tag(basename(sfConfig::get('sf_upload_dir'))."/".
                    basename(sfConfig::get('sf_provider_dir'))."/".$provider->image, array("class"=>"fr"))?><?php echo cleanPurifier($provider->getContent("&",ESC_RAW))?>
	<div class="clear"></div>
</div>
<!--<div class="message_notice"><?php //echo __("El sitio está en construcción, no se pueden aceptar proveedores ni hacer pedidos")?></div>-->
<div class="general_user_events">
    <?php if ($provider->getActiveFile()):?>
        <div class="warning_box">
        	
        	<?php echo image_tag("admin/file", array("class"=>"warning_ico"))?>
        	<span class="title"><?php  echo __("Archivos")?></span>
        	<?php echo link_to($provider->getLastActiveFile()->name,"@util_show_file?slug=".$provider->getLastActiveFile()->slug)?>
        	<?php echo cleanPurifier(truncate_text($provider->getLastActiveFile()->getContent("&",ESC_RAW),100,"...",true))?>
        	
        	<cite><?php echo link_to(__("Ver todos"),"@util_list_file_provider?slug=".$provider->slug)?></cite> 
        </div>
    <?php endif;?>
    <?php if ($provider->getActiveAnnouncements()):?>
        <div class="warning_box">
        	
        	<?php echo image_tag("admin/announcement", array("class"=>"warning_ico"))?>
        	<span class="title"><?php  echo __("Anuncios")?></span>
        	<?php echo link_to($provider->getLastActiveAnnouncement()->name,"@util_show_announcement?slug=".$provider->getLastActiveAnnouncement()->slug)?>
        	<?php echo cleanPurifier(truncate_text($provider->getLastActiveAnnouncement()->getContent("&",ESC_RAW),100,"...",true))?>
        	
        	<cite><?php echo link_to(__("Ver todos"),"@util_list_announcement_provider?slug=".$provider->slug)?></cite> 
        </div>
    <?php endif;?>
     <?php if ($provider->getActiveEvents()):?>
        <div class="warning_box">
        	
        	<?php echo image_tag("admin/event", array("class"=>"warning_ico"))?>
        	<span class="title"><?php  echo __("Eventos")?></span>
        	<?php echo link_to($provider->getLastActiveEvent()->name,"@event?slug=".$provider->getLastActiveEvent()->slug)?>
        	<?php echo cleanPurifier(truncate_text($provider->getLastActiveEvent()->getContent("&",ESC_RAW),100,"...",true))?>
        	
        	<cite><?php echo link_to(__("Ver todos"),"@util_list_event_provider?slug=".$provider->slug)?></cite> 
        </div>
    <?php endif;?>
    <div class="clear"></div>
</div>


<?php if ($provider->hasProviderImages()):?>	
	<?php include_partial("provider/images", array("provider"=>$provider))?>	
<?php endif;?>
<div class="consumer_group app_links">
    <!--Si es un consumidor, realizo el siguiente if porque si no es consumidor el segundo if daría error-->
    <?php if ($sf_user->getInternalClassName()=="Consumer"):?>
        <?php if ($sf_user->getInternalUser()->consumer_state_id==2):?>
        	<?php if ($provider->isAceptedInGroup($sf_user->getInternalUser()->consumer_group_id)):?>
        		<p><?php echo __('Esta/e proveedora/or ya ha sido aceptada/o por tu grupo de consumo')?></p>
        		<p><?php echo __("La persona responsable de esta/e proveedora/or es: ")?><strong>
        		    <?php echo link_to($provider->getAceptedInGroup($sf_user->getInternalUser()->consumer_group_id)->Consumer->name,"consumer/profile?id=".
        		    $provider->getAceptedInGroup($sf_user->getInternalUser()->consumer_group_id)->Consumer->id)?></strong></p>
        		    <?php if ($provider->hasOpenOrder($sf_user->getInternalUser()->consumer_group_id)):?>
        				<p><?php echo __("Tenéis un pedido sin finalizar en este momento con esta/e proveedora/or")?></p>
        		<?php endif;?>
        		<?php if ($sf_user->getInternalUser()->isConsumerTrust()):?>
	                <div class="admin_box"><?php echo link_to(image_tag("admin/change_trust.png",array("class"=>"admin_ico")).__("Cambiar responsable"),
        			"consumer_group/changetrustprovider?provider_id=".$provider->id."&consumer_group_id=".$sf_user->getInternalUser()->consumer_group_id)?></div>	                
	        	<?php endif;?>
        		<?php if ($provider->getAceptedInGroup($sf_user->getInternalUser()->consumer_group_id)->Consumer->id==$sf_user->getInternalUser()->id||
        		    $sf_user->getInternalUser()->isConsumerTrust()):?>
        			<?php if (!$provider->hasOpenOrder($sf_user->getInternalUser()->consumer_group_id)):?>    				
        				<div class="admin_box"><?php echo link_to(image_tag("admin/open_order.png",array("class"=>"admin_ico")).__("Abrir pedido"),"consumer_group/order?provider_id=".$provider->id)?></div>
        				<div class="admin_box"><?php echo link_to(image_tag("admin/reject_provider.png",array("class"=>"admin_ico")).__("Rechazar proveedor"),"consumer_group/reject?provider_id=".
        				    $provider->id."&consumer_group_id=".$sf_user->getInternalUser()->consumer_group_id)?></div>        				    
        				<!-- Listado de pedidos en estado 2 (cerrados, pero sin confirmar) -->
        				<!--<span><?php //echo __("Listado de pedidos en estado cerrado. Pincha en cada uno de ellos si quieres modificar las fechas")?></span>
        				<ul>        				
        					<?php /*foreach ($sf_user->getInternalUser()->ConsumerGroup->getOrdersState(2) as $order):?>
        						<li><?php echo link_to(format_datetime($order->date_in,"P","es","utf-8"),"consumer_group/openorder?id=".$order->id."&provider_id=".$provider->id)?></li>
        					<?php endforeach;*/?>
        				</ul>
        			-->
        			<?php endif;?>    			
        		<?php endif;?>        		
        	<?php elseif($sf_user->getInternalUser()->isConsumerTrust()):?>
        		<?php if ($provider->wasAceptedInGroup($sf_user->getInternalUser()->consumer_group_id)):?>
        			<div class="admin_box"><?php echo link_to(image_tag("admin/reacept_provider.png",array("class"=>"admin_ico")).__("Aceptar de nuevo este proveedor"),
        			"consumer_group/reacept?provider_id=".$provider->id."&consumer_group_id=".$sf_user->getInternalUser()->consumer_group_id)?></div>
        		<?php elseif($provider->pendingAceptedInGroup($sf_user->getInternalUser()->consumer_group_id)):?>
        		<?php else:?>
        		<div class="admin_box"><?php echo link_to(image_tag("admin/provider_accept.png",array("class"=>"admin_ico")).__("Aceptar este proveedor"),"consumer_group/acept?provider_id=".$provider->id)?>
        			
        		</div>
        		<?php endif;?>
        	<?php else:?>
        		<p><?php echo __("Esta/e proveedora/or no ha sido aceptada/o por tu grupo de consumo")?></p>
        	<?php endif;?>    	
        <?php endif;?>
       
    <?php endif;?> 

 <?php include_partial("provider/catalogue_link",array("provider"=>$provider,"text"=>"Ver Catálogo"))?>
 <div class="admin_box"><?php echo link_to(image_tag("admin/mail", array("class"=>"admin_ico","title"=>__("Contactar"),
        	    	"alt"=>__("Contactar"))).__("Contactar"),"consumer_group/contact?id=".$provider->id."&type=provider")?></div>
 <div class="clear"></div>  
</div>
 <div id="personal_data">
	<span class="title"><?php echo __("Datos de contacto:")?></span>
	<p><?php echo __("Dirección: ").$provider->address?> -<?php echo $provider->cp?><br/> 
	<?php echo $provider->City->name?> (<?php echo $provider->State->name?>)<br/> 
	<?php echo __("Teléfono: ").$provider->phone?><br />
	<?php echo __("Móvil: ").$provider->celular?><br />
	<?php echo __("Email: ").$provider->email?> <br />
	<?php echo __("Web: ").$provider->web?><br />
	
</div>