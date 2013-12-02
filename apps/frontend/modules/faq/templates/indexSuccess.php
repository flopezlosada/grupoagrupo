<h3><?php echo __("Preguntas frecuentes")?></h3>
<?php foreach ($faqs as $faq):?>
	<div class="faq_list">
		<span class="faq_question"><?php echo $faq->question?></span>
		<?php echo $faq->getAnswer("&",ESC_RAW)?>
	</div>
<?php endforeach;?>