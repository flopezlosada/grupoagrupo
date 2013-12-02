<?php

/**
 * AceptedProviderConsumerGroup form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AceptedProviderConsumerGroupForm extends BaseAceptedProviderConsumerGroupForm
{
    public function configure()
    {
        unset($this['position']);
        unset($this["created_at"], $this["updated_at"]);
        $this->widgetSchema['provider_id'] = new sfWidgetFormInputTextObject(array("model"=>"Provider"));
        $this->setDefault("provider_id",sfContext::getInstance()->getRequest()->getParameter("provider_id"));
        $this->widgetSchema['provider_id']->setLabel("Proveedor");

        $this->widgetSchema['consumer_group_id'] = new sfWidgetFormInputTextObject(array("model"=>"ConsumerGroup"));
        $this->setDefault("consumer_group_id",sfContext::getInstance()->getUser()->getInternalUser()->ConsumerGroup->id);
        $this->widgetSchema['consumer_group_id']->setLabel("Grupo de consumo");

        $this->widgetSchema['acepted_provider_state_id'] = new sfWidgetFormInputHidden();
        $this->setDefault("acepted_provider_state_id",1);
        
        $this->widgetSchema['provider_consumer_trust_id']->setOption("expanded",true);
        $this->widgetSchema['provider_consumer_trust_id']->setLabel("Selecciona a la persona responsable de esta/e proveedora/or");
        $this->widgetSchema['provider_consumer_trust_id']->addOption("table_method","consumerInGroup");
        
        $this->widgetSchema["provider_consumer_trust_id"]->setAttribute("class","required large_label");
        $this->widgetSchema['provider_consumer_trust_id']->addOption('method', 'getCompletedName');
        
    }
}
