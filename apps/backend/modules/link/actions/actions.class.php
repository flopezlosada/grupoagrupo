<?php

require_once dirname(__FILE__).'/../lib/linkGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/linkGeneratorHelper.class.php';

/**
 * link actions.
 *
 * @package    cinesinautor
 * @subpackage link
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class linkActions extends autoLinkActions
{
    public function preExecute(){
        $this->default_languages = sfConfig::get("app_default_languages");
        $this->cultureTranslation=null;
        $this->moduleConfig=$this->moduleName;
        parent::preExecute();
    }

    public function executeEdit(sfWebRequest $request)
    {
        if ($request->getParameter("cultureTranslation"))
        {
            $this->cultureTranslation=$request->getParameter("cultureTranslation");
            sfContext::getInstance()->getUser()->setFlash("cultureTranslation",$request->getParameter("cultureTranslation"));
        }
        parent::executeEdit($request);
    }

    public function executeMove(sfWebRequest $request)
    {
        $this->forward404Unless($request->isXmlHttpRequest());
        $this->forward404Unless($item = Doctrine::getTable($this->configuration->getModel())->find($request->getParameter('id')));

        $item->moveToPosition((int) $request->getParameter('rank', 1));

        return sfView::NONE;
    }

    public function executeDelhome(sfWebRequest $request){
        $query=Doctrine::getTable("Home")
        ->createQuery("a")
        ->delete("Home")
        ->where("object_id=? and object_class=?",array($request->getParameter("id"),$this->configuration->getModel()))
        ->execute();
        $this->getUser()->setFlash('notice', 'El enlace se ha eliminado de la portada correctamente.');
        $this->redirect("link/index");
    }
     
    public function executeGohome(sfWebRequest $request){
        $newHome= new Home();
        $newHome->object_id=$request->getParameter("id");
        $newHome->object_class=$this->configuration->getModel();
        $newHome->save();
        $this->getUser()->setFlash('notice', 'El enlace se ha publicado en la portada correctamente.');
        $this->redirect("link/index");
    }
}
