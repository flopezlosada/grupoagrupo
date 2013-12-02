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
<?php echo __("La/el %s% %y% ha sido aceptada/o en tu grupo de consumo",array("%s%"=>$provider->ProviderType->name,"%y%"=>$provider->name))?><?php echo PHP_EOL?>
<?php echo __("Tú eres la persona responsable de este %y%",array("%y%"=>$provider->ProviderType->name))?><?php echo PHP_EOL?>
<?php echo __("A partir de ahora, podrás gestionar los pedidos")?><?php echo PHP_EOL?>