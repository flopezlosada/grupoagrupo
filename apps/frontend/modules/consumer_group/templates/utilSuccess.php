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
<h3>

<?php if (sfContext::getInstance()->getModuleName()=="consumer_group"):?>
    <?php if ($consumer_group_only):?>
        <?php echo __("List of internal %type%s from consumer group %consumer_group%", array('%type%'=>__($type),'%consumer_group%' => $sf_user->getInternalUser()->ConsumerGroup->name))?>
    <?php else:?>
        <?php echo __("List of %type%s", array('%type%'=>__($type)))?>
    <?php endif;?>
<?php elseif (sfContext::getInstance()->getModuleName()=="provider"): ?>
    <?php echo __("List of %type%s of provider %&%",array("%&%"=>$provider->getFullName(),'%type%'=>__($type)))?>
<?php endif;?>
</h3>
<?php include_partial("profile/flashes")?>
    <div class="utilities_list">
      <?php if (count($pager->getResults())):?>        
        <?php foreach($pager->getResults() as $i=>$util):$odd = fmod(++$i, 2) ? 'odd' : 'even'?>            	  
          <?php include_partial("consumer_group/$type",array("$type"=>$util,"util"=>$util,"type"=>$type))?>           	
        <?php endforeach;?>        
      <?php else:?>
      	<p><?php echo __('There is not any publish '.$type)?></p>
      <?php endif;?>
      <div class='clear'></div>
    </div>
   <?php if ($pager->haveToPaginate()): ?>     
    <div class="pagination">
        <div class="blog_pagination">
            <ul class="blog_paging light">
            	<li><a href="<?php echo url_for(sfContext::getInstance()->getModuleName()."/util?type=".$type."&page=1")?>"><?php echo __("Inicio")?> </a></li>
            		<?php foreach ($pager->getLinks() as $page): ?>
            		<?php if ($page == $pager->getPage()): ?>
            	<li><?php echo $page ?></li>
            		<?php else: ?>
            	<li><a
            		href="<?php echo url_for(sfContext::getInstance()->getModuleName()."/util?type=".$type."&page=".$page)?>"><?php echo $page ?></a></li>
            		<?php endif; ?>
            		<?php endforeach; ?>
            
            		<li><a
            		href="<?php echo url_for(sfContext::getInstance()->getModuleName()."/util?type=".$type."&page=".$pager->getLastPage()) ?>"><?php echo __("Final")?>
            	 </a></li>
            </ul>        
        </div>
      </div>
      <div class=clearer></div>
    <?php endif; ?>

<?php if ($sf_user->isAuthenticated()):?>  
  	  <?php if (sfContext::getInstance()->getModuleName()=="consumer_group"||($sf_user->getGuardUser()->getId()==$util->user_id)):?>
  	    <div class="utilities_list">
          <div class="admin_box">
            <?php echo link_to(image_tag("admin/".$type."_add", array("class"=>"admin_ico")).__("Add %&%",array("%&%"=>__($type))),sfContext::getInstance()->getModuleName()."/utilAdd?type=".$type)?>
          </div>
        </div>
      <?php endif;?>    
<?php endif;?>