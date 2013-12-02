<?php

/**
 * ConsumerOrder form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ConsumerOrderForm extends BaseConsumerOrderForm
{
    public function configure()
    {
        $product=$this->getOption('product');
        unset($this['position'], $this['created_at'],$this['updated_at']);
        $this->widgetSchema->setFormFormatterName('list');

        $this->widgetSchema['product_id'] = new sfWidgetFormInputTextObject(array("model"=>"Product"));
        $this->setDefault("product_id",$product->Product->id);

        $this->widgetSchema['provider_id'] = new sfWidgetFormInputTextObject(array("model"=>"Provider"));
        $this->setDefault("provider_id",$product->Provider->id);

        $this->widgetSchema['consumer_order_state_id'] = new sfWidgetFormInputHidden();
        $this->setDefault("consumer_order_state_id",1);

        $this->widgetSchema['consumer_id'] = new sfWidgetFormInputHidden();
        $this->setDefault("consumer_id",sfContext::getInstance()->getUser()->getInternalUser()->id);

        $this->widgetSchema['order_id']= new sfWidgetFormInputHidden();

        $this->widgetSchema->setLabel("amount","Cantidad");
        $this->widgetSchema->setLabel("product_id","Producto");
        $this->widgetSchema->setLabel("provider_id","Proveedor");
        $this->widgetSchema->setHelp("amount","Indica la cantidad en ".$product->PurchaseUnit->name);
        /*
         * coge el valor de la orden abierta para el productor en cuestión. Es válido ya que sólo se puede tener abierto un pedido por productor y grupo
         */
        $this->setDefault("order_id",sfContext::getInstance()->getUser()->getInternalUser()->getProviderOpenOrder($product->Provider->id)->id);
    }
}


class ConsumerOrderIncreaseForm extends BaseConsumerOrderForm
{
    public function configure()
    {
        unset($this['position'], $this['created_at'],$this['updated_at']);
        $this->widgetSchema->setFormFormatterName('list');
         
        $order=$this->getOption('order');


        $this->widgetSchema['provider_id'] = new sfWidgetFormInputTextObject(array("model"=>"Provider"));
        $this->setDefault("provider_id",$order->Provider->id);
        $this->widgetSchema->setLabel("provider_id","Proveedor");
        if (sfContext::getInstance()->getUser()->getInternalUser()->canManageOrder($order->id))
        {
            $this->widgetSchema['consumer_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Consumer'), 'add_empty' => false,"table_method"=>"consumerInGroup"));
            $this->widgetSchema->setLabel("consumer_id","Consumidora/or");
        }
        else {
            $this->widgetSchema['consumer_id'] = new sfWidgetFormInputHidden();
            $this->setDefault("consumer_id",sfContext::getInstance()->getUser()->getInternalUser()->id);
        }


        $this->widgetSchema["product_id"]=new sfWidgetFormDoctrineChoiceParameters(array(
                                    'model'   => 'Product',
                                    'table_method' => array('method' => 'getProductProvider', 
                                    						'parameters' => array($order->Provider->id))
        ));
        //$this->widgetSchema['product_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => false));

        $this->widgetSchema['order_id']= new sfWidgetFormInputHidden();
        $this->setDefault("order_id",$order->id);
         
        $this->widgetSchema->setLabel("amount","Cantidad");
        
        $this->widgetSchema->setLabel("product_id","Producto");

        $this->validatorSchema->setPostValidator(new sfValidatorDoctrineUnique(array(
            "model"=>"ConsumerOrder",        	
            "column"=>array("consumer_id","order_id","product_id","provider_id","consumer_order_state_id"),
            "throw_global_error"=>true                         
        ),array("invalid"=>"La/el consumidora/or seleccionada/o ya ha pedido este producto")));

        $this->widgetSchema['consumer_order_state_id'] = new sfWidgetFormInputHidden();
        $this->setDefault("consumer_order_state_id",1);
    }
}