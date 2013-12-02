<?php use_helper('I18N',"Util") ?>

<h2><?php echo __('La página a la que quieres acceder requiere permisos adicionales.', null, 'sf_guard') ?></h2>

<p><?php echo link_to("Ir a la portada",link_to_frontend("homepage",array()))?></p>
<p><?php echo link_to("Logout","@sf_guard_signout")?></p>
