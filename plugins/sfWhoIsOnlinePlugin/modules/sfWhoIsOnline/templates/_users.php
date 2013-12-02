<div class="whoIsOnline">
<ul>
<?php foreach($users as $user): ?>
	<li>
		<?php echo $user->name ?>, <?php echo $user->ip ?>, <?php echo $user->city ?>, <?php echo $user->countrycode ?>, <?php echo $user->country ?> 
	</li>
<?php endforeach; ?>
</ul>
</div>