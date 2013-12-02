<?php

require_once dirname(__FILE__).'/../lib/homeGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/homeGeneratorHelper.class.php';

/**
 * home actions.
 *
 * @package    palestina
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends autoHomeActions
{
    public function executeMove(sfWebRequest $request)
    {
        $this->forward404Unless($request->isXmlHttpRequest());
        $this->forward404Unless($item = Doctrine::getTable($this->configuration->getModel())->find($request->getParameter('id')));

        $item->moveToPosition((int) $request->getParameter('rank', 1));

        return sfView::NONE;
    }
    
    public function executeEditObject(sfWebRequest $request){
         $this->home = $this->getRoute()->getObject();
           $this->redirect(sfInflector::underscore($this->home->object_class)."/edit?id=".$this->home->getObject()->id);
    }
}
