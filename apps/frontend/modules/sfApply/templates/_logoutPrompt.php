<?php use_helper('I18N') ?>

<div class="login_data">
<span><?php echo __("Usuarias/os")?></span>
<p>
<?php if ($sf_user->getInternalUser()->hasProfileImage()):?>
    <?php $image=basename(sfConfig::get('sf_upload_dir'))."/".basename(sfConfig::get('sf_provider_dir'))."/".basename(sfConfig::get('sf_provider_thumbnail_dir'))."/".$sf_user->getInternalUser()->image?>
<?php else:?>
    <?php $image="admin/".strtolower($sf_user->getInternalClassName())?>
<?php endif;?>
<?php echo link_to(image_tag($image, array("class"=>"profile_image")),"profile/data")?>

<?php echo $sf_user->getGuardUser()->getUsername()." (".$sf_user->getInternalClass()->name.")" ?>
</p>
<div class="clear"></div>
<?php if ($sf_user->getInternalClassName()=="Consumer"):?>
    <?php if ($sf_user->getInternalUser()->isProviderTrust()):?>		
		<p><?php echo __("Responsable de %1%",array("%1%"=>count($sf_user->getInternalUser()->getProviderTrust())))." ".
		format_number_choice("[1]".__("proveedora/or:")."|[1,+Inf]".__("proveedoras/es:"),array(),count($sf_user->getInternalUser()->getProviderTrust()))?></p>
		    <ul>
		        <?php foreach ($sf_user->getInternalUser()->getProviderTrust() as $provider):?>
		        	<li><?php echo link_to($provider->name,"@provider_profile?slug=".$provider->slug)?></li>
		        <?php endforeach;?>
		    </ul>	
    <?php endif;?>
<?php endif;?>
<p><?php echo link_to(__('Salir'), '@sf_guard_signout', array("id" => 'logout')) ?></p>
<div class="clear"></div>
</div>

