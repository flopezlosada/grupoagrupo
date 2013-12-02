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
<?php
/*
© Copyright 2011 diphda.net && Sodepaz
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
<?php use_helper("Date")?>
<div class="event_show">
<h3>
  <?php echo __("List of internal event  from consumer group %consumer_group%", array('%consumer_group%' => $sf_user->getInternalUser()->ConsumerGroup->name))?>
</h3>

<?php include_partial("profile/flashes")?>

    <?php if (count($pager->getResults())):?>        
      <?php foreach($pager->getResults() as $i=>$event):$odd = fmod(++$i, 2) ? 'odd' : 'even'?>
      <span class="normal_title"><?php echo $event->name?></span>        
        <?php include_partial("event/event",array("event"=>$event))?>
        <div class="clear"></div>
      <?php endforeach;?>        
    <?php else:?>
    	<p><?php echo __('There is not any publish event')?></p>
    <?php endif;?>
     <?php if ($pager->haveToPaginate()): ?>
    <div class="pagination">
        <div class="page_list">
            <ul class="paging">
            	<li><a href="<?php echo url_for('event/show_group?slug='.$sf_user->getInternalUser()->ConsumerGroup->slug."&page=1")?>"><?php echo __("Inicio")?> </a></li>
            		<?php foreach ($pager->getLinks() as $page): ?>
            		<?php if ($page == $pager->getPage()): ?>
            	<li><?php echo $page ?></li>
            		<?php else: ?>
            	<li><a
            		href="<?php echo url_for('event/show_group?slug='.$sf_user->getInternalUser()->ConsumerGroup->slug."&page=".$page)?>"><?php echo $page ?></a></li>
            		<?php endif; ?>
            		<?php endforeach; ?>
            
            		<li><a
            		href="<?php echo url_for('event/show_group?slug='.$sf_user->getInternalUser()->ConsumerGroup->slug."&page=".$pager->getLastPage()) ?>"><?php echo __("Final")?>
            	 </a></li>
            </ul>        
        </div>
        <div class="page_count"><strong><?php echo $pager->getNbResults() ?></strong>
        <?php echo __("Eventos")?><?php if ($pager->haveToPaginate()): ?> - <?php echo __("página")?> <strong><?php echo $pager->getPage() ?> <?php echo __("de")?> <?php echo $pager->getLastPage() ?></strong>
        		<?php endif; ?></div>
          
      </div>
      <div class=clearer></div>
<?php endif; ?>

<?php include_partial("event/actions")?>
</div>
