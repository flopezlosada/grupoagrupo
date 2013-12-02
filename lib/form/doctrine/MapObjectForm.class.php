<?php

/**
 * MapObject form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MapObjectForm extends BaseMapObjectForm
{
  public function configure()
  {
      unset( $this['created_at'],$this['updated_at']);
      $this->widgetSchema->setFormFormatterName('list');
      $this->widgetSchema['state_id'] =  new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('State'),
       'add_empty' => 'Selecciona Provincia', "table_method"=>"getStateList"));

        $this->widgetSchema['city_id'] = new sfWidgetFormDoctrineDependentSelect(array(
         'model'     => 'City',
         'depends'   => 'State',        
         'table_method' => "getCityList",         
         'ajax'		=> true,
         'add_empty' => 'Selecciona Municipio'));
        
        $this->widgetSchema->setLabel("state_id","Provincia");
        $this->widgetSchema->setLabel("city_id","Municipio");
        $this->widgetSchema->setLabel("name","Nombre");
        $this->widgetSchema->setLabel("map_object_type_id","Tipo de contacto");
        $this->widgetSchema->setLabel("contact","¿Quiere ser contactado?");
        $this->widgetSchema->setLabel("email","Correo electrónico");
        
        $this->validatorSchema['email'] = new sfValidatorEmail(array("required"=>false));
  }
}
