<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
        <link href='http://fonts.googleapis.com/css?family=Asap'' rel='stylesheet' type='text/css'>
    </head>
	<body>
       <div id="topheader">
            <div class="logo">
            </div>
             <div class="warning">GRUPOAGRUPO.NET ESTÁ EN PRUEBAS. Puedes registrarte para aparecer en el 
    								mapa y explorar las funciones del site, pero por ahora no todo 
    								funcionará como esperas. ¡Estamos trabajando en ello! Escríbenos: 
    								info@grupoagrupo.net"
    		</div>
    		<div class="clear"></div>            
        </div>
        <div id="body_area">
            <div class="menu_area"><?php include_component("home","menu")?></div><div class="clear"></div>  
        	<div class="left_catalogue">
        	<?php include_component("provider","categories")?>
        	</div>
            <div class="midarea_catalogue">
                <?php echo $sf_content ?>
            </div>
            <!--<div class="right">    
                 <?php /* include_component('sfApply', 'login') ?>     
                <?php include_component_slot("utilities",array("type"=>"Event","is_consumer_group_only"=>false))?>
                <?php include_component_slot("utilities",array("type"=>"Announcement","is_consumer_group_only"=>false))?>
                <?php include_component_slot("utilities",array("type"=>"File","is_consumer_group_only"=>false))?>
                <?php if (!$sf_user->isAuthenticated()):?>
                    <?php include_component("profile","statistics")?>
                <?php endif;*/?>      
            </div>
            
            --><div class="clear"></div>
        </div>
        <div id="footer">
            <?php include_partial("global/footer")?>
        </div>
	</body>
</html>
