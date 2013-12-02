<div class="articles_list">
<?php include_partial("home/news",array("news"=>$pager->getResults()))?>
<?php if ($pager->haveToPaginate()): ?>
    <div class="pagination">
        <div class="page_list">
            <ul class="paging">
            	<li><a href="<?php echo url_for(sfContext::getInstance()->getModuleName()."/index")?>?page=1"> <?php echo __("Inicio")?> </a></li>
            		<?php foreach ($pager->getLinks() as $page): ?>
            		<?php if ($page == $pager->getPage()): ?>
            	<li><?php echo $page ?></li>
            		<?php else: ?>
            	<li><a
            		href="<?php echo url_for(sfContext::getInstance()->getModuleName()."/index") ?>?page=<?php echo $page ?>"><?php echo $page ?></a></li>
            		<?php endif; ?>
            		<?php endforeach; ?>
            
            		<li><a
            		href="<?php echo url_for(sfContext::getInstance()->getModuleName()."/index") ?>?page=<?php echo $pager->getLastPage() ?>"><?php echo __("Final")?>
            	 </a></li>
            </ul>        
        </div>
        <div class="page_count"><strong><?php echo $pager->getNbResults() ?></strong>
        <?php echo __("Artículos")?><?php if ($pager->haveToPaginate()): ?> - <?php echo __("página")?> <strong><?php echo $pager->getPage() ?> <?php echo __("de")?> <?php echo $pager->getLastPage() ?></strong>
        		<?php endif; ?></div>
          <div class=clear></div>
      </div>
<?php endif; ?>

</div>