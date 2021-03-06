<?php

/**
 * ProviderProduct
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    grupos_consumo
 * @subpackage model
 * @author     info@diphda.net
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class ProviderProduct extends BaseProviderProduct
{
  /*
   * devuelve la cantidad de veces que este producto
  * ha sido pedido por la peña
  * es para los productos más destacados del productor
  */
  public function getConsumerOrderCount()
  {
    return Doctrine::getTable("ConsumerOrder")->createQuery()->where("product_id=?",$this->product_id)->andWhere("provider_id=?",$this->provider_id)->count();
  }

  public function getDescription()
  {
    if ($this->content)
    {
      return $this->content;
    }

    return $this->Product->content;
  }

  public function getName()
  {
    return $this->Product->name;
  }

  public function getRealImage()
  {
    if ($this->image)
    {
      return $this->image;
    }

    return $this->Product->image;
  }

  public function hasProducts()
  {
    if (count($this->BasketProviderProduct))
    {
      return true;
    }

    return false;
  }

  public function getProviderSlug()
  {
    return $this->Provider->getSlug();
  }

  public function getDateCreatedAt()
  {
    $date=strtotime($this->getCreatedAt());

    return date("Y-m-d",$date);
  }
  /**
   * Devuelve la cantidad de producto según la orden
   * @param int $order_id
   * @return int
   */
  public function getAmountInOrder($order_id)
  {
    $query=Doctrine::getTable("ConsumerOrder")
    ->createQuery()
    ->select("sum(amount) as sum")
    ->where("order_id=?",$order_id)
    ->andWhere("consumer_order_state_id=?",1)
    ->andWhere("provider_product_id=?",$this->id)
    ->fetchOne();
    
    return $query['sum'];
  }
  
  /**
   * devuevle los consumidores que han pedido este producto para esta orden
   * @param unknown_type $order_id
   * @return Ambigous <>
   */
  public function getConsumersInOrder($order_id)
  {
    $query=Doctrine::getTable("ConsumerOrder")
    ->createQuery()
    ->select("count(id) as consumers")
    ->where("order_id=?",$order_id)
    ->andWhere("provider_product_id=?",$this->id)
    ->fetchOne();
  
    return $query['consumers'];
  }
}
