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
<?php use_helper("TextPurifier","Text")?>
<?php
    $file=sfConfig::get('sf_documents_dir')."/".$util->getFile();  
    $name=explode(".pdf",$util->getFile());    
    $name=sfConfig::get('sf_documents_thumbnail_dir')."/".$util->getPrevFile();
    $output = ' > /dev/null &';
    exec("/usr/bin/convert  -quality 80 -resize 100x100 -define pdf:use-cropbox=true  ".$file."[0] $name",$output);
?>
<h3><?php echo $util->name?></h3>
<?php if ($sf_user->isAuthenticated()):?>
    <?php if ($sf_user->getGuardUser()->getId()==$util->user_id||
            		        ($util->publish_state_id==7&&
            		        $util->consumer_group_id!==null&&
            		        $util->ConsumerGroup->consumer_trust_id==$sf_user->getInternalUser()->getId())):?>
            		       <?php include_partial("consumer_group/admin_util",array("util"=>$util,"type"=>$type))?>
            		        <div class=cleaner></div>
    <?php endif;?>
<?php endif;?>    
<?php  echo image_tag(basename(sfConfig::get('sf_upload_dir')).'/'.basename(sfConfig::get('sf_documents_dir')).'/'
				.basename(sfConfig::get('sf_documents_thumbnail_dir'))."/".$util->getPrevFile(),array("class"=>"fl image_show"))?>
<?php echo cleanPurifier($util->getContent("&",ESC_RAW))?>
<div class="clear"></div>
<?php echo link_to(image_tag("file", array("class"=>"group_ico")).$util->name,"/images/".basename(sfConfig::get('sf_upload_dir'))
        .'/'.basename(sfConfig::get('sf_documents_dir')).'/'.$util->getFile(),array("title"=>__("Descargar %&%",array('%&%'=>__($type)))));?>
<div class="clear"></div>
<div class="utilities_list">
  <div class="admin_box">  	  
    <?php echo link_to(image_tag("admin/".$type, array("class"=>"admin_ico")).__("Ver todos"),'@util_list_'.$type)?>
  </div>
</div>        