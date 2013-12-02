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
<?php if ($categories):?>
<span class="category_title"><?php echo __("Categorías")?></span>
<div id="accordion">
	<?php foreach ($categories as $category):?>
		<h3><a href="#"><?php echo $category->name?></a></h3>
		<div>
			<ul>
    			<?php foreach ($category->getSubcategoryProvider($provider->id) as $subcategory):?>
    				<li <?php echo $subcategory->id==$request_subcategory?'class="active" ':''?>>
    				<?php if(isset ($buyConsumer)):?>
    				    <?php echo link_to($subcategory->name,"provider/purchase?category_id=".
    				    $category->id."&subcategory_id=".$subcategory->id."&provider_id=".$provider->id."&buy_consumer_id=".$buyConsumer->id)?>
    				<?php else:?>
    				    <?php echo link_to($subcategory->name,"provider/purchase?category_id=".
    				    $category->id."&subcategory_id=".$subcategory->id."&provider_id=".$provider->id)?>
    				<?php endif;?>
    				</li>
    			<?php endforeach;?>    			
			</ul>
		</div>		
	<?php endforeach;?>	
</div>

<script>
  $(document).ready(function() {
    $("#accordion").accordion({ collapsible: true, active: <?php echo $request_category?> , autoHeight: false});
  });
</script>
<?php else:?>
	<?php echo __("Esta/e proveedora/or no ha definido su catálogo")?>
<?php endif;?>
<?php if ($provider->hasProfileImage()):?>
    <?php $image=basename(sfConfig::get('sf_upload_dir'))."/".basename(sfConfig::get('sf_provider_dir'))."/".basename(sfConfig::get('sf_provider_thumbnail_dir'))."/".$provider->image?>
<?php else:?>
    <?php $image="admin/provider"?>
<?php endif;?>
<div class="provider_profile">
  <?php echo link_to(image_tag($image,array("class"=>"admin_ico")).__("Perfil de la/el proveedora/or"),"@provider_profile?slug=".$provider->slug)?>
</div>     	
<?php if ($sf_user->isAuthenticated()):?>
  <?php if ($sf_user->getInternalUser()->id==$provider->id):?>
	<div class="provider_profile"><?php echo link_to(image_tag("admin/product_add", array("class"=>"admin_ico")).__("Añadir productos"),"product/add")?></div>
  <?php endif;?>
<?php endif;?>	 	 
    