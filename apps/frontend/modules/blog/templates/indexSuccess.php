<?php use_helper("Text")?>
<?php if (count($pager->getResults())):?>
 <?php foreach($pager->getResults() as $i=>$post):$odd = fmod(++$i, 2) ? 'odd' : 'even'?>
   <?php include_partial("blog/post",array("post"=>$post))?>
<?php endforeach;?>
<?php else:?>
    	<p><?php echo __('There is not any publish post')?></p>
    <?php endif;?>

<?php if ($pager->haveToPaginate()): ?>
    <div class="blog_pagination">
        
            <ul class="blog_paging dark">
            	<li  class="prev"><a href="<?php echo url_for("blog/index?page=1")?>"><?php echo __("Inicio")?> </a></li>
            		<?php foreach ($pager->getLinks() as $page): ?>
            		<?php if ($page == $pager->getPage()): ?>
            	<li><?php echo $page ?></li>
            		<?php else: ?>
            	<li><a
            		href="<?php echo url_for("blog/index?page=".$page)?>"><?php echo $page ?></a></li>
            		<?php endif; ?>
            		<?php endforeach; ?>
            
            		<li  class="next"> <a
            		href="<?php echo url_for("blog/index?page=".$pager->getLastPage()) ?>"><?php echo __("Final")?>
            	 </a></li>
            </ul>
        </div>
      
      <div class=clearer></div>
<?php endif; ?>  