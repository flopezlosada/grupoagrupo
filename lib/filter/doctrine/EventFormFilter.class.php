<?php

/**
 * Event filter form.
 *
 * @package    cinesinautor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventFormFilter extends BaseEventFormFilter
{
    public function configure()
    {
        $this->widgetSchema['name'] = new sfWidgetFormFilterInput();
        $this->validatorSchema['name'] = new sfValidatorPass();
        $this->widgetSchema['date']=
        new sfWidgetFormFilterDate(array(
            'from_date' => new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,"culture"=>"es")),
            'to_date' => new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,"culture"=>"es")), 'with_empty' => false));
        $this->widgetSchema['end_date']=
        new sfWidgetFormFilterDate(array(
            'from_date' => new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,"culture"=>"es")),
            'to_date' => new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,"culture"=>"es")), 'with_empty' => false));
    }

    public function addNameColumnQuery($query, $field, $value)
    {
        Doctrine::getTable('Event')->applyNameFilter($query, $value);
    }

    public function getFields()
    {
        $fields = parent::getFields();
        $fields['name'] = 'text';
        return $fields;
    }
}
