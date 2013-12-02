<?php

/**
 * consumer actions.
 *
 * @package    grupos_consumo
 * @subpackage consumer
 * @author     info@diphda.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class consumerActions extends sfActions
{

    public function executeAddProduct(sfWebRequest $request)
    {
        /*
         * le paso al formulario el objeto de la tabla ProviderProduct que viene del request         *
         */
        $this->product=Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("product_id"));
        $this->form=new ConsumerOrderForm(array(), array('product' => $this->product));

    }
    public function executeAdded(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->product=Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("product_id"));
        $this->form = new ConsumerOrderForm(array(), array('product' => $this->product));
        $this->processForm($request, $this->form);
        $this->setTemplate("addProduct");
    }

    public function executeModifyProduct(sfWebRequest $request)
    {
        $this->consumer_order = Doctrine::getTable("ConsumerOrder")->findOneById($request->getParameter("consumer_order_id"));
        $this->product=Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("product_id"));
        $this->form = new ConsumerOrderForm($this->consumer_order,array('product' => $this->product));
        $this->setTemplate("addProduct");
    }

    public function executeModified(sfWebRequest $request)
    {
        $this->consumer_order = Doctrine::getTable("ConsumerOrder")->findOneById($request->getParameter("consumer_order_id"));
        $this->product=Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("product_id"));
        $this->form = new ConsumerOrderForm($this->consumer_order,array('product' => $this->product));
        $this->processForm($request, $this->form);
        $this->setTemplate("addProduct");
    }

    public function executeDeleteConsumerOrder(sfWebRequest $request)
    {
        
        $this->consumer_order = Doctrine::getTable("ConsumerOrder")->findOneById($request->getParameter("consumer_order_id"));
        $this->consumer_order->delete();
        $this->getUser()->setFlash('notice', 'El pedido se ha eliminado correctamente.');
        $this->provider=Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
        $this->redirect('@provider_catalogue?slug='.$this->provider->slug);
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName()));
        if ($form->isValid()){
            $registro = $form->save();
            if ($form->isNew())
            {
                $this->getUser()->setFlash('notice', 'El pedido se ha añadido correctamente.'); 

            } else
            {
                $this->getUser()->setFlash('notice', 'El pedido se ha modificado correctamente.');
            }

            $this->redirect('@provider_catalogue?slug='.$registro->Provider->slug);
        }
    }
    
    public function executeProfile(sfWebRequest $request)
    {
        $this->consumer=Doctrine::getTable("Consumer")->findOneById($request->getParameter("id"));
    }

}
