<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>

<!-- 
	iconos: http://led24.de/iconset/
	http://www.famfamfam.com/lab/icons/silk/

-->
<div class="main">
	<div id="header" class="g1044">	
		
			<div class=logo>
				<?php  echo link_to(image_tag('logo.png'),"@homepage")?>
				<?php include_partial("global/menu")?>
			</div>  
			<div class=header_right>
			<h1>Grupos de Consumo</h1>
			<span>Lorem ipsum sit dolor</span>
			</div>  	    
        </div>
        <div class="clear"></div>    

	<div id="content">
		    		
    		<div class="g232"  id="left_column">
        		<?php include_component('sfApply', 'login') ?>
        		 <?php include_component_slot("utilities",array("type"=>"Announcement"))?>
        		 <?php include_component_slot("utilities",array("type"=>"File"))?>
        		 <?php include_component_slot("utilities",array("type"=>"Event"))?>
        	</div>
        	<div class=g812>
        	    <?php echo $sf_content ?>
        	</div>		        	
        	<div class="clear"></div>
    	</div>    	
		<div id="footer">
		
		</div>
		<div class="clear"></div>
		


	</div>
    

  </body>
</html>
