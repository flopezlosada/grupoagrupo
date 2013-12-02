<div class="blog_new">
  <h3><?php echo $post->name?></h3>
  <?php echo image_tag(basename(sfConfig::get('sf_upload_dir_name'))."/".$post->image, array("alt"=>$post->name,"class"=>"fr"))?>
  <?php echo truncate_text($post->getContent("&",ESC_RAW),500,"...",true)?>
  <div class="clear"></div>
  <?php echo link_to(__("Leer más"),"@blog_news?slug=".$post->slug)?>  
</div>