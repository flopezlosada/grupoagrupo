<?php use_helper('I18N') ?>


<h4><?php echo __("Acceso a usuarias/os")?></h4>
<div class="sf_apply sf_apply_settings">
<form method="POST" action="<?php echo url_for("@sf_guard_signin") ?>" name="sf_guard_signin" id="sf_guard_signin" class="sf_apply_signin_inline">
  
	<?php echo $form->renderGlobalErrors() ?>
	<?php echo $form->renderHiddenFields() ?>	
	<ul>
		<li>
    		<?php echo $form['username']->renderError() ?>    		
    		<?php echo $form['username']->renderLabel() ?><?php echo $form['username'] ?>                                
    	</li>
    	<li>
    		<?php echo $form['password']->renderError() ?>    		
    		<?php echo $form['password']->renderLabel() ?><?php echo $form['password'] ?>                                
    	</li>
    	<li>
    		<?php echo $form['remember']->renderError() ?>    		
    		<?php echo $form['remember']->renderLabel() ?><?php echo $form['remember'] ?>                                
    	</li>    	
    </ul>
    
  <p class="margin_p"><input type="submit" class="submit" value="<?php echo __('Acceder') ?>" /></p>
  <p>
  <?php echo link_to(__('Reset Your Password'), 'sfApply/resetRequest')  ?> <br />
  <?php echo link_to(__('Create a New Account'), 'sfApply/apply')
  ?>
  </p>
</form>
</div>

