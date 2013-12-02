<?php

require_once dirname(__FILE__).'/../lib/newsGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/newsGeneratorHelper.class.php';

/**
 * news actions.
 *
 * @package    webs_proyectos
 * @subpackage news
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsActions extends autoNewsActions
{
    public function executePromote()
    {
        $object=Doctrine::getTable('News')->findOneById($this->getRequestParameter('id'));
        $object->promote();
        $this->redirect("news/index");
    }

    public function executeDemote()
    {
        $object=Doctrine::getTable('News')->findOneById($this->getRequestParameter('id'));
        $object->demote();
        $this->redirect("news/index");
    }

    public function preExecute(){
        $this->default_languages = sfConfig::get("app_default_languages");
        $this->cultureTranslation=null;
        $this->moduleConfig=$this->moduleName;
        parent::preExecute();
    }


    public function executeCreate(sfWebRequest $request)    {
        sfValidatorBase::setDefaultMessage("required",$this->getContext()->getI18N()->__('Este valor es obligatorio.',null,"sf_admin"));
        parent::executeCreate($request);

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
        $this->delHome($request);
        $this->getUser()->setFlash('notice', 'La noticia se ha eliminado de la portada correctamente.');
        $this->redirect("news/index");
    }

    public function delHome(sfWebRequest $request){
        $query=Doctrine::getTable("Home")
        ->createQuery("a")
        ->delete("Home")
        ->where("object_id=? and object_class=?",array($request->getParameter("id"),$this->configuration->getModel()))
        ->execute();
    }
     
    public function executeGohome(sfWebRequest $request){
        $newHome= new Home();
        $newHome->object_id=$request->getParameter("id");
        $newHome->object_class=$this->configuration->getModel();
        $newHome->save();
        $newHome->moveToFirst();
        $this->getUser()->setFlash('notice', 'La noticia se ha publicado en la portada correctamente.');
        $this->redirect("news/index");
    }

    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

        if ($this->getRoute()->getObject()->delete())
        {
            $this->delHome($request);
            $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
        }

        $this->redirect('@news');
    }

}
