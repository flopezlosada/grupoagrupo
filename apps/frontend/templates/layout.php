<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <link href='http://fonts.googleapis.com/css?family=Asap' rel='stylesheet' type='text/css'>
        <?php include_javascripts() ?>
        
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
            <div class="menu_area"><?php include_component("home","menu")?></div>
            
            <div class="midarea">           
            <!--  <div class="banner"><?php //echo link_to(image_tag("banner_goteo_horizontal.png"),"http://goteo.org/project/grupo-a-grupo")?></div>-->
                <?php echo $sf_content ?>
                
                 
            </div>
            <div class="right">    
                 <?php include_partial('global/news') ?>
                 
                 
                 <?php if ($sf_user->isAuthenticated()):?>
                     <?php include_component(strtolower($sf_user->getInternalClassName()),"warning")?>
                 <?php endif;?>                 
                 <?php include_component('sfApply', 'login') ?>  
                 
                 <?php include_component('sfWhoIsOnline','online');?>                
                <?php if (!$sf_user->isAuthenticated()):?>
                    <?php include_component("profile","statistics")?>
                <?php endif;?>      
                <?php include_component("profile","news")?>
                
                <?php include_component("event","last_events")?>
                <?php include_component_slot("utilities",array("type"=>"Announcement","is_consumer_group_only"=>false))?>
                <?php include_component_slot("utilities",array("type"=>"File","is_consumer_group_only"=>false))?>
            </div>
            
            <div class="clear"></div>
        </div>
        <div id="footer">
            <?php include_partial("global/footer")?>
        </div>
	</body>
</html>
