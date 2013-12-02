<div class="whoIsOnline login_data">
    <span><?php echo __("En línea")?></span>
	<p><?php echo image_tag("admin/online", array ("class"=>"fr"))?>
	    <?php if ($count_logged):?>
	    <em><?php echo $count_logged ?> <?php echo __("Usuarias/os")?></em><br />
	    <?php endif?>
	    <?php if ($count_guest):?> 
    	<em><?php echo $count_guest ?> <?php echo __("Invitadas/os")?></em>
    	<?php endif;?>
    </p>
    <div class="clear"></div>
</div>