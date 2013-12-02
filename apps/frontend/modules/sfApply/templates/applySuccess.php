<?php use_helper('I18N', "jQuery","jQueryValidator") ?>
<?php
  // Override the login slot so that we don't get a login prompt on the
  // apply page, which is just odd-looking. 0.6
?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<div class="sf_apply sf_apply_settings provider_form">
<h2><?php echo __("Apply for an Account") ?></h2>
<form method="POST" action="<?php echo url_for('sfApply/apply') ?>"
  name="sf_apply_apply_form" id="sf_apply_apply_form">
<ul>
<?php echo $form ?>
<li class="sf_apply_submit_row">
<label></label>
<input type="submit" value="<?php echo __("Create My Account") ?>" /> 
<?php echo __("or") ?> 
<?php echo link_to(__("Cancel"), sfConfig::get('app_sfApplyPlugin_after', '@homepage')) ?>
</li>
</ul>
</form>
</div>
<?php echo jquery_validate_form($form, "sf_apply_apply_form");?>

<script>
//Certificate name field is only required if a certificate is requested
$('#sfApplyApply_username').rules('add', {
	required: true,
	messages: {
		required: "<?php echo __("Debes indicar un nombre de usuaria/o")?>"
	}
});
$(function() {
    var tooltips = $( "[title]" ).tooltip({
    	 position: {
             my: "left+15 center",
             at: "right center",
             using: function( position, feedback ) {
                 $( this ).css( position );
                 }
    	 },
    	 tooltipClass: "login_tooltip"
    });
});    
</script>
