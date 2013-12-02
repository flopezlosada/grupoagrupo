<?php
/*
© Copyright 2010 diphda.net && Sodepaz
flopezlosada@yahoo.es


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
<div class="sf_admin_list">
  <?php if (!$pager->getNbResults()): ?>
    <p><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
    <table cellspacing="0" id="sf_item_table">
      <thead>
        <tr>
          <th id="sf_admin_list_batch_actions"><input id="sf_admin_list_batch_checkbox" type="checkbox" onclick="checkAll();" /></th>
          <?php include_partial(
            $sf_request->getParameter('module').'/list_th_tabular',
            array('sort' => $sort)
          ) ?>
          <th id="sf_admin_list_th_actions">
            <?php echo __('Actions', array(), 'sf_admin') ?>
          </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="<?php echo $colspan ?>">
            <?php if ($pager->haveToPaginate()): ?>
              <?php include_partial(
                $sf_request->getParameter('module').'/pagination',
                array('pager' => $pager)
              ) ?>
            <?php endif; ?>
            <?php echo format_number_choice(
              '[0] no result|[1] 1 result|(1,+Inf] %1% results', 
              array('%1%' => $pager->getNbResults()),
              $pager->getNbResults(), 'sf_admin'
            ) ?>
            <?php if ($pager->haveToPaginate()): ?>
              <?php echo __('(page %%page%%/%%nb_pages%%)', array(
                '%%page%%' => $pager->getPage(), 
                '%%nb_pages%%' => $pager->getLastPage()), 
                'sf_admin'
              ) ?>
            <?php endif; ?>
          </th>
        </tr>
      </tfoot>
      <tbody>
      <?php foreach ($pager->getResults() as $i => $item): ?>
        <?php $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
        <tr class="sf_admin_row <?php echo $odd ?>">
          <?php include_partial($sf_request->getParameter('module').'/list_td_batch_actions',
              array( $sf_request->getParameter('module')  => $item,'helper' => $helper)) ?>
          <?php include_partial(
            $sf_request->getParameter('module').'/list_td_tabular', 
            array(
              $sf_request->getParameter('module')  => $item
          )) ?>
            <?php include_partial(
              $sf_request->getParameter('module').'/list_td_actions',
              array(
                 $sf_request->getParameter('module')  => $item, 
                'helper' => $helper
            )) ?>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
  </div>
  <script type="text/javascript">
    /* <![CDATA[ */
    function checkAll() {
      var boxes = document.getElementsByTagName('input'); 
      for (var index = 0; index < boxes.length; index++) { 
        box = boxes[index]; 
        if (
          box.type == 'checkbox' 
          && 
          box.className == 'sf_admin_batch_checkbox'
        ) 
        box.checked = document.getElementById('sf_admin_list_batch_checkbox').checked 
      }
      return true;
    }
    /* ]]> */
  </script>
  <script type="text/javascript" charset="utf-8">
  $().ready(function() {
    $("#sf_item_table").tableDnD({
      onDrop: function(table, row) {
        var rows = table.tBodies[0].rows;
 
        // Get the moved item's id
        var movedId = $(row).find('td input:checkbox').val();
 
        // Calculate the new row's position
        var pos = 1;
        for (var i = 0; i<rows.length; i++) {
          var cells = rows[i].childNodes;
          // Perform the ajax request for the new position
          if (movedId == $(cells[1]).find('input:checkbox').val()) {
            $.ajax({
              url:"<?php echo url_for('@'. $sf_request->getParameter('module').'_move') ?>?id="+ movedId +"&rank="+ pos,
              type:"GET"
            });
            break;
          }
          pos++;
        }
      },
    });
  });
</script>