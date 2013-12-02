<?php

/**
 * product actions.
 *
 * @package    grupos_consumo
 * @subpackage product
 * @author     info@diphda.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('default', 'module');
    }

    public function executeAdd(sfWebRequest $request)
    {
        $this->form=new ProviderProductForm();
    }

    public function executeAdded(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new ProviderProductForm();
        $this->processForm($request, $this->form);
        $this->setTemplate("add");
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName()));
        if ($form->isValid()){
            $registro = $form->save();
            if ($form->isNew())
            {
                $this->getUser()->setFlash('notice', 'El producto se ha añadido correctamente.');
            } else
            {
                $this->getUser()->setFlash('notice', 'El producto se ha modificado correctamente.');
            }
            $this->redirect("@provider_product?provider_slug=".$registro->Provider->slug."&provider_product_slug=".$registro->slug);
        }
    }

    public function executeModify(sfWebRequest $request)
    {
        $this->product = Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("id"));
        $this->form = new ProviderProductForm($this->product);
        $this->setTemplate("add");
    }

    public function executeModified(sfWebRequest $request)
    {
        $this->product = Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("id"));
        $this->form = new ProviderProductForm($this->product);
        $this->processForm($request, $this->form);
        $this->setTemplate("add");
    }

    public function executeDelete(sfWebRequest $request)
    {
        /*
         * los productos se desactivan, no se borran
        * además, hay que borrar los pedidos hechos que no hayan sido finalizados
        */

        $this->provider_product = Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("id"));
        $this->provider_product->is_active=0;


        $query=Doctrine::getTable("ConsumerOrder")->createQuery("l")
        ->leftJoin("l.Orders o")
        ->where("o.order_state_id<9")
        ->andWhere("l.product_id=".$request->getParameter("id"))
        ->andWhere("l.provider_id=".$this->getUser()->getInternalUser()->id)
        ->execute();

        foreach ($query as $consumer_order)
        {
            $this->sendMail($consumer_order->Consumer->email,sfConfig::get("app_default_mailfrom"),
                    "El producto ".$this->provider_product->short_description." ha sido eliminado del catálogo de la/el proveedora/or ".$this->provider_product->Provider->name,
                    "Revisa tu pedido porque ha sufrido modificaciones.");
            $consumer_order->delete();
        }



        $this->provider_product->save();
        $this->getUser()->setFlash('notice', 'El producto se ha eliminado correctamente.');



        $this->redirect('profile/data?id='.$this->getUser()->getGuardUser()->id);
    }


    public function executeShow(sfWebRequest $request)
    {
        if ($request->hasParameter("provider_id"))
        {
            $this->provider= Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
        }
        if ($request->hasParameter("provider_slug"))
        {
          $this->provider= Doctrine::getTable("Provider")->findOneBySlug($request->getParameter("provider_slug"));
        }
        else {
            $this->provider=$this->provider = $this->getUser()->getInternalUser();
        }
        if ($request->hasParameter("id"))
        {
          $this->provider_product = Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("id"));
        } 
        else if ($request->hasParameter("provider_product_slug"))
        {
          $this->provider_product = Doctrine::getTable("ProviderProduct")->findOneBySlug($request->getParameter("provider_product_slug"));
        }
        else 
        {
          $this->provider_product = Doctrine::getTable("ProviderProduct")->findOneById(1);
        }
        
        if ($request->getParameter("buy_consumer_id"))
        {
            $this->buyConsumer=Doctrine::getTable("Consumer")->findOneById($request->getParameter("buy_consumer_id"));
        }
        else if ($this->getUser()->hasCredential("consumer")) {
            $this->buyConsumer=$this->getUser()->getInternalUser();
        }

        if (isset($this->buyConsumer)&&$this->buyConsumer->canBuyProduct($this->provider_product->provider_id))
        {            
            $this->order=$this->buyConsumer->getProviderOpenOrder($this->provider_product->provider_id);
        }

        if ($this->provider_product->provider_product_type_id==2)
        {
            $this->setTemplate("show_basket");
        }
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N'));        
        $this->getResponse()->setTitle(__("Grupos de consumo. ").$this->provider_product->short_description);
    }

    public function sendMail($to,$from,$subject,$body){
        $mensaje = Swift_Message::newInstance();
        $mensaje->setFrom($from);
        $mensaje->setTo($to);
        $mensaje->setSubject($subject);
        $mensaje->setBody($body);
        $this->getMailer()->send($mensaje);
    }

    public function executeAvailable(sfWebRequest $request)
    {
        $this->provider_product = Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("id"));

        if ($this->provider_product->provider_product_type_id==2)
        {
            $name='La cesta ';
        }
        else if ($this->provider_product->provider_product_type_id==1)
        {
            $name='El producto ';
        }


        if ($request->getParameter("type")=="quit")
        {
            $this->provider_product->is_in_stock=0;
            $this->getUser()->setFlash('notice', 'Se ha quitado la disponibilidad del producto correctamente.');
        }
        else
        {
            $this->provider_product->is_in_stock=1;
            $this->getUser()->setFlash('notice', $name.$this->provider_product->short_description.' está disponible para la venta.');
        }

        $this->provider_product->save();
        $this->redirect("@provider_product?provider_slug=".$this->provider_product->Provider->slug."&provider_product_slug=".$this->provider_product->slug);
    }

    public function executeAdd_basket(sfWebRequest $request)
    {
        $this->form=new BasketForm();
    }

    public function executeAdded_basket(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod('post'));
        $this->form = new BasketForm();
        $this->processBasketForm($request, $this->form);
        $this->setTemplate("add_basket");
    }

    protected function processBasketForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName()));
        if ($form->isValid()){
            $registro = $form->save();
            if ($form->isNew())
            {
                $this->getUser()->setFlash('notice', 'La cesta se ha añadido correctamente. Ahora debes añadir los productos');
                $this->redirect('product/basket_add_product?basket_id='.$registro->id);
            } else
            {
                $this->getUser()->setFlash('notice', 'La cesta se ha modificado correctamente.');
                $this->redirect("@provider_product?provider_slug=".$registro->Provider->slug."&provider_product_slug=".$registro->slug);
            }

        }
    }

    public function executeModify_basket(sfWebRequest $request)
    {
        $this->basket = Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("id"));
        $this->form = new BasketForm($this->basket);
        $this->setTemplate("add_basket");
    }

    public function executeModified_basket(sfWebRequest $request)
    {
        $this->basket = Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("id"));
        $this->form = new BasketForm($this->basket);
        $this->processBasketForm($request, $this->form);
        $this->setTemplate("add_basket");
    }

    public function executeBasket_add_product(sfWebRequest $request)
    {
        $this->basket=Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("basket_id"));
        //si la cesta ya existe, puede que tenga productos ya añadidos, entonces no se mostrarán en la lista.
        $products_included=array();
        $query=Doctrine::getTable("BasketProviderProduct")->createQuery()->where("basket_id=?",$request->getParameter("basket_id"))->execute();
        foreach ($query as $product)
        {
            $products_included[]=$product->provider_product_id;
        }
        $this->provider_products=Doctrine::getTable("ProviderProduct")
        ->createQuery()
        ->where("provider_id=?",$this->basket->provider_id)
        ->andWhereNotIn("id",$products_included)
        ->andWhere("provider_product_type_id=?",1)
        ->execute();
    }

    public function executeBasket_added_product(sfWebRequest $request)
    {
        $basket_id=$request->getParameter("basket_id");
        $product_selected=$request->getParameter("product_selected");
        $product=$request->getParameter("product");

        /*
         * extraigo sólo los índices que han sido seleccionados, con valor 1. Ahora tengo los ids de los productos seleccionados en un array
        * después le doy la vuelta con array_flip porque si no los valores que necesito (ids de productos seleccionados) para la función array_key_exists son valores y no claves
        * al darle la vuelta ya son claves y lo puedo usar en la comparación
        */
        $product_selected_reduce=array_flip(array_keys($product_selected,"1"));
        //var_dump($product_selected_reduce);

        foreach ($product as $key=>$value)
        {
            if (array_key_exists($key, $product_selected_reduce))
            {
                $product_final[]=array($key,$value);
            }
        }

        foreach ($product_final as $provider_product)
        {
            $basket_provider_product=new BasketProviderProduct();
            $basket_provider_product->basket_id=$basket_id;
            $basket_provider_product->provider_product_id=$provider_product[0];
            $basket_provider_product->amount=$provider_product[1];
            $basket_provider_product->save();
        }

        $this->redirect("@provider_product?provider_slug=".$basket_provider_product->ProviderProduct->Provider->slug."&provider_product_slug=".$basket_provider_product->getBasketSlug());
    }

    public function executeShow_basket(sfWebRequest $request)
    {
        if ($request->hasParameter("basket_id"))
        {
            $basket_id=$request->getParameter("basket_id");
        }
        elseif ($request->hasParameter("id"))
        {
            $basket_id=$request->getParameter("id");
        }
        $this->basket=Doctrine::getTable("ProviderProduct")->findOneById($basket_id);
    }


    public function executeModify_basket_product_amount(sfWebRequest $request)
    {
        $this->amount = $request->getParameter("amount");
        $this->basket_provider_product = Doctrine::getTable("BasketProviderProduct")
        ->findOneById($request->getParameter("id"));
        if ($request->getParameter("amount") != ''&& $request->getParameter("amount") >= 0)
        {          
            /*
             * Modifico la original para que funcione más fácil el ajax, en lugar de dejarla como
            * está y crear otra.
            * Además, es más fácil comprobar que existe la modificada así.
            */
            $this->basket_provider_product->setAmount($request->getParameter("amount"));
            $this->basket_provider_product->save();            
        }
    }
    public function executeDelete_basket_product(sfWebRequest $request)
    {
        $this->basket_provider_product = Doctrine::getTable("BasketProviderProduct")
        ->findOneById($request->getParameter("basket_provider_product_id"));
        $this->basket_provider_product->delete();
        $this->getUser()->setFlash('notice', 'El producto se ha eliminado de la cesta correctamente.');
        $this->redirect("@provider_product?provider_slug=".$this->basket_provider_product->ProviderProduct->Provider->slug."&provider_product_slug=".$this->basket_provider_product->getBasketSlug());
        
    }
}