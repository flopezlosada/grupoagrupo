<?php

/**
 * profile actions.
 *
 * @package    grupos_consumo
 * @subpackage profile
 * @author     info@diphda.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profileActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeData(sfWebRequest $request)
  {
      $this->profile=$this->getUser()->getGuardUser()->Profile;
      $this->internal_class=$this->profile->InternalClass->class;
      $this->internal_user=$this->getUser()->getGuardUser()->{$this->internal_class};
      $this->order_states=Doctrine::getTable("OrderState")->createQuery()->orderBy("position asc")->execute();
      if ( !$this->internal_user->id){
          $this->redirect("register/complete");
      }
  }
}
