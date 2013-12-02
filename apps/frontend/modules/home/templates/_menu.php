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

<nav>
    <ul>   
    	<?php if ($sf_user->isAuthenticated()):?>
    		<?php include_partial("home/menu_".strtolower($sf_user->getInternalClassName()))?>		
	    	
    	<?php else:?>
    		<?php include_partial("home/menu_guest",array("sell"=>$sell,"create"=>$create,"search"=>$search))?>
    	<?php endif;?>
    	<li><?php echo link_to(__("Blog"),"@blog")?>
    	<li><?php echo link_to(__("Enlaces"),"@link")?>
    	<?php if ($sf_user->isAuthenticated()):?>
    	  <li><?php echo link_to(__("Salir"),"@sf_guard_signout")?></li>	
    	<?php endif;?>
    </ul>
</nav>
