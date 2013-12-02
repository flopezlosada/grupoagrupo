<?php

require_once dirname(__FILE__).'/../lib/categoryGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/categoryGeneratorHelper.class.php';

/**
 * category actions.
 *
 * @package    webs_proyectos
 * @subpackage category
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryActions extends autoCategoryActions
{
    public function executeNewnews(){
        $this->redirect("news/new?category_id=".$this->getRequestParameter('id'));
    }

    public function executePromote()
    {
        $object=Doctrine::getTable('Category')->findOneById($this->getRequestParameter('id'));


        $object->promote();
        $this->redirect("category/index");
    }

    public function executeDemote()
    {
        $object=Doctrine::getTable('Category')->findOneById($this->getRequestParameter('id'));

        $object->demote();
        $this->redirect("category/index");
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



}
