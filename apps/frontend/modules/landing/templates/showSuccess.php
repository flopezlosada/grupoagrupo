<div class="landing">
	<h3><?php echo $landing->name?></h3>
    <?php echo image_tag(basename(sfConfig::get('sf_upload_dir_name'))."/".$landing->image,array("class"=>"fr"))?>
    <?php echo $landing->getContent("&",ESC_RAW)?>
</div>