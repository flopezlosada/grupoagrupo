<?php
/*
 © Copyright 2013diphda.net && sodepaz.org
info@diphda.net
sodepaz@sodepaz.org


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

<script>	
$(document).ready(function() {
    $("#social").tabs()
    });
	</script>
<div id="social">	
<ul>
  <li><a href="#tabs-1" ><?php echo __("Twitter")?></a></li>
  <li><a href="#tabs-2"><?php echo __("Facebook")?></a></li>  
      
</ul>	
	<div class="twitter"  id='tabs-1'>
		<a class="twitter-timeline" href="https://twitter.com/Grupo_agrupo"
			data-widget-id="311884837927657473"
			lang="<?php echo $sf_user->getCulture()?>">Tweets de @Grupo_agrupo</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);
                  js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>
	<div class="facebook"  id='tabs-2'>
		<script type="text/javascript"
			src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/<?php echo $sf_user->getCulture()?>_ES"></script>
		
		<fb:fan profile_id="477881455612129" stream="1" connections="12"
			logobar="0" width="520" height="300" 
			css="http://www.webpartnersworldwide.com/templates/ja_rasite/css/template.css"></fb:fan>
	</div>
</div>
