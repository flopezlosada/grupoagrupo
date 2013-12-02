<div class="whoIsOnline login_data">
    <span><?php echo __("En línea")?></span>
	<p>
	    <em><?php echo $count_logged ?> <?php echo __("Usuarias/os")?></em><br /> 
    	<em><?php echo $count_guest ?> <?php echo __("Invitadas/os")?></em><br />
    	<a href="#showCountries" onclick="jQuery('#whoIsOnlinePanel').toggle().css('top',jQuery(this).offset().top + 35); return false;">
    	    <?php echo image_tag("../sfWhoIsOnlinePlugin/images/down.gif").__("Detalle") ?>
    	</a>
	</p>
	<div id="whoIsOnlinePanel" style="display: none;">
        <?php include_component("sfWhoIsOnline","codes")?>
	</div>	
</div>