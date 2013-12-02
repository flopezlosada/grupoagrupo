<?php
/*
 © Copyright 2012 diphda.net && Sodepaz
 info@diphda.net


 Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia
 Pública General de GNU según es publicada por la Free Software Foundation, bien de la versión 3 de dicha
 Licencia o bien (según su elección) de cualquier versión posterior.

 Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin l
 garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la
 Licencia Pública General de GNU para más detalles.

 Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así,
 escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, MA 02139, EEUU.

 La licencia se encuentra en el archivo licencia.txt*/
?>

<li class="<?php echo sfContext::getInstance()->getRouting()->getCurrentInternalUri(true)=="@homepage"?"active":""?>"><?php echo link_to(__("Inicio"),"@homepage")?></li>
<li class="<?php echo sfContext::getInstance()->getRouting()->getCurrentInternalUri(true)=="@search_help?id=1"?"active":""?>"><?php echo link_to(__($search->menu_link),"@".$search->route)?></li>
<li class="<?php echo sfContext::getInstance()->getRouting()->getCurrentInternalUri(true)=="@sell_help?id=2"?"active":""?>"><?php echo link_to(__($sell->menu_link),"@".$sell->route)?></li>
<li class="<?php echo sfContext::getInstance()->getRouting()->getCurrentInternalUri(true)=="@create_group_help?id=3"?"active":""?>"><?php echo link_to(__($create->menu_link),"@".$create->route)?></li>
<li class="<?php echo sfContext::getInstance()->getModuleName()=="faq"?"active":""?>"><?php echo link_to(__("FAQs"),"faq/index")?></li>
<li class="<?php echo sfContext::getInstance()->getRouting()->getCurrentInternalUri(true)=="@contact"?"active":""?>"><?php echo link_to(__("Contacto"),"@contact")?></li>
<li class="<?php echo sfContext::getInstance()->getRouting()->getCurrentInternalUri(true)=="@sf_guard_signin"?"active":""?>"><?php echo link_to(__("Acceso"),"@sf_guard_signin")?></li>
