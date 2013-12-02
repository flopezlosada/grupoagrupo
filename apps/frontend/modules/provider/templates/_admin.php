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
<h3><?php echo __("Utilidades")?></h3>
<div class="consumer_group admin_links">
	<?php include_partial("provider/catalogue_link",array("provider"=>$sf_user->getInternalUser(),"text"=>__("Ir al catálogo")));?>
    <div class="admin_box ">    	
    	<?php echo link_to(image_tag("admin/product_add", array("class"=>"admin_ico")).__("Añadir productos"),"product/add")?> 
    </div>
    <div class="admin_box ">    	
    	<?php echo link_to(image_tag("admin/basket_add", array("class"=>"admin_ico")).__("Crear una cesta"),"product/add_basket")?> 
    </div>
    <div class="admin_box ">    	
    	<?php echo link_to(image_tag("admin/user_edit", array("class"=>"admin_ico")).__("Modificar mis datos"),"register/edit?id=".$sf_user->getInternalUser()->id)?> 
    </div>    
	
	<div class="admin_box ">    	
    	<?php echo link_to(image_tag("admin/user_delete", array("class"=>"admin_ico")).__("Darse de baja de grupoagrupo.net"),"register/delete",
    	"confirm='".__(" Al darte de baja perderás todos los datos y se cancelarán tus pedidos en trámite (actualmente tienes %&% pedidos en trámite) ¿estás segura/o?",array("%&%"=>$sf_user->getInternalUser()->getPendingOrders()))."'")?> 
    </div>
    
    <div class="admin_box ">    	
    	<?php echo link_to(image_tag("admin/file_add", array("class"=>"admin_ico")).__("Publicar archivo"),"provider/utilAdd?type=file")?> 
    </div>    
    
    <div class="admin_box ">    	
    	<?php echo link_to(image_tag("admin/event_add", array("class"=>"admin_ico")).__("Crear Evento"),"event/add")?> 
    </div>    
    
    <div class="admin_box ">    	
    	<?php echo link_to(image_tag("admin/announcement_add", array("class"=>"admin_ico")).__("Realizar Anuncio"),"provider/utilAdd?type=announcement")?> 
    </div>    
    
    <div class="clear"></div>    
</div>