<?php

require_once dirname(__FILE__).'/../lib/link_categoryGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/link_categoryGeneratorHelper.class.php';

/**
 * link_category actions.
 *
 * @package    cinesinautor
 * @subpackage link_category
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class link_categoryActions extends autoLink_categoryActions
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

    
}
