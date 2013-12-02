<div class="whoIsOnline">
<ul>
<?php foreach($codes as $code): ?>
	<li>
		<?php echo image_tag("../sfWhoIsOnlinePlugin/images/flags/".strtolower($code->countrycode).".gif") ?> <?php echo $code->country ?> (<?php echo $code->count ?>) 
	</li>
<?php endforeach; ?>
</ul>
</div>