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
<?php use_helper("Date","Text")?>
<?php if (count($events)):?>

<div class="login_data">
	<span><?php echo __("Eventos")?> </span>
	<?php echo image_tag("admin/event", array ("class"=>"fr"))?>
	<ul>
		<?php foreach($events as $event):?>
          <?php if ($event->publish_state_id==7):?>
            <?php if ($sf_user->hasCredential("consumer")):?>
              <?php if ($event->consumer_group_id==$sf_user->getInternalUser()->getConsumerGroupId()):?>
                <li>
       		      <?php echo format_datetime($event->start_date,"D","es_ES")?>
        		  <br />
    		      <?php echo link_to($event->name,"@event?slug=".$event->slug,array("class"=>"comments_link"))?>
    		      <br />
    		      <?php echo truncate_text(strip_tags($event->getContent("&",ESC_RAW)),30,"...",false)?>
		        </li>
              <?php endif;?>
            <?php endif;?>
          <?php else:?>
            <li>
       		    <?php echo format_datetime($event->start_date,"D","es_ES")?>
        		<br />
    		    <?php echo link_to($event->name,"@event?slug=".$event->slug,array("class"=>"comments_link"))?>
    		    <br />
    		    <?php echo truncate_text(strip_tags($event->getContent("&",ESC_RAW)),30,"...",false)?>
		    </li>   
          <?php endif;?>
    		
		<?php endforeach;?>
	</ul>
	<div class=clearer></div>
	<?php echo link_to(__("Ver todos"),"@events")?>
</div>
<?php endif;?>