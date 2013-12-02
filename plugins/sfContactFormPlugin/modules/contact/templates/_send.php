
<h3>You received a new message from <?php echo $sf_request->getUri() ?></h3>

<p>
  Name:<strong> <?php echo $form->getValue('name') ?></strong><br />
  Email:<strong> <?php echo $form->getValue('email') ?></strong><br />
  Message:<strong> <?php echo nl2br($form->getValue('message')) ?></strong><br />

</p>
<p>&nbsp;</p>
------------- <br/>

