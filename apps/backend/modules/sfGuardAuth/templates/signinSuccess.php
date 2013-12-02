<?php use_helper("Url","I18N");?>
<div class="login-form">
<h2>Ingresar al Panel de Administración</h2>
	<div id="messages">
	    <?php echo $form->renderGlobalErrors();?>
	    <?php echo $form["username"]->renderError() ?>
	</div>
      <?php echo form_tag("@sf_guard_signin", array("method"=>"post"))?>
		<div class="input-box input-left">
          <?php echo $form["username"]->renderLabel() ?><br />
          <?php echo $form["username"]->render() ?>
		</div>
        <div class="input-box input-right">
          <?php echo $form["password"]->renderLabel() ?><br />
          <?php echo $form["password"]->render() ?>
<!--          <a href="<?php //echo url_for('@sf_guard_password') ?>"><?php //echo __('Forgot your password?') ?></a>-->
       </div>
       <div class="clear"></div> 
        <div class="form-buttons">
          <?php echo $form["remember"]->renderLabel();?>
          <?php echo $form["remember"]->render();?>
        
        
        
          <?php echo $form->renderHiddenFields();?>
          <span class="button"><input class='form-button' type="submit" value="<?php echo __('Sign in', null, "login")?>"></span>
        </div>
      </div>
      <p class="legal">Este software se distribuye bajo licencia GPL. Copyright &copy; 2010 Francisco López Losada & Sodepaz.</p>
      </form><div class="bottom"></div>
