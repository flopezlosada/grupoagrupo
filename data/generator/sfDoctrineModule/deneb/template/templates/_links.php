<?php
/* 
 * @package    
 * @subpackage 
 * @author     	diphda.net 
 * @version     
 * @date			01/12/2009


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
?>

<div id='nav'>
<ul class=mainMenu>		
	<li [?php if(sfContext::getInstance()->getModuleName()=="map_object"):?]class='active'[?php endif;?]>[?php echo link_to(__("Mapa"),"map_object/index",array("class"=>"mainLink"))?]	
	<li [?php if(sfContext::getInstance()->getModuleName()=="news"):?]class='active'[?php endif;?]>[?php echo link_to("Noticias","news/index",array("class"=>"mainLink"))?]
		<ul>
			<li>[?php echo link_to("Categorías","category/index",array("class"=>"mainLink"))?]</li>								
		</ul>
	</li>	
	<li [?php if(sfContext::getInstance()->getModuleName()=="link"||sfContext::getInstance()->getModuleName()=="link_category"):?]class='active'[?php endif;?]>[?php echo link_to("Enlaces","link/index",array("class"=>"mainLink"))?]
		<ul>
			<li>[?php echo link_to("Categorías","link_category/index",array("class"=>"mainLink"))?]</li>			
		</ul>	
	</li>
	<li [?php if(sfContext::getInstance()->getModuleName()=="file"):?]class='active'[?php endif;?]>[?php echo link_to(__("Archivos"),"file/index",array("class"=>"mainLink"))?]
	<li [?php if(sfContext::getInstance()->getModuleName()=="announcement"):?]class='active'[?php endif;?]>[?php echo link_to(__("Anuncios"),"announcement/index",array("class"=>"mainLink"))?]	
	<li [?php if(sfContext::getInstance()->getModuleName()=="product"):?]class='active'[?php endif;?]>[?php echo link_to(__("Productos"),"product/index",array("class"=>"mainLink"))?]
		<ul>
			<li [?php if(sfContext::getInstance()->getModuleName()=="product_category"):?]class='active'[?php endif;?]>[?php echo link_to(__("Categorías"),"product_category/index",array("class"=>"mainLink"))?]</li>
			<li [?php if(sfContext::getInstance()->getModuleName()=="product_subcategory"):?]class='active'[?php endif;?]>[?php echo link_to(__("Subcategorías"),"product_subcategory/index",array("class"=>"mainLink"))?]</li>	
		</ul>
	</li>
	
	
	
	<li [?php if(sfContext::getInstance()->getModuleName()=="event"||sfContext::getInstance()->getModuleName()=="event_category"||sfContext::getInstance()->getModuleName()=="venue"):?]class='active'[?php endif;?]>[?php echo link_to("Eventos","event/index",array("class"=>"mainLink"))?]
		<ul>
			<li>[?php echo link_to("Categorías","event_category/index",array("class"=>"mainLink"))?]</li>		
			<li>[?php echo link_to("Lugares","venue/index",array("class"=>"mainLink"))?]</li>
		</ul>
	</li>	
	<li [?php if(sfContext::getInstance()->getModuleName()=="internal_class"):?]class='active'[?php endif;?]>[?php echo link_to(__("Tablas"),"internal_class/index",array("class"=>"mainLink"))?]	
		<ul>
			<li [?php if(sfContext::getInstance()->getModuleName()=="internal_class"):?]class='active'[?php endif;?]>[?php echo link_to(__("Tipos de usuarios"),"internal_class/index",array("class"=>"mainLink"))?]		
			<li>[?php echo link_to("Unidades de venta","purchase_unit/index",array("class"=>"mainLink"))?]</li>		
			<li>[?php echo link_to("Tallas de ropa","product_size/index",array("class"=>"mainLink"))?]</li>
			<li>[?php echo link_to("Tipo de producción","production_type/index",array("class"=>"mainLink"))?]</li>		
			<li [?php if(sfContext::getInstance()->getModuleName()=="city"):?]class='active'[?php endif;?]>[?php echo link_to(__("Municipios"),"city/index",array("class"=>"mainLink"))?]
			<li [?php if(sfContext::getInstance()->getModuleName()=="state"):?]class='active'[?php endif;?]>[?php echo link_to(__("Provincias"),"state/index",array("class"=>"mainLink"))?]</li>		
			<li [?php if(sfContext::getInstance()->getModuleName()=="consumer_state"):?]class='active'[?php endif;?]>[?php echo link_to(__("Estado Consumidoras"),"consumer_state/index",array("class"=>"mainLink"))?]</li>
			<li [?php if(sfContext::getInstance()->getModuleName()=="consumer_group_state"):?]class='active'[?php endif;?]>[?php echo link_to(__("Estado Grupos"),"consumer_group_state/index",array("class"=>"mainLink"))?]</li>
			<li [?php if(sfContext::getInstance()->getModuleName()=="shipping_mode"):?]class='active'[?php endif;?]>[?php echo link_to(__("Métodos de envío"),"shipping_mode/index",array("class"=>"mainLink"))?]</li>
			<li [?php if(sfContext::getInstance()->getModuleName()=="payment_method"):?]class='active'[?php endif;?]>[?php echo link_to(__("Forma de pago"),"payment_method/index",array("class"=>"mainLink"))?]</li>
		</ul>
	</li>
	<li [?php if(sfContext::getInstance()->getModuleName()=="sfSimpleForumCategoryAdmin"):?]class='active'[?php endif;?]>[?php echo link_to(__("Foros"),"sfSimpleForumForumAdmin/index",array("class"=>"mainLink"))?]	
		<ul>
			<li>[?php echo link_to("Categorías del Foro","sfSimpleForumCategoryAdmin/index",array("class"=>"mainLink"))?]</li>		
			<li>[?php echo link_to("Ranks","sfSimpleForumRankAdmin/index",array("class"=>"mainLink"))?]</li>			
		</ul>
	</li>
	 <li [?php if(sfContext::getInstance()->getModuleName()=="sfGuardUser"):?]class='active'[?php endif;?]>[?php echo link_to("Usuarios","sfGuardUser/index",array("class"=>"mainLink"))?]
            <ul>
                <li>[?php echo link_to("Grupos","sfGuardGroup/index",array("class"=>"mainLink"))?]</li>
                <li>[?php echo link_to("Credenciales","sfGuardPermission/index",array("class"=>"mainLink"))?]</li>
                <li [?php if(sfContext::getInstance()->getModuleName()=="provider"):?]class='active'[?php endif;?]>[?php echo link_to(__("Productor@s"),"provider/index",array("class"=>"mainLink"))?]</li>
                <li [?php if(sfContext::getInstance()->getModuleName()=="consumer"):?]class='active'[?php endif;?]>[?php echo link_to(__("Consumidor@s"),"consumer/index",array("class"=>"mainLink"))?]</li>                
            </ul>
        </li>
      <li [?php if(sfContext::getInstance()->getModuleName()=="landing"):?]class='active'[?php endif;?]>[?php echo link_to(__("Estáticas"),"landing/index",array("class"=>"mainLink"))?]
      <li [?php if(sfContext::getInstance()->getModuleName()=="faq"):?]class='active'[?php endif;?]>[?php echo link_to(__("FAQs"),"faq/index",array("class"=>"mainLink"))?]
<li>[?php echo link_to(__("Salir"),"logout/index")?]</li>
</ul>
<h2 class=panel>[?php echo __("Panel de Administración")?]</h1>
</div>

