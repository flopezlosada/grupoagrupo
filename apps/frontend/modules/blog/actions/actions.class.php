<?php

/**
 * blog actions.
 *
 * @package    grupos_consumo
 * @subpackage blog
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class blogActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $query=Doctrine::getTable("News")->createQuery()->orderBy("created_at desc");
    $this->pager = new sfDoctrinePager("News",
        sfConfig::get('app_post_list')
    );
    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }
}
