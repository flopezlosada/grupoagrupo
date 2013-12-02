<?php

/**
 * Orders form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OrdersForm extends BaseOrdersForm
{
    public function configure()
    {
        unset($this['position']);
        unset($this["created_at"], $this["updated_at"]);
        $this->widgetSchema->setFormFormatterName('list');
        $this->widgetSchema['consumer_id']= new sfWidgetFormInputHidden();
        if ($this->isNew())
        {
            $this->widgetSchema['group_creation_date']= new sfWidgetFormInputHidden();
            $this->setDefault("group_creation_date",date("Y-m-d H:m:s"));
        }

        /*
         * Con esto saco el consumidor responsable del proveedor.
         * Así, el responsable del productor en cada momento es el responsable del pedido que se abre. 
         * Esto es por si se cambia a lo largo del tiempo el responsable de un productor, que se mantenga el consumidor
         * de cada momento, y porque el admin puede abrir pedidos, pero el responsable tiene que ser el trust
         */
        $provider=$this->getOption("provider");

        $this->setDefault("consumer_id",$provider->getAceptedInGroup(sfContext::getInstance()->getUser()->getInternalUser()->consumer_group_id)->provider_consumer_trust_id);


        $this->widgetSchema['consumer_group_id']= new sfWidgetFormInputHidden();
        $this->setDefault("consumer_group_id",sfContext::getInstance()->getUser()->getInternalUser()->consumer_group_id);

        $this->widgetSchema['provider_id']= new sfWidgetFormInputHidden();
        $this->setDefault("provider_id",sfContext::getInstance()->getRequest()->getParameter("provider_id"));

        $this->widgetSchema['order_state_id']= new sfWidgetFormInputHidden();
        $this->setDefault("order_state_id",1);

        $this->widgetSchema['date_in']= new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,"culture"=>"es"));
        $this->widgetSchema['date_out']= new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,"culture"=>"es"));

        $this->validatorSchema->setPostValidator(
        new sfValidatorSchemaCompare('date_in', sfValidatorSchemaCompare::LESS_THAN, 'date_out',
        array(),
        array('invalid' => 'La fecha de cierre del pedido debe ser posterior a la fecha de apertura')
        )
        );

         
        $this->widgetSchema["shipping_mode_id"]=new sfWidgetFormDoctrineChoiceParameters(array(
                                    'model'   => 'ShippingMode',
                                    'table_method' => array('method' => 'getShippingModeProvider', 
                                    						'parameters' => array(sfContext::getInstance()->getRequest()->getParameter("provider_id")))
        ));

        $this->widgetSchema["payment_method_id"]=new sfWidgetFormDoctrineChoiceParameters(array(
                                    'model'   => 'PaymentMethod',
                                    'table_method' => array('method' => 'getPaymentMethodProvider', 
                                    						'parameters' => array(sfContext::getInstance()->getRequest()->getParameter("provider_id")))
        ));


        $this->widgetSchema->setLabel("date_in","Fecha de apertura del pedido");
        $this->widgetSchema->setLabel("date_out","Fecha de cierre del pedido");
        $this->widgetSchema->setLabel("payment_method_id","Forma de pago");
        $this->widgetSchema->setLabel("shipping_mode_id","Método de envío");
        $this->widgetSchema->setLabel("name","Nombre");
        $this->widgetSchema->setLabel("group_comment","Comentarios para el grupo");
        $this->widgetSchema->setLabel("provider_comment","Comentarios para la/el proveedora/or");
        $this->widgetSchema->setHelp("group_comment","Este comentario es privado y sólo tendrán acceso a él las/os miembros del grupo.");
        $this->widgetSchema->setHelp("provider_comment","Este comentario le llegará a la/el proveedora/or.");

        $this->widgetSchema->setHelp("name","Indica un nombre para el pedido");

        $this->widgetSchema["name"]->setAttribute("class","required");
        $this->widgetSchema["date_in"]->setAttribute("class","required");
        $this->widgetSchema["date_out"]->setAttribute("class","required");

    }
}

class OpenOrderForm extends OrdersForm
{
    public function configure()
    {
        parent::configure();
        if (!$this->isNew()&&($this->getObject()->date_in<=date("Y-m-d")))
        {
            $this->widgetSchema['date_in']= new sfWidgetFormInputDate();
            $this->widgetSchema->setLabel("date_in","Fecha de apertura del pedido");
        }

        if ($this->getObject()->order_state_id==2)
        {
            $this->widgetSchema['date_out']= new sfWidgetFormInputDate();
            $this->widgetSchema->setLabel("date_out","Fecha de cierre del pedido");
        }
    }

    public function updateObject($values = null)
    {
        $object = parent::updateObject($values);
        $object->setOrderStateId(1);
        return $object;
    }
}

class ExtendsOrderForm extends OrdersForm
{
    public function configure()
    {
        parent::configure();
        if (!$this->isNew()&&($this->getObject()->date_in<=date("Y-m-d")))
        {
            $this->widgetSchema['date_in']= new sfWidgetFormInputDate();
        }

        $this->widgetSchema->setLabel("date_in","Fecha de apertura del pedido");
        $this->widgetSchema['payment_method_id']= new sfWidgetFormInputHidden();
        $this->widgetSchema['shipping_mode_id']= new sfWidgetFormInputHidden();
        $this->widgetSchema['name']= new sfWidgetFormInputHidden();

    } 
}
