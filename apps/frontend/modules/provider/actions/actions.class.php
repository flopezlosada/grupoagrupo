<?php

/**
 * provider actions.
 *
 * @package    grupos_consumo
 * @subpackage provider
 * @author     info@diphda.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class providerActions extends sfActions
{

  public function preExecute()
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->profile = $this->getUser()->getGuardUser()->Profile;
      $this->internal_class = $this->profile->InternalClass->class;
      $this->internal_user = $this->getUser()->getGuardUser()
      ->{$this->internal_class};
    }
  }
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    /* for ($a = 1; $a < 15; $a++) {
     $user=new sfGuardUser();
    $user->username="proveedora".$a;
    $user->algorithm="sha1";
    $user->email_address="proveedora".$a."@gruposconsumo.net";
    $user->salt="cc67b6606d17c87a0a458897690937e4";
    $user->password="eefdfdf5001cebaf139e11aa4a90a02aede5289d";
    $user->setIsActive(true);
    $user->save();

    $profile=new sfGuardUserProfile();
    $profile->user_id=$user->getId();
    $profile->email=$user->email_address;
    $profile->internal_class_id=1;
    $profile->save();

    }**/

  }

  public function executeRegister(sfWebRequest $request)
  {

  }

  public function executeSearch(sfWebRequest $request)
  {
    $this->form = new ProviderProductForm();
  }

  public function executeList(sfWebRequest $request)
  {
    $this->product_id = $request
    ->getParameter("provider_product_product_id");
    /*
     * es el valor del mes actual, restado 1 porque en la base de datos seasson_start y
    * seasson_end vienen de un array que comienza con enero en 0.
    * Es para mostrar sólo los productores que además del producto, están en temporada,
    */
    $month = date("n") - 1;
    $this->providers = Doctrine::getTable("Provider")->createQuery("a")
    ->leftJoin("a.ProviderProduct s")
    ->where("s.product_id=?",
        $request->getParameter("provider_product_product_id"))
        ->andWhere("s.seasson_start <=?", $month)
        ->andWhere("s.seasson_end >=?", $month)->execute();
    /*
     * Hay que ordenar la lista según la distancia al usuario, para ello creo un nuevo array
    */
    $this->providers_sort = array();
    foreach ($this->providers as $i => $provider)
    {
      $this->providers_sort[] = array(
          $this->internal_user->getCityDistance($provider->City),
          $provider);
    }

    array_multisort($this->providers_sort);

    $this->list_providers = array();
    foreach ($this->providers_sort as $prov)
    {
      $this->list_providers[] = $prov[1];
    }

    $file = "js/openlayers/datos.txt";
    $fh = fopen($file, "w") or die("unable to open file");
    $row = "lat\t";
    $row .= "lon\t";
    $row .= "title\t";
    $row .= "description\t";
    $row .= "iconSize\t";
    $row .= "iconOffset\t";
    $row .= "icon\n";
    fwrite($fh, $row);
    foreach ($this->list_providers as $i => $provider)
    {
      $row = $provider->City->latitude . "\t";
      $row .= $provider->City->longitude + ($i * 0.001) . "\t";
      $row .= $provider->name . "\t";
      $row .= $provider->City->name . "\t";
      $row .= "32,37\t";
      $row .= "0,0\t";
      $row .= "/images/icons/consumer-green.png\t";
      $row .= "\n";
      fwrite($fh, $row);
    }
    fclose($fh);
  }

  /*
   * Muestra el perfil del proveedor a visitantes, grupos o consumidores
  */
  public function executeProfile(sfWebRequest $request)
  {
    if ($request->hasParameter("id"))
    {
      $this->provider = Doctrine::getTable("Provider")
      ->findOneById($request->getParameter("id"));
    }
    else if ($request->hasParameter("slug"))
    {
      $this->provider = Doctrine::getTable("Provider")
      ->createQuery("a")
      ->where("slug=?",$request->getParameter("slug"))
      ->fetchOne();
    }
    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N'));
    $this->getResponse()->setTitle(__("Proveedora/or para grupos de consumo: ").$this->provider->name);
  }

  public function executeUtilAdd(sfWebRequest $request)
  {
    $this->type = $request->getParameter("type");
    $this->form_name = $this->type . "Form";
    $this->form = new $this->form_name();
    $this->setTemplate($this->type . "Add", "consumer_group");
  }

  public function executeUtilEdit(sfWebRequest $request)
  {
    $this->type = $request->getParameter("type");
    $this->form_name = $this->type . "Form";
    $this->util = Doctrine::getTable(ucfirst($this->type))
    ->findOneById($request->getParameter("id"));
    $this->form = new $this->form_name($this->util);
    $this->setTemplate($this->type . "Add", "consumer_group");
  }

  public function executeUtilUpdate(sfWebRequest $request)
  {
    $this->type = $request->getParameter("type");
    $this->form_name = $this->type . "Form";
    $this->util = Doctrine::getTable(ucfirst($this->type))
    ->findOneById($request->getParameter("id"));
    $this->form = new $this->form_name($this->util);
    $this->processFormUtils($request, $this->form, $this->type);
    $this->setTemplate($this->type . "Add", "consumer_group");
  }

  public function executeUtilAdded(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->type = $request->getParameter("type");
    $this->form_name = $this->type . "Form";
    $this->form = new $this->form_name();

    $this->processFormUtils($request, $this->form, $this->type);
    $this->setTemplate($this->type . "Add", "consumer_group");
  }

  public function executeUtilDelete(sfWebRequest $request)
  {
    $this->type = $request->getParameter("type");
    $this->util = Doctrine::getTable(ucfirst($this->type))
    ->findOneById($request->getParameter("id"));
    if ($this->util->delete())
    {
      $this->getUser()
      ->setFlash('notice',
          'The ' . $this->type
          . ' have been succesfully deleted');
    } else
    {
      $this->getUser()
      ->setFlash('error',
          'There has been an error. Try again later');
    }
    $this->redirect('provider/util?type=' . $this->type);
  }

  protected function processFormUtils(sfWebRequest $request, sfForm $form,
      $type)
  {
    $form
    ->bind($request->getParameter($form->getName()),
        $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $record = $form->save();
      if ($form->isNew())
      {
        $this->getUser()
        ->setFlash('notice',
            'The ' . $type
            . " has been created succesfully");

      } else
      {
        $this->getUser()
        ->setFlash('notice',
            'El archivo se ha modificado correctamente.');
      }

      $this->redirect('provider/util?type=' . $type);
    } /*
    * Esto es para evitar un error que no entiendo, cuando se produce que el archivo es demasiado grande,
    * el formulario no carga los valores por defecto y no funciona. Así redirijo a la página inicial d
    * utilidades y listo.
    */
    else if (in_array(
        "The form submission cannot be processed. It probably means that you have uploaded a file that is too big.",
        $form->getGlobalErrors()))
    {
      $this->getUser()
      ->setFlash('error',
          'The form submission cannot be processed. It probably means that you have uploaded a file that is too big. Try again');
      $this->redirect('consumer_group/util?type=' . $type);
    }
  }

  public function executeUtil(sfWebRequest $request)
  {
    if ($request->hasParameter("provider_id"))
    {
      $this->provider=Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
      $user_id=$this->provider->user_id;
    }
    elseif ($request->hasParameter("slug"))
    {
      $this->provider=Doctrine::getTable("Provider")->findOneBySlug($request->getParameter("slug"));
      $user_id=$this->provider->user_id;
    }

    else {
      $this->provider=$this->getUser()->getGuardUser()->getInternalUser();
      $user_id=$this->getUser()->getGuardUser()->getId();
    }

    $this->type = $request->getParameter("type");
    $this->pager = new sfDoctrinePager(ucfirst($this->type),
        sfConfig::get('app_utils_list'));
    $query = Doctrine::getTable(ucfirst($this->type))->createQuery("a")
    ->whereIn("publish_state_id",$this->getUser()->getAllowPublishStates())
    ->andWhere("user_id=?",$user_id)
    ->andWhere('published=?',1);
    $query->orderBy("created_at DESC");
    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    $this->setTemplate("util", "consumer_group");
  }

  public function executeUtilShow(sfWebRequest $request)
  {
    $this->type = $request->getParameter("type");
    $this->util = Doctrine::getTable(ucfirst($this->type))
    ->findOneById($request->getParameter("id"));
    $this->setTemplate($this->type . "Show","consumer_group");
  }

  public function executeCatalogue(sfWebRequest $request)
  {
    if ($this->getUser()->getInternalClassName() == "Provider")
    {
      if ($request->hasParameter("provider_id"))
      {
        $this->provider = Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
      }
      elseif ($request->hasParameter("slug"))
      {
        $this->provider = Doctrine::getTable("Provider")->findOneBySlug($request->getParameter("slug"));
      }
      else
      {
        $this->provider = $this->getUser()->getInternalUser();
      }
    }
    else
    {
      if ($request->hasParameter("provider_id"))
      {
        $this->provider = Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
      }
      elseif ($request->hasParameter("slug"))
      {
        $this->provider = Doctrine::getTable("Provider")->findOneBySlug($request->getParameter("slug"));
      }
    }


    /*
     * productos destacados, ordenados por fecha de destaque y limitados a 8 por cuestiones de
    * maquetación
    */
    $this->highlight_provider_products = Doctrine::getTable("ProviderProduct")->createQuery()
    ->where("provider_id=?", $this->provider->id)
    ->andWhere("is_highlight=?", 1)
    ->andWhere("is_active=?", 1)
    //->andWhere("is_in_stock=?", 1)
    ->orderBy("highlight_date desc")
    ->limit(6)->execute();

    /*
     * últimos productos añadidos (novedades), sólo 4
    */
    $this->last_provider_products=Doctrine::getTable("ProviderProduct")->createQuery()
    ->where("provider_id=?", $this->provider->id)
    ->andWhere("is_active=?", 1)
    //->andWhere("is_in_stock=?", 1)
    ->orderBy("created_at desc")
    ->limit(3)->execute();

    if ($request->getParameter("buy_consumer_id"))
    {
      $this->buyConsumer = Doctrine::getTable("Consumer")
      ->findOneById($request->getParameter("buy_consumer_id"));

      $this->order = $this->buyConsumer
      ->getProviderOpenOrder($this->provider->id);

    }
    else if ($this->getUser()->hasCredential("consumer"))
    {
      $this->buyConsumer = $this->getUser()->getInternalUser();
      if ($this->buyConsumer->canBuyProduct($this->provider->id))
      {
        //devuelve un array
        $this->order = $this->buyConsumer
        ->getProviderOpenOrder($this->provider->id);

      }
    }
    /*
     * en el caso de que sea un proveedor que no está comprando para un consumidor (no hay buy_consumer_id)
     * Esto es para que la variable order quede definida 
    */
    else
    {
      $this->order=null;
    }

  }

  public function executePurchase(sfWebRequest $request)
  {
    if ($request->hasParameter("type"))
    {
      $this->type=$request->getParameter("type");
      $this->show_action="show_basket";
    }
    else
    {
      $this->type="";
      $this->show_action="show";
    }
    if ($this->getUser()->getInternalClassName() == "Provider")
    {
      if ($request->hasParameter("provider_id"))
      {
        $this->provider = Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
      }
      else
      {
        $this->provider = $this->getUser()->getInternalUser();
      }
    } else
    {
      $this->provider = Doctrine::getTable("Provider")
      ->findOneById($request->getParameter("provider_id"));
    }
    /*
     * si es un consumidor, se puede mirar si tiene una orden abierta
    * con el productor del catálogo
    */

    /*
     * Para pedidos, se enlaza el catálogo con el id de la orden de pedido

    else if ($request->getParameter("order_id"))
    {
    $this->order=Doctrine::getTable("Orders")->findOneById($request->getParameter("order_id"));
    }
    */
    if ($this->type=="basket")
    {
      $this->provider_products = Doctrine::getTable("ProviderProduct")
      ->createQuery()->where("provider_id=?", $this->provider->id)
      ->execute();
    }
    else
    {
      $this->category = Doctrine::getTable("ProductCategory")
      ->findOneById($request->getParameter("category_id"));
      $this->subcategory = Doctrine::getTable("ProductSubcategory")
      ->findOneById($request->getParameter("subcategory_id"));
      $this->provider_products = Doctrine::getTable("ProviderProduct")
      ->createQuery()->where("provider_id=?", $this->provider->id)
      ->andWhere("product_category_id=?", $this->category->id)
      ->andWhere("product_subcategory_id=?", $this->subcategory->id)
      ->andWhere("is_active=?", 1)->execute();
    }
    /*
     * Como es posible que el proveedor o el responsable añadan productos a otros consumidores
    * hay que definir qué usuario es el que está comprando
    */
    if ($request->getParameter("buy_consumer_id"))
    {

      $this->buyConsumer = Doctrine::getTable("Consumer")
      ->findOneById($request->getParameter("buy_consumer_id"));
    }
    else if ($this->getUser()->hasCredential("consumer"))
    {
      $this->buyConsumer = $this->getUser()->getInternalUser();

    }

    if (isset($this->buyConsumer)
        && $this->buyConsumer->canBuyProduct($this->provider->id))
    {
      //devuelve un array
      $this->order= $this->buyConsumer
      ->getProviderOpenOrder($this->provider->id);

       
    }

  }

  public function executeOrderaccept(sfWebRequest $request)
  {
    $this->order = Doctrine::getTable("Orders")
    ->findOneById($request->getParameter("order_id"));
    $this->order->setOrderStateId(4);
    $this->order->provider_accept_date = date("Y-m-d");
    $this->order->save();
    $this->getUser()
    ->setFlash('notice', 'El pedido ha sido aceptado correctamente');
    $this
    ->sendMail($this->order->Consumer->email,
        $this->internal_user->email,
        "El pedido " . $this->order->name
        . " ha sido aceptado por la/el proveedora/or "
        . $this->internal_user->name, "");
    $this->redirect("@orders_show?slug=".$this->order->slug);
  }

  public function executeOrderreject(sfWebRequest $request)
  {
    $this->order = Doctrine::getTable("Orders")
    ->findOneById($request->getParameter("order_id"));

  }
  public function executeOrderrejected(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->order = Doctrine::getTable("Orders")
    ->findOneById($request->getParameter("order_id"));
    $this->order->setOrderStateId(14);
    $this->order
    ->setRejectComment($request->getParameter("reject_comments"));
    $this->order->provider_reject_date = date("Y-m-d");
    $this->order->save();
    $this->getUser()
    ->setFlash('notice',
        'El pedido ' . $this->order->name
        . ' ha sido rechazado correctamente');
    $this
    ->sendMail($this->order->Consumer->email,
        $this->internal_user->email,
        "El pedido " . $this->order->name
        . " ha sido rechazado por la/el proveedora/or "
        . $this->internal_user->name,
        $request->getParameter("reject_comments"));
    $this->redirect("profile/data");
  }

  public function executeFinalizeorder(sfWebRequest $request)
  {
    $this->order = Doctrine::getTable("Orders")
    ->findOneById($request->getParameter("order_id"));
    $this->order->setOrderStateId(9);
    $this->order->provider_finalize_date = date("Y-m-d");
    $this->order->save();
    $this->getUser()
    ->setFlash('notice',
        'El pedido ha sido finalizado correctamente');
    $this
    ->sendMail($this->order->Consumer->email,
        $this->internal_user->email,
        "El pedido " . $this->order->name
        . " ha sido finalizado por la/el proveedora/or "
        . $this->internal_user->name, "");
    $this->redirect("@orders_show?slug=".$this->order->slug);
  }

  public function executeSendorder(sfWebRequest $request)
  {
    $this->order = Doctrine::getTable("Orders")
    ->findOneById($request->getParameter("order_id"));
    $this->order->setOrderStateId(10);
    $this->order->provider_send_to_group_date = date("Y-m-d");
    $this->order->save();
    $this->getUser()
    ->setFlash('notice',
        'El pedido ha sido modificado correctamente. El grupo de consumo recibirá el aviso.');
    $this
    ->sendMail($this->order->Consumer->email,
        $this->internal_user->email,
        "El pedido " . $this->order->name
        . " ha sido enviado por la/el proveedora/or "
        . $this->internal_user->name, "");
    $this->redirect("@orders_show?slug=".$this->order->slug);
  }

  public function sendMail($to, $from, $subject, $body, $consumer = null,
      $group = null)
  {
    $mensaje = Swift_Message::newInstance();
    $context = array('consumer' => $consumer, "group" => $group);
    $mensaje->setFrom($from);
    $mensaje->setTo($to);
    $mensaje->setSubject($subject);
    $mensaje->setBody($body);
    if ($consumer)
    {
      $mensaje
      ->setBody(
          $this
          ->getPartial('consumer_group/' . $body,
              $context), 'text/html');
    } /* elseif ($group)
    {
    $mensaje->setBody($this->getPartial('consumer_group/'.$body, $context), 'text/html');
    }*/
    else
    {
      $mensaje->setBody($body);
    }
    //$mensaje->setBody($this->getPartial('signin/mailHtmlBody', $context), 'text/html');
    //$mensaje->setBody($this->getPartial('consumer_group/'.$body, $context), 'text/plain');

    $this->getMailer()->send($mensaje);
  }

  /*
   * hace el cambio de las órdenes de pedido de cada consumidor para cada producto
  */
  public function executeModifyorder(sfWebRequest $request)
  {
    $this->amount = $request->getParameter("amount");
    $this->consumer_order = Doctrine::getTable("ConsumerOrder")
    ->findOneById($request->getParameter("id"));
    if ($request->getParameter("amount") != ''
        && $request->getParameter("amount") > 0)
    {
      if ($this->consumer_order->Orders->order_state_id == 4)
      {
        $this->consumer_order->Orders->order_state_id = 5;
        $this->consumer_order->Orders->save();
      }
      /*
       * Creamos una nueva orden para guardar el pedido original
      * en el caso de que no exista de antes
      */
      if (!$this->consumer_order->hasModifyOrder())
      {
        $new_consumer_order = new ConsumerOrder();
        $new_consumer_order->order_id = $this->consumer_order->order_id;
        $new_consumer_order->consumer_id = $this->consumer_order
        ->consumer_id;
        $new_consumer_order->product_id = $this->consumer_order
        ->product_id;
        $new_consumer_order->provider_id = $this->consumer_order
        ->provider_id;
        $new_consumer_order->provider_product_id = $this->consumer_order
        ->provider_product_id;
        $new_consumer_order->amount = $this->consumer_order->amount;
        $new_consumer_order->consumer_order_state_id = 2;
        $new_consumer_order->save();
      }
      /*
       * Modifico la original para que funcione más fácil el ajax, en lugar de dejarla como
      * está y crear otra.
      * Además, es más fácil comprobar que existe la modificada así.
      */
      $this->consumer_order->setAmount($request->getParameter("amount"));
      $this->consumer_order->save();
      $this
      ->sendMail($this->consumer_order->Consumer->email,
          $this->consumer_order->Provider->email,
          "Tu pedido dentro del pedido "
          . $this->consumer_order->Orders->name
          . " ha sido modificado por el proveedor",
          "");
    }

    $this->setTemplate("change_order_consumer", "consumer_group");

  }

  public function executeDeleteconsumerorder(sfWebRequest $request)
  {
    $this->consumer_order = Doctrine::getTable("ConsumerOrder")
    ->findOneById($request->getParameter("consumer_order_id"));
    /*
     * Si no existe orden de modificación, la que hay se pone en estado 3 y a correr
    */
    if (!$this->consumer_order->hasModifyOrder())
    {
      $this->consumer_order->setConsumerOrderStateId(3);
      $this->consumer_order->save();
    } /*
    * si existe orden de modificación, la modificada (estado 2) se pone
    * en estado 3 y la orden actual se borra.
    */
    else
    {
      $consumer_order_modify = $this->consumer_order->getModifyOrder();
      $consumer_order_modify->setConsumerOrderStateId(3);
      $consumer_order_modify->save();
      $this->consumer_order->delete();
    }
    $this->getUser()
    ->setFlash('notice', 'El producto se ha eliminado del pedido correctamente');
    $this->sendMail($this->consumer_order->Consumer->email,$this->consumer_order->Orders->Consumer->email,"Tu pedido dentro del pedido ".$this->consumer_order->Orders->name." ha sido modificado por el proveedor","");
    $this->redirect("@orders_show?slug=".$this->consumer_order->Orders->slug."&detail=1");
  }

  public function executeGobackorder(sfWebRequest $request)
  {
    $this->order = Doctrine::getTable("Orders")
    ->findOneById($request->getParameter("order_id"));
    /*
     * retorna el pedido al grupo
    */
    $this->order->setOrderStateId(6);
    $this->order->save();
    $this->getUser()
    ->setFlash('notice',
        'El pedido se ha enviado al grupo correctamente');
    $this
    ->sendMail($this->order->Consumer->email,
        $this->order->Provider->email,
        "El pedido " . $this->order->name
        . " ha sido modificado por el proveedor",
        "Debes revisarlo");
    $this->getUser()->setAttribute("last_state", 6);
    $this->redirect("@orders_show?slug=".$this->order->slug);
  }

  /*
   * listado de pedidos
  */
  public function executeOrders()
  {
    if ($this->getUser()->getInternalClassName() == "Provider")
    {
      $this->provider = $this->getUser()->getInternalUser();
    }
    $this->order_states = Doctrine::getTable("OrderState")->createQuery()
    ->orderBy("position asc")->execute();
  }

  public function executeAdmin()
  {

  }

  public function executeHighlight(sfWebRequest $request)
  {
    if ($request->hasParameter("id"))
    {
      $id=$request->getParameter("id");
    }
    else if ($request->hasParameter("provider_product_id"))
    {
      $id=$request->getParameter("provider_product_id");
    }

    $this->provider_product = Doctrine::getTable("ProviderProduct")
    ->findOneById($id);

    if ($this->provider_product->provider_product_type_id==2)
    {
      $name="La cesta";
    }
    elseif ($this->provider_product->provider_product_type_id==1)
    {
      $name="El producto";
    }
    if ($request->getParameter("type") == "remove")
    {
      $this->provider_product->is_highlight = 0;
      $this->getUser()
      ->setFlash('notice',
          $name.' se ha quitado de destacados correctamente');
    }
    else
    {
      $this->provider_product->is_highlight = 1;
      $this->provider_product->highlight_date=date("Y-m-d");
      $this->getUser()
      ->setFlash('notice',
          $name.' se ha destacado correctamente');
    }
    $this->provider_product->save();

    $this->redirect("@provider_product?provider_slug=".$this->provider_product->Provider->slug."&provider_product_slug=".$this->provider_product->slug);
  }
}
