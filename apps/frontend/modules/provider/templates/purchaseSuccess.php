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
<?php use_helper("Text","jQuery")?>
<?php include_partial("flashes")?>
<h3><?php echo isset($order)&&$order->order_state_id==1? __("Nuevo Pedido para la/el %&% ",array("%&%"=>$provider->getSfGuardUser()->getProfile()->InternalClass->name)):__("Catálogo de la/el %&% ",array("%&%"=>$provider->getSfGuardUser()->getProfile()->InternalClass->name))?> <?php echo $provider->name?></h3>
    
<span id="order_consumer_detail_action"></span>
<span class="purchase_title">
<?php if ($type=="basket"):?>    
    <?php echo __("Lista de Cestas")?>
<?php else:?>   
    <?php echo __("Productos de la categoría ")?><strong><?php echo $category->name."/".$subcategory->name?></strong>
<?php endif;?>    
</span>
<div class="catalogue_product_list">
<div class="catalogue_product_list_header">
	<label class="catalogue_large"><?php echo __("Nombre y descripción")?></label>
	<label><?php echo __("Precio")?></label>
	<?php if ($sf_user->hasCredential("consumer")&&$buyConsumer->canBuyProduct($provider->id)):?>
		<label class="catalogue_medium"><?php echo __("Cantidad")?></label>
		<label class="catalogue_short"><?php echo __("Incluir")?></label>
	<?php endif;?>
	<?php if ($sf_user->isAuthenticated()):?>
	  <?php if($sf_user->getInternalUser()->id==$provider->id):?>
		<label class="catalogue_medium"><?php echo __("Acciones")?></label>
	  <?php endif;?>
	<?php endif;?>
	<div class="clear"></div>
</div>
<?php foreach ($provider_products as $i=>$provider_product):?>
<div class="catalogue_product <?php echo $i%2==0?'odd':'even'?>">
	<label class="catalogue_large">
		<strong><?php echo link_to($provider_product->getShortDescription(),
		        isset($buyConsumer)?
		        "product/$show_action?id=".$provider_product->id."&buy_consumer_id=".$buyConsumer->id."&provider_id=".$provider->id:
		        "product/$show_action?id=".$provider_product->id."&provider_id=".$provider->id)?></strong> 
		
	</label>
	<label><?php echo $provider_product->price?> €<?php echo $type=="basket"?'':"/".$provider_product->PurchaseUnit->name?></label>
    <?php if ($sf_user->hasCredential("consumer")&&$buyConsumer->canBuyProduct($provider->id)):?>
		<?php if($provider_product->is_in_stock):?>
            <?php if ($type=="basket"):?>
                <?php include_partial("provider/purchase_basket",array("buyConsumer"=>$buyConsumer,"order"=>$order,"provider_product"=>$provider_product))?>
            <?php else:?>
              <?php if (($sf_user->hasCredential("consumer")&&$sf_user->getInternalUser()->canManageOrder($order->id)&&in_array($order->order_state_id,array(1,2,6,7)))
        	    ||($sf_user->hasCredential("distributor")||$sf_user->hasCredential("producer"))&&in_array($order->order_state_id,array(4,5,8))||$sf_user->getInternalUser()->getId()==$buyConsumer->id&&in_array($order->order_state_id,array(1,2,6,7))):?>
                   <?php include_partial("provider/purchase_product",array("buyConsumer"=>$buyConsumer,"order"=>$order,"provider_product"=>$provider_product))?>
               <?php endif;?>
            <?php endif;?>
		<?php else:?>
		    <label class="not_available catalogue_medium"><?php echo __("No disponible")?></label>
		<?php endif;?>
		
	<?php endif;?>
	<?php if ($sf_user->isAuthenticated()):?>
	  <?php if($sf_user->getInternalUser()->id==$provider_product->Provider->id):?>
		<label class="catalogue_medium">
	    <?php if ($provider_product->is_highlight):?>
		    <?php echo link_to(image_tag("remove_highlight.png", array("alt"=>__("Quitar destacado"),
		    "title"=>__("Quitar destacado"),"class"=>"group_ico")),"provider/highlight?type=remove&provider_product_id=".$provider_product->id)?>		
		<?php else:?>
		    <?php echo link_to(image_tag("highlight.png", array("alt"=>__("Destacar producto"),
		    "title"=>__("Destacar producto"),"class"=>"group_ico")),"provider/highlight?provider_product_id=".$provider_product->id)?>   
		<?php endif;?>		
		<?php echo link_to(image_tag("edit.png", array("alt"=>__("Editar producto"),
		    "title"=>__("Editar producto"),"class"=>"group_ico")),"product/modify?id=".$provider_product->id)?>
		<?php if ($type!="basket"):?>
		<?php echo link_to(image_tag("delete.png", array("alt"=>__("Borrar producto"),
		    "title"=>__("Borrar producto"),"class"=>"group_ico")),"product/delete?id=".$provider_product->id,
		"confirm=".__("Si borras el prodcuto se borrarán todos los pedidos relacionados que no hayan sido finalizados. Tienes %&% pedidos de este producto",
		array("%&%"=>$provider_product->Provider->getOrdersProduct($provider_product->product_id))))?>
		<?php endif;?>
		<?php if ($provider_product->is_in_stock):?>
		<?php echo link_to(image_tag("not_available.png", array("alt"=>__("Quitar disponibilidad"),
		    "title"=>__("Quitar disponibilidad"),"class"=>"group_ico")),"product/available?id=".$provider_product->id."&type=quit"
		,"confirm=".__("El producto no se podrá comprar hasta que indiques que de nuevo está disponible, ¿Estás segura/o?"))?>
		<?php else:?>
		    <?php echo link_to(image_tag("available.png", array("alt"=>__("Poner producto disponible"),
		    "title"=>__("Poner producto disponible"),"class"=>"group_ico")),"product/available?id=".$provider_product->id
		,"confirm=".__("El producto se podrá comprar de nuevo, ¿Estás segura/o?"))?>
		<?php endif;?>	
		</label>	
	  <?php endif;?>
	<?php endif;?>
	<div class="clear"></div>
</div>
<?php endforeach;?>
</div>
<?php if (isset($order)):?>
<?php if (($sf_user->hasCredential("consumer")&&$sf_user->getInternalUser()->canManageOrder($order->id)&&in_array($order->order_state_id,array(1,2,6,7)))
        	    ||($sf_user->hasCredential("distributor")||$sf_user->hasCredential("producer"))&&in_array($order->order_state_id,array(4,5,8))||$sf_user->getInternalUser()->getId()==$buyConsumer->id&&in_array($order->order_state_id,array(1,2,6,7))):?>
                
    <div id="order_consumer_detail">
    	<?php include_partial("consumer_group/consumer_order_detail",array("consumer"=>$buyConsumer,"order"=>$order))?>	
    </div>
<?php endif;?>
<?php endif;?>
