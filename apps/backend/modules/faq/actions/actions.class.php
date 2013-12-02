<?php

require_once dirname(__FILE__).'/../lib/faqGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/faqGeneratorHelper.class.php';

/**
 * faq actions.
 *
 * @package    grupos_consumo
 * @subpackage faq
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class faqActions extends autoFaqActions
{
    public function executeMove(sfWebRequest $request)
    {
        $this->forward404Unless($request->isXmlHttpRequest());
        $this->forward404Unless($item = Doctrine::getTable($this->configuration->getModel())->find($request->getParameter('id')));

        $item->moveToPosition((int) $request->getParameter('rank', 1));

        return sfView::NONE;
    }

    public function getModel(){
        return "Faq";
    }
}
