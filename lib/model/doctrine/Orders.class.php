<?php

/**
 * Orders
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    grupos_consumo
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Orders extends BaseOrders
{
  /*
   * devuelve los consumidores que han hecho pedidos en este pedido
  * Es para ordenar los pedidos segregados, para mostrar los pedidos agrupados
  * por consumidor. Si no, saldrían sin ordenar
  */
  public function getConsumers()
  {
    $query=Doctrine::getTable("ConsumerOrder")->createQuery()->where("order_id=?",$this->id)->andWhere("consumer_order_state_id=?",1)->execute();

    $consumers=array();
    foreach ($query as $consumer_order)
    {
      $consumers[]=$consumer_order->consumer_id;

    }
    if (count($consumers))
    {
      return Doctrine::getTable("Consumer")->createQuery()->whereIn("id",$consumers)->execute();
    }
    /*
     * si no hay ninguno, devuelve un array vacío.
    */
    return array();
  }

  /*
   * Devuelve los consumidores que no han hecho pedido
  */
  public function getConsumerNoOrder()
  {
    $query=Doctrine::getTable("ConsumerOrder")->createQuery()->where("order_id=?",$this->id)->andWhere("consumer_order_state_id=?",1)->execute();

    $consumers=array();
    foreach ($query as $consumer_order)
    {
      $consumers[]=$consumer_order->consumer_id;

    }

    return Doctrine::getTable("Consumer")->createQuery()->whereNotIn("id",$consumers)->andWhere("consumer_group_id=?",$this->consumer_group_id)->execute();

  }
  /*
   * devuelve un array con los emails de los consumidores que han hecho pedido en la orden (objeto) dada
  */

  public function getAllConsumerOrder()
  {
    $emails=array();
    foreach ($this->getConsumers() as $consumer)
    {
      $emails[]=$consumer->email;
    }


    return $emails;
  }

  /*
   * devuelve el precio total del pedido
  */
  public function getTotalPrice()
  {
    $price=0;
    foreach ($this->getConsumers() as $consumer)
    {
      $price+=$consumer->getTotalPriceOrder($this->id);
    }

    return $price;
  }


  /**
   * Dependiendo de si es el responsable o un productor, devuelve el listado de consumidores
   * de esta orden.
   * si es un consumidor simple, devuelve sólo el propio consumidor
   * devuelve un array para un foreach;
   */
  public function getAllowConsumers()
  {
    if (sfContext::getInstance()->getUser()->getInternalUser()->canManageOrder($this->id))
    {
      return $this->getConsumers();
    }
    else if (sfContext::getInstance()->getUser()->getInternalUser()->hasStartOrder($this->id))
    {
      return array(sfContext::getInstance()->getUser()->getInternalUser());
    }

    return array();
  }

  /**
   * Devuelve el listado de provider_product de esta orden
   * @return Ambigous <Doctrine_Collection, mixed, PDOStatement, Doctrine_Adapter_Statement, Doctrine_Connection_Statement, unknown, number>
   */

  public function getAllProducts()
  {
    return $query=Doctrine::getTable("ProviderProduct")
    ->createQuery('a')
    ->leftJoin("a.ConsumerOrder c")
    ->where('c.order_id=?',$this->id)
    ->andWhere("c.consumer_order_state_id=?",1)
    ->groupBy ('c.provider_product_id')
    ->orderBy('a.short_description asc')
    ->execute();
  }

  /*
   * esta función busca si hay alguna modificación en los pedidos de los consumidores
  */

  public function hasModifiedConsumerOrder()
  {
    $query=Doctrine::getTable("ConsumerOrder")
    ->createQuery()
    ->where("order_id=?",$this->id)
    ->andWhere("consumer_order_state_id=?",2);

    if ($query->count())
    {
      return true;
    }

    return false;
  }

}

