<?php

/**
 * landing actions.
 *
 * @package    grupos_consumo
 * @subpackage landing
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class landingActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeShow(sfWebRequest $request)
    {        
        $this->landing=Doctrine::getTable("Landing")
        ->createQuery("a")
        ->leftJoin("a.Translation t")
        ->where("a.route=?",$request->getParameter("route"))
        ->andWhere("t.lang=?",$this->getUser()->getCulture())
        ->fetchOne();
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N'));
        $this->getResponse()->setTitle(__("Grupos de consumo. ").$this->landing->name);
    }
    
    /*public function executeSlug()
    {
      $p=Doctrine::getTable("ProviderProduct")->findAll();
      foreach ($p as $a)
      {
        if ($a->slug==null)
        {
        $a->setSlug(Doctrine_Inflector::urlize($a->short_description));
        $a->save();
        }
      }
    }*/
}
