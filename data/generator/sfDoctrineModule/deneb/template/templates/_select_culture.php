[?php
/* 
 * @package    
 * @subpackage 
 * @author     	diphda.net 
 * @version     
 * @date			19/11/2009


Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia
Pública General de GNU según es publicada por la Free Software Foundation, bien de la versión 3 de dicha
Licencia o bien (según su elección) de cualquier versión posterior.

Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin la
garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la
Licencia Pública General de GNU para más detalles.

Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así,
escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, MA 02139, EEUU.

La licencia se encuentra en el archivo licencia.txt

*/
?]
[?php if($cultureTranslation ? $culture=$cultureTranslation:$culture=$sf_user->getCulture())?]
[?php if (count($default_languages)>1):?]
<p>
  [?php echo __('Traducir:')?]
  [?php foreach($default_languages as $language):?]
  	[?php if ($language[0]!=$culture):?]
  		[?php echo link_to(__($language[1]),"$module/edit?id=".$form->getObject()->id."&cultureTranslation=".$language[0])." | " ?]
  	[?php endif;?]
  [?php endforeach;?]

</p>
[?php endif;?]