<?php

/**
 * Product filter form.
 *
 * @package    grupos_consumo
 * @subpackage filter
 * @author     info@diphda.net
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductFormFilter extends BaseProductFormFilter
{
  public function configure()
  {
    $this->widgetSchema['product_subcategory_id'] = new sfWidgetFormDoctrineDependentSelect(array(
        'model'     => 'ProductSubcategory',
        'depends'   => 'ProductCategory',
        'ajax'		=> true,
        'add_empty' => 'Selecciona Subcategoría'));
  }
}
