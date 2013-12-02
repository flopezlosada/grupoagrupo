<div class="whoIsOnline">
	<div id="whoIsOnlinePanel" style="display: none;">
<?php include_component("sfWhoIsOnline","codes")?>
	</div>
	<em><?php echo $online ?></em> ONLINE <a href="#showCountries" onclick="jQuery('#whoIsOnlinePanel').toggle().css('top',jQuery(this).offset().top + 35); return false;"><?php echo image_tag("../sfWhoIsOnlinePlugin/images/down.gif") ?></a>
</div>