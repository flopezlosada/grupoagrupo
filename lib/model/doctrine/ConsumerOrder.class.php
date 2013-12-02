<?php

/**
 * ConsumerOrder
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    grupos_consumo
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class ConsumerOrder extends BaseConsumerOrder
{
    public function getPurchaseUnitName()
    {
        $productProvider=$this->getProviderProduct();

        return $productProvider->PurchaseUnit->name;
    }

    /*public function getProviderProduct()
    {
         return $query=Doctrine::getTable("ProviderProduct")->createQuery()
        ->where("product_id=?",$this->product_id)
        ->andWhere("provider_id=?",$this->provider_id)
        ->fetchOne();
    }*/

    /*
     * devuelve el gasto que supone esta orden.
     * Multiplica el precio del producto por la cantidad
     */
    public function getMoneyConsumerOrder()
    {
         $productProvider=$this->getProviderProduct();
         
         return $productProvider->price*$this->amount;
    }
    /*
     * comprueba que exista una orden de modificación de la orden actual
     * sirve para ver si ya existe, no se creará, para mantener el pedido original.
     */
    public function hasModifyOrder()
    {
        $query=Doctrine::getTable("ConsumerOrder")->createQuery()
        ->where("order_id=?",$this->order_id)
        ->andWhere("consumer_id=?",$this->consumer_id)
        ->andWhere("product_id=?",$this->product_id)
        ->andWhere("provider_id=?",$this->provider_id)
        ->andWhereIn("consumer_order_state_id",array(2,3));

        if ($query->count())
        {

            return true;

        }

        return false;

    }

    /*
     * comprueba que exista una orden de modificación de la orden actual y en su caso la devuelve 
     */
    public function getModifyOrder()
    {
        if ($this->hasModifyOrder()){
            $query=Doctrine::getTable("ConsumerOrder")->createQuery()
            ->where("order_id=?",$this->order_id)
            ->andWhere("consumer_id=?",$this->consumer_id)
            ->andWhere("product_id=?",$this->product_id)
            ->andWhere("provider_id=?",$this->provider_id)
            ->andWhere("consumer_order_state_id=?",2)
            ->fetchOne();
            
            return $query;
        }

        return false;

    }
}
