<?php
/*
© Copyright 2012 diphda.net && Sodepaz
info@diphda.net


Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia
Pública General de GNU según es publicada por la Free Software Foundation, bien de la versión 3 de dicha
Licencia o bien (según su elección) de cualquier versión posterior.

Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin la
garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la
Licencia Pública General de GNU para más detalles.

Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así,
escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, MA 02139, EEUU.

La licencia se encuentra en el archivo licencia.txt*/
?>
<li	class="<?php echo sfContext::getInstance()->getModuleName()=="home"?"active":""?>"><?php echo link_to(__("Buscar"),"@homepage")?></li>
<?php if ($sf_user->getInternalUser()->belongConsumerGroup()):?>
	 
	<li	class="<?php echo sfContext::getInstance()->getModuleName()=="profile"?"active":""?>">
	    <?php echo link_to(__($sf_user->getInternalUser()->ConsumerGroup->name),"profile/data")?></li>
	 <li	class="<?php echo sfContext::getInstance()->getModuleName()=="consumer_group"?"active":""?>"><?php echo link_to(__("Administración"),"@admin")?></li>  
	 <li	class="<?php echo sfContext::getInstance()->getModuleName()=="sfSimpleForum" ? "active":""?>"><?php echo link_to(__("Foro"),"consumer_group/forum")?></li>
<?php else:?>
	    <li	class="<?php echo sfContext::getInstance()->getModuleName()=="consumer_group"?"active":""?>"><?php echo link_to(__("Administración"),"@admin")?></li>  
<?php endif;?>