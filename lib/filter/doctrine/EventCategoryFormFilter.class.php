<?php

/**
 * EventCategory filter form.
 *
 * @package    cinesinautor
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventCategoryFormFilter extends BaseEventCategoryFormFilter
{
    public function configure()
    {
        $this->widgetSchema['name'] = new sfWidgetFormFilterInput();
        $this->validatorSchema['name'] = new sfValidatorPass();
    }

    public function addNameColumnQuery($query, $field, $value)
    {
        Doctrine::getTable('EventCategory')->applyNameFilter($query, $value);
    }

    public function getFields()
    {
        $fields = parent::getFields();
        $fields['name'] = 'text';
        return $fields;
    }
}
