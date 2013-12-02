<?php use_helper('I18N') ?>

<h3><?php echo $link->name?></h3>
	
    <?php echo link_to(image_tag(basename(sfConfig::get('sf_upload_dir'))
      .'/'.$link->image, 
        array("alt"=>$link->name, "title"=>$link->name, "class"=>"fr")),$link->http);?>
    <?php echo $link->getContent("&",ESC_RAW)?>
        
    <div class=clearer></div>
    <em><?php echo link_to(__("Pincha aquí para ver la página"),$link->http,array("target"=>"_blank", "class"=>"blank_link"))?></em>
