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
?><div class="footer_links">
<div align="center">
    <?php echo link_to(__("Inicio"),"@homepage")?> | 
    <?php echo link_to(__("Quiénes Somos"),"@about")?> |
    <?php echo link_to(__("El proyecto"),"@project")?> |
    <?php echo link_to(__("Contacto"),"@contact")?> |
    <?php echo link_to(__("Política de privacidad"),"@privacity")?> | 
    <?php echo link_to(__("Agradecimientos"),"@greetings")?>
	
</div>
</div>
<div class="follow_us">
  <ul class="social_list">
    <li><?php echo link_to(image_tag("social/twitter.png"),"https://twitter.com/Grupo_agrupo",array("target"=>"_blank"))?></li>    
    <li><?php echo link_to(image_tag("social/facebook.png"),"https://www.facebook.com/GrupoaGrupo",array("target"=>"_blank"))?></li>
  </ul>  
</div>
<div class="footer_copyrights">
<div align="center">&copy; Sodepaz.</div>
</div>
<!--<div class="footer_validation">
<div align="center"><a href="http://validator.w3.org/check?uri=referer"
	target="_blank" class="xhtml">XHTML</a> <a
	href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank"
	class="css">CSS</a><br />
</div>
</div>
<div class="footer_designed">
<div align="center">Designed By : <a href="#"
	class="footer_designedlink">Template World</a></div>
</div>-->