<?php include_partial('profile/flashes') ?>
<?php include_partial("profile/".strtolower($internal_class),array(strtolower($internal_class)=>$internal_user,"order_states"=>$order_states))?>
