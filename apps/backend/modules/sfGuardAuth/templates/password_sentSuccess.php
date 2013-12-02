<div class="wrapper rounded-wrapper semi-width">
  <div class="wrapper-inside">
    <?php include_partial("components/flash_messages");?>
    <?php echo content_tag("dfn", __("This new password will be valid until %date%", 
          array("%date%"=>$date->format("Y-m-d H:i")), "password_restore"));?>
    <?php echo link_to(__("go to homepage", null, "password_restore"), "@homepage");?>
  </div>
</div>