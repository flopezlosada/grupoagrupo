<?php

/**
 * sfApply actions.
 *
 * @package    5seven5
 * @subpackage sfApply
 * @author     Tom Boutell, tom@punkave.com
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */

// Autoloader can't find this


class eventComponents extends sfComponents
{
 
  public function executeLast_events(sfWebRequest $request)
  {
    $this->events=Doctrine::getTable("Event")
      ->createQuery()      
      ->whereIn("publish_state_id",$this->getUser()->getAllowPublishStates())
      ->andWhere("start_date>=?",date("Y-m-d"))
      ->orderBy("start_date desc")
      ->andWhere('published=?',1)
      ->limit(5)
      ->execute();
  }
  
  public function executeConsumer_group_events(sfWebRequest $request)
  {
    $this->consumer_group=Doctrine::getTable("ConsumerGroup")->findOneById($this->consumer_group_id);
    $this->events=Doctrine::getTable("Event")
    ->createQuery()
    ->whereIn("publish_state_id",7)
    ->andWhere("consumer_group_id=?",$this->consumer_group_id)
    ->andWhere("start_date>=?",date("Y-m-d"))
    ->orderBy("start_date desc")
    ->andWhere('published=?',1)
    ->limit(5)
    ->execute();
  }
    
}
