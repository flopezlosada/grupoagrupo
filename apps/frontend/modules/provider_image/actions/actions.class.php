<?php

/**
 * provider_image actions.
 *
 * @package    grupos_consumo
 * @subpackage provider_image
 * @author     info@diphda.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class provider_imageActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeAdd(sfWebRequest $request)
    {
        $this->form=new ProviderImageForm();
    }

    public function executeAdded(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new ProviderImageForm();
        $this->processForm($request, $this->form);
        $this->setTemplate("add");
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()){
            $registro = $form->save();
            if ($form->isNew())
            {
                $this->getUser()->setFlash('notice', 'La imagen se ha añadido correctamente.');
            } else
            {
                $this->getUser()->setFlash('notice', 'La imagen se ha modificado correctamente.');
            }
            $this->redirect('profile/data?id='.$this->getUser()->getGuardUser()->id);
        }
    }

    public function executeModify(sfWebRequest $request)
    {
        $this->product = Doctrine::getTable("ProviderImage")->findOneById($request->getParameter("id"));
        $this->form = new ProviderImageForm($this->product);
        $this->setTemplate("add");
    }

    public function executeModified(sfWebRequest $request)
    {
        $this->product = Doctrine::getTable("ProviderImage")->findOneById($request->getParameter("id"));
        $this->form = new ProviderImageForm($this->product);
        $this->processForm($request, $this->form);
    }

    public function executeDelete(sfWebRequest $request)
    {
        $this->product = Doctrine::getTable("ProviderImage")->findOneById($request->getParameter("id"));

        if ($this->product->delete())
        {
            $this->getUser()->setFlash('notice', 'La imagen se ha eliminado correctamente.');
        }

        $this->redirect('profile/data?id='.$this->getUser()->getGuardUser()->id);
    }
}
