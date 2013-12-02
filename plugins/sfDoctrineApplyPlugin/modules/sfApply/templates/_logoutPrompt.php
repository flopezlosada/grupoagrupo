<?php use_helper('I18N') ?>

<div class="login_data">
<span><?php echo __("Usuarias/os")?></span>
<p>
<?php echo __("Logged in as %1% (%2%)", 
  array("%1%" => $sf_user->getGuardUser()->getUsername(),"%2%"=>$sf_user->getInternalClass()->name)) ?>
</p>
<?php if ($sf_user->getInternalClassName()=="Consumer"):?>
    <?php if ($sf_user->getInternalUser()->isProviderTrust()):?>
	
		
		<p><?php echo __("Responsable de %1%",array("%1%"=>count($sf_user->getInternalUser()->getProviderTrust())))." ".
		format_number_choice("[1]".__("proveedora/or:")."|[1,+Inf]".__("proveedoras/es:"),
		    array(),count($sf_user->getInternalUser()->getProviderTrust()))?></p>
		    <ul>
		        <?php foreach ($sf_user->getInternalUser()->getProviderTrust() as $provider):?>
		        	<li><?php echo link_to($provider->name,"provider/profile?id=".$provider->id)?></li>
		        <?php endforeach;?>
		    </ul>
	
    <?php endif;?>
<?php endif;?>
<p><?php echo link_to(__('Salir'), '@sf_guard_signout', array("id" => 'logout')) ?></p>
<div class="clear"></div>
</div>

