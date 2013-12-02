<?php

/**
 * home actions.
 *
 * @package    grupos_consumo
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions
{

  public function preExecute()
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->profile=$this->getUser()->getGuardUser()->Profile;
      $this->internal_class=$this->profile->InternalClass->class;
      $this->internal_user=$this->getUser()->getGuardUser()->{$this->internal_class};
      if ( !$this->internal_user->id)
      {
        $this->redirect("register/complete");
      }
      /*
       * para los que se dan de alta como grupos de consumo
      */
      else
      {
        if ($this->getUser()->getGuardUser()->Profile->profile_group==1||$this->getUser()->getGuardUser()->Profile->profile_group==2)
        {
          $this->redirect("register/index");
        }
      }
    }
  }

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeNews(sfWebRequest $request)
  {
    $this->pager = new sfDoctrinePager('Home',
        sfConfig::get('app_news_in_home')
    );
    $this->pager->setQuery(Doctrine_core::getTable("Home")->createQuery("a")->where("object_class like 'News'")->orderBy("position asc"));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->form=new SearchProviderMapForm();
    $this->city=Doctrine::getTable("City")->createQuery("a")->leftJoin("a.Translation c")->where("c.name=?","Madrid")->fetchOne();
    $providers=Doctrine::getTable("Provider")->createQuery()->where("provider_state_id=1")->execute();
    $consumers=Doctrine::getTable("Consumer")->createQuery()->whereNotIn("consumer_state_id",array(5,2))->execute();
    $consumer_groups=Doctrine::getTable("ConsumerGroup")->findAll();
    $map_objects=Doctrine::getTable("MapObject")->findAll();
    $users=array($providers,$consumers,$consumer_groups);
    $this->file="js/openlayers/all_users.txt";
    $this->createData($this->file,$users);

    $this->form_search=new SearchMapForm();
    $this->form_search_consumer=new SearchConsumerMapForm();
  }

  public function executeList(sfWebRequest $request)
  {
    $this->product_id=$request->getParameter("provider_product_product_id");
    /*
     * es el valor del mes actual, restado 1 porque en la base de datos seasson_start y
    * seasson_end vienen de un array que comienza con enero en 0.
    * Es para mostrar sólo los productores que además del producto, están en temporada,
    */
    $month=date("n")-1;
    $this->providers=Doctrine::getTable("Provider")
    ->createQuery("a")
    ->leftJoin("a.ProviderProduct s")
    ->where("s.product_id=?",$request->getParameter("provider_product_product_id"))
    ->andWhere("s.seasson_start <=?",$month)
    ->andWhere("s.seasson_end >=?",$month)
    ->execute();
    /*
     * Hay que ordenar la lista según la distancia al usuario, para ello creo un nuevo array
    */
    /*$this->providers_sort=array();
     foreach($this->providers as $i=>$provider)
     {
    $this->providers_sort[]=array($this->internal_user->getCityDistance($provider->City),$provider);
    }

    array_multisort($this->providers_sort);

    $this->list_providers=array();
    foreach($this->providers_sort as $prov)
    {
    $this->list_providers[]=$prov[1];
    }*/
    $this->list_providers=array();
    foreach($this->providers as $prov)
    {
      $this->list_providers[]=$prov[1];
    }
     
    $file = "js/openlayers/datos.txt";
    $fh = fopen($file,"w") or die ("unable to open file");
    $row ="lat\t";
    $row.="lon\t";
    $row.="title\t";
    $row.="description\t";
    $row.="iconSize\t";
    $row.="iconOffset\t";
    $row.="icon\n";
    fwrite($fh,$row);
    foreach ($this->list_providers as $i=>$provider)
    {
      $row=$provider->City->latitude."\t";
      $row.=$provider->City->longitude+($i*0.001)."\t";
      $row.=$provider->name."\t";
      $row.=$provider->City->name."\t";
      $row.="32,37\t";
      $row.="0,0\t";
      $row.="/images/icons/consumer-green.png\t";
      $row.="\n";
      fwrite($fh,$row);
    }
    fclose($fh);
    $this->setTemplate("index");
  }


  /*
   * @file  Nombre del archivo, incluyendo en el nombre del archivo la ruta js/openlayers
  * @users tiene que ser un array de un doctrine_collection, no sirve un Doctrine_Collection, de objetos de las clases
  * Provider, Consumer o ConsumerGroup
  */
  private function createData($file,$users)
  {

    $fh = fopen($file,"w") or die ("unable to open file");
    $row ="lat\t";
    $row.="lon\t";
    $row.="title\t";
    $row.="description\t";
    $row.="iconSize\t";
    $row.="iconOffset\t";
    $row.="icon\n";
    fwrite($fh,$row);
    foreach ($users as $user_type){
      foreach ($user_type as $i=>$user)
      {
        $row=$user->City->latitude+(rand(0,3)*0.001)."\t";
        $row.=$user->City->longitude+(rand(0,3)*0.001)."\t";
        //desde aquí
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
        if ($user instanceof MapObject)
        {
          $row.=$user->name."(".__($user->MapObjectType->name).")\t";
        } else
        {
          $row.=$user->name."(".__($user->getClass()).")\t";
        }
        $row.=$user->City->name;
        sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
        sfContext::getInstance()->getConfiguration()->loadHelpers('Tag');
        if ($this->getUser()->isAuthenticated())
        {
          $row.="<br />";

          if ($user instanceof MapObject)
          {
            if ($user->contact)
            {
              $row.=link_to("Contactar","home/contact?id=".$user->id);
            }
          } else
          {
            if ($user->getClass()=='Provider')
            {
              $row.=link_to("Ver perfil","@provider_profile?slug=".$user->slug);
            }
            else
            {
              $row.=link_to("Ver perfil",sfInflector::underscore($user->getClass())."/profile?id=".$user->id);
            }
          }
        }
        //si no está registrado, se le invita a hacerlo
        elseif (!$user instanceof MapObject)
        {
          $row.="<br />".link_to("Regístrate para ver la información","@apply");
        }
        $row.="\t";
        //hasta aquí, lo que va dentro del popup
        $row.="32,37\t";
        $row.="-15,-37\t";//desplazamiento del icono para que la punta quede encima de la localidad.
        $row.="/images/icons/".strtolower($user->getClass()).".png\t";
        $row.="\n";
        fwrite($fh,$row);
      }
    }
    fclose($fh);
  }


  public function executeSearch(sfWebRequest $request)
  {
     
     
    $this->type=$request->getParameter("type");

    if ($this->getUser()->isAuthenticated())
    {
      $this->city=$this->getUser()->getInternalUser()->City;
    }
    else {
      $this->city=Doctrine::getTable("City")->createQuery("a")->leftJoin("a.Translation c")->where("c.name=?","Madrid")->fetchOne();
    }

    if ($request->getParameter("type")=="provider")
    {
      $this->form=new SearchProviderMapForm();
      $this->title="Búsqueda de proveedoras/es";
      $param=$request->getParameter("search_provider_map");
      $category_id=$param["product_category_id"];
      if (key_exists("product_category_id", $param))
      {
        $this->category_id=$category_id;
      }
      $subcategory_id=$param["product_subcategory_id"];
      $product_id=$param["product_id"];

      $query=Doctrine::getTable("ProviderProduct")->createQuery()
      ->where("product_category_id=?",$category_id);

      $this->search_param=array($category_id);
      if ($subcategory_id!='')
      {
        $query->andWhere("product_subcategory_id=?",$subcategory_id);
        $this->search_param[]=$subcategory_id;
      }
      if ($product_id!='')
      {
        $query->andWhere("product_id=?",$product_id);
        $this->search_param[]=$product_id;
      }
      $query->groupBy("provider_id");
      $result_query=$query->execute();
      $this->close_search=$param["close_search"];

      if ($param["close_search"]==0)
      {
        $this->result=array();
        foreach($result_query as $i=>$provider_product)
        {
          if ($provider_product->Provider->provider_state_id==1)
          {
            $this->result[]=$provider_product->Provider;
          }
        }

      } else {

        $state_id=$param["state_id"];
        $city_id=$param["city_id"];
        if ($param["length"]){
          $length=$param["length"];
        }
        else
        {
          $length=100;
        }

        $city=Doctrine::getTable("City")->findOneById($city_id);
        $this->search_param=array_merge(array($city->State->name,$city->name, $length),$this->search_param);

        $this->providers_sort=array();

        foreach($result_query as $i=>$providerproduct)
        {
          if ($i==0)
          {
            $this->search_param[]=$providerproduct;
          }
          if ($providerproduct->Provider->getCityDistance($city)<$length&&$providerproduct->Provider->provider_state_id==1)
          {
            $this->providers_sort[]=array($providerproduct->Provider->getCityDistance($city),$providerproduct->Provider);
          }
        }

        array_multisort($this->providers_sort);

        /*
         * ahora elimino la distancia del array para obtener sólo los proveedores.
        */
        $this->result=array();
        foreach($this->providers_sort as $prov)
        {
          $this->result[]=$prov[1];
        }

      }


    }
    elseif ($request->getParameter("type")=="consumer"||$request->getParameter("type")=="consumer_group")
    {
      if ($request->getParameter("type")=="consumer_group")
      {
        $this->form=new SearchMapForm();
        $this->title="Búsqueda de grupos de consumo";
      }
      elseif ($request->getParameter("type")=="consumer")
      {
        $this->form=new SearchConsumerMapForm();
        $this->title="Búsqueda de consumidoras/es individuales";
      }

      $param=$request->getParameter("search_".$this->type."_map");
      $state_id=$param["state_id"];
      $city_id=$param["city_id"];
      if ($param["length"]){
        $length=$param["length"];
      }
      else
      {
        $length=100;
      }
       
      /*
       * primero busco todos los consumidores de la aplicación
      */
      $query_init_type=Doctrine::getTable(sfInflector::camelize($this->type))->createQuery();
      if ($this->type=="consumer")
      {
        $query_init_type->where("consumer_state_id<>5");
      }

      $query_init=$query_init_type->execute();

      /*
       * creo un objeto de la clase city según el parámetro de búsqueda
      * para controlar la distancia
      */
      $city=Doctrine::getTable("City")->findOneById($city_id);
      $this->search_param=array($city->State->name,$city->name, $length);
      /*
       * Hay que ordenar la lista según la distancia al usuario, para ello creo un nuevo array
      * con la distancia como primer elemento del array y el consumidor como la segunda
      */
      $this->consumers_sort=array();

      foreach($query_init as $consumer)
      {

        if ($consumer->getCityDistance($city)<$length)
        {
          $this->consumers_sort[]=array($consumer->getCityDistance($city),$consumer);
        }
      }

      array_multisort($this->consumers_sort);

      /*
       * ahora elimino la distancia del array para obtener sólo los consumidores.
      */
      $this->result=array();
      foreach($this->consumers_sort as $prov)
      {
        $this->result[]=$prov[1];
      }

      $query=$this->result;

    }
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form->bind($request->getParameter($this->form->getName()));

    $this->file="js/openlayers/".$this->type.".txt";
    /*
     * envuelvo la variable $result en un array para que funcione
    * createData, ya que esta función está pensada para
    * recibir un array con distintos tipos de objetos
    * y en este caso se le pasa un sólo tipo de objeto,
    * pero hay que meterlo en un array
    */
    $this->createData($this->file,array($this->result));

  }
  /*
   * para gente sin registro que se quiere poner en contacto con grupoagrupo
  */
  public function executeGuestContact(sfWebRequest $request)
  {
    $this->form=new ContactGuestForm();
     
  }

  public function executeGuestContacted(sfWebRequest $request)
  {
    $this->form=new ContactGuestForm();
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid())
    {
      $this->sendMail(sfConfig::get("app_default_mailto"),$this->form->getValue("email"),$this->form->getValue("subject"),$this->form->getValue("body"));
      $this->getUser()->setFlash('notice', 'El contacto se ha realizado correctamente. En breve recibirás respuesta.');
      $this->redirect("@homepage");
    }
    $this->setTemplate("guestContact");
  }

  public function executeContact(sfWebRequest $request)
  {
    $this->map_object=Doctrine::getTable("MapObject")->findOneById($request->getParameter("id"));
    $this->form=new ContactSimpleForm();
     
  }


  public function executeContacted(sfWebRequest $request)
  {
    $this->map_object=Doctrine::getTable("MapObject")->findOneById($request->getParameter("id"));
    $this->form=new ContactSimpleForm();
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->processContactForm($request, $this->form,$this->type);
    $this->setTemplate("contact");
  }

  protected function processContactForm(sfWebRequest $request, sfForm $form,$type)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      $map_object=Doctrine::getTable("MapObject")->findOneById($this->form->getValue("id"));
      $to=$map_object->email;
      $from=$this->internal_user->email;
      $subject=$this->form->getValue("subject");
      $body=$this->form->getValue("body");
      $this->sendMail($to,$from,$subject,$body);
      $this->getUser()->setFlash('notice', 'Se ha enviado el correo electrónico a la/el '.$map_object->MapObjectType->name);
      $this->redirect("profile/data");
    }
  }

  public function sendMail($to,$from,$subject,$body){
    $mensaje = Swift_Message::newInstance();
    $mensaje->setFrom($from);
    $mensaje->setTo($to);
    $mensaje->setSubject($subject);
    $mensaje->setBody($body);
    $this->getMailer()->send($mensaje);
  }

  public function executeSitemap()
  {

  }
}