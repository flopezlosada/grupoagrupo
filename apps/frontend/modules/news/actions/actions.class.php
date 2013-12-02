<?php

/**
 * news actions.
 *
 * @package    palestina
 * @subpackage news
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeShow(sfWebRequest $request)
  {
    $this->new=Doctrine::getTable("News")
    ->createQuery("a")
    ->leftJoin("a.Translation t")
    ->where("t.slug=?",$request->getParameter("slug"))
    ->fetchOne();

    $this->categories=Doctrine::getTable("Category")->findAllSorted('ASCENDING');
    $this->category_id=$this->new->category_id;
    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N'));    
    $this->getResponse()->setTitle(__("Grupos de consumo. ").$this->new->name);
  }
}
