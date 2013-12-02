<?php

/**
 * link actions.
 *
 * @package    cinesinautor
 * @subpackage link
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class linkActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->categories=Doctrine::getTable("LinkCategory")->findAllSorted("ASCENDING");
         
    }

    public function executeShowLink(sfWebRequest $request)
    {
        $this->link=Doctrine::getTable("Link")
        ->createQuery("a")
        ->leftJoin("a.Translation t")
        ->where("t.slug=?",$request->getParameter("slug"))
        ->fetchOne();
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N'));        
        $this->getResponse()->setTitle(__("Grupos de consumo. ").$this->link->name);
         
    }

    public function executeShowCategory(sfWebRequest $request)
    {
        $this->category=Doctrine::getTable("LinkCategory")
        ->createQuery("a")
        ->leftJoin("a.Translation t")
        ->where("t.slug=?",$request->getParameter("slug"))
        ->fetchOne();
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N'));        
        $this->getResponse()->setTitle(__("Grupos de consumo. ").$this->category->name);
                 
    }
}
