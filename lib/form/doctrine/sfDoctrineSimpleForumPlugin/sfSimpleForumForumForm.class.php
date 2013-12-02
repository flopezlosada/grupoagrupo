<?php

/**
 * sfSimpleForumForum form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfSimpleForumForumForm extends PluginsfSimpleForumForumForm
{
    public function configure()
    {
        $this->validatorSchema["name"]->setOption("required",true);
        $this->validatorSchema["category_id"]->setOption("required",true);
    }
}

class sfSimpleForumForumGroupForm extends sfSimpleForumForumForm
{
    public function configure()
    {
        $this->widgetSchema['consumer_group_id']=new sfWidgetFormInputHidden();
        $this->widgetSchema['publish_state_id']=new sfWidgetFormInputHidden();
        $this->setDefault("consumer_group_id",sfContext::getInstance()->getUser()->getInternalUser()->ConsumerGroup->id);
       $this->setDefault("publish_state_id",7);//solo para mi grupo de consumo
       
       parent::configure();
    }
}