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


class profileComponents extends sfComponents
{
    public function executeMenubox(sfWebRequest $request)
    {
        $this->loggedIn = $this->getUser()->isAuthenticated();
        if ($this->loggedIn)
        {
            $this->profile=$this->getUser()->getGuardUser()->Profile;
            $this->internal_class=$this->profile->InternalClass->class;
            $this->internal_user=$this->getUser()->getGuardUser()->{$this->internal_class};
        }
    }
    
    public function executeUtilities(sfWebRequest $request)
    {        
        $query=Doctrine::getTable($this->type)
        ->createQuery();
        
        if ($this->is_consumer_group_only)
        {
             $query->whereIn("publish_state_id",7)
             ->andWhere("consumer_group_id=?",$this->getUser()->getInternalUser()->ConsumerGroup->id);
             
        } else 
        {
            $query->whereIn("publish_state_id",$this->getUser()->getAllowPublishStates());
        }
        
        $query->orderBy("created_at desc")->limit(5);
        $this->announcement=$query->execute();
    }
    
    public function executeStatistics()
    {
        $this->users=Doctrine::getTable("sfGuardUser")->createQuery()->count();
        $this->consumer_groups=Doctrine::getTable("ConsumerGroup")->createQuery()->count();
        $this->orders=Doctrine::getTable("Orders")->createQuery()->count();
        $this->providers=Doctrine::getTable("Provider")->createQuery()->count();
        $this->products=Doctrine::getTable("ProviderProduct")->createQuery()->groupBy("product_id")->count();
    }
    
    public function executeNews()
    {        
        $this->providers=Doctrine::getTable("Provider")->createQuery()->where("created_at > ?",date("Y-m-d",strtotime("-7 days")))->execute();
        $this->consumer_groups=Doctrine::getTable("ConsumerGroup")->createQuery()->where("created_at > ?",date("Y-m-d",strtotime("-7 days")))->execute();
        $providers=array();

        foreach ($this->providers as $order)
        {
            $providers[]=$order->id;
        }
        
        $this->provider_products=Doctrine::getTable("ProviderProduct")
        ->createQuery()
        ->where("created_at > ?",date("Y-m-d",strtotime("-7 days")))
        ->andWhereNotIn("provider_id",$providers)
        ->andWhere("is_active=?",1)
        ->groupBy("provider_id")->execute();
        
        $array_old_provider_products=array();
        $old_provider_products=Doctrine::getTable("ProviderProduct")
        ->createQuery()
        ->where("created_at <= ?",date("Y-m-d",strtotime("-14 days")))
        ->groupBy("product_id")
        ->execute();
        foreach ($old_provider_products as $item)
        {
          $array_old_provider_products[]=$item->product_id;
        }
        
        $this->new_provider_products=Doctrine::getTable("ProviderProduct")
        ->createQuery()
        ->where("created_at > ?",date("Y-m-d",strtotime("-14 days")))
        ->andWhereNotIn("product_id",$array_old_provider_products)
        ->groupBy("product_id")->execute();
    }
}
