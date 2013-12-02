<?php use_helper('I18N') ?>
<h3><?php echo __("Listado de Categorías de enlaces")?></h3>
<?php foreach ($categories as $category):?>
	<?php include_partial("category",array("category"=>$category))?>
<?php endforeach;?>