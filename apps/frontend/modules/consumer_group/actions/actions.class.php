<?php

/**
 * consumer_group actions.
 *
 * @package    grupos_consumo
 * @subpackage consumer_group
 * @author     info@diphda.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class consumer_groupActions extends sfActions
{

  public function preExecute()
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->profile=$this->getUser()->getGuardUser()->Profile;
      $this->internal_class=$this->profile->InternalClass->class;
      $this->internal_user=$this->getUser()->getGuardUser()->{$this->internal_class};
      if ( !$this->internal_user->id){
        $this->redirect("register/complete");
      }
      /*
       * para los que se dan de alta como grupos de consumo
      */
      else
      {
        //si aún no ha rellenado su perfil de consumidor
        if ($this->getUser()->getGuardUser()->Profile->profile_group==1)
        {
          $this->redirect("register/index");
        }
        //si ha rellenado su perfil de consumidor pero no el del grupo.
        // add y added son las acciones para crear el grupo, hay que quitarlas de la condición para que no se cree un bucle de redirecciones
        else if ($this->getUser()->getGuardUser()->Profile->profile_group==2&&sfContext::getInstance()->getActionName()!="add"&&sfContext::getInstance()->getActionName()!="added")
        {
          $this->redirect("consumer_group/add");
        }
      }
    }
  }

  public function executeAdd(sfWebRequest $request)
  {
    $this->form=new ConsumerGroupRegisterForm();
  }

  public function executeAdded(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new ConsumerGroupRegisterForm();
    $this->processForm($request, $this->form);
    $this->setTemplate("add");
  }

  public function executeModify(sfWebRequest $request)
  {
    $this->consumer_group = Doctrine::getTable("ConsumerGroup")->findOneById($request->getParameter("id"));
    $this->form = new ConsumerGroupRegisterForm($this->consumer_group);
    $this->setTemplate("add");
  }

  public function executeModified(sfWebRequest $request)
  {
    $this->consumer_group = Doctrine::getTable("ConsumerGroup")->findOneById($request->getParameter("id"));
    $this->form = new ConsumerGroupRegisterForm($this->consumer_group);
    $this->processForm($request, $this->form);
    $this->setTemplate("add");
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName()));
    if ($form->isValid()){
      $record = $form->save();
      if ($form->isNew())
      {
        if ($this->getUser()->getGuardUser()->getProfile()->profile_group==2)
        {
          $this->getUser()->getGuardUser()->getProfile()->profile_group=3;
          $this->getUser()->getGuardUser()->getProfile()->save();
        }

        $this->getUser()->setFlash('notice', 'El grupo de consumo se ha añadido correctamente.');

        /*
         * Actualiza el grupo de consumo del consumidor cuando crea un nuevo grupo
        * Sólo se puede crear un grupo de consumo si no perteneces a ninguno.
        */
        $this->internal_user->consumer_group_id=$form->getObject()->id;
        $this->internal_user->setConsumerGroupJoinDate(date("Y-m-d"));//se guarda la fecha de creación del grupo y de unirse este usuario al grupo.
        $this->internal_user->consumer_state_id=2;//al crear el grupo se entiende que está aceptado.

        $this->internal_user->save();

      } else
      {
        $this->getUser()->setFlash('notice', 'El grupo de consumo se ha modificado correctamente.');
      }

      //$this->redirect('consumer_group/show?id='.$form->getObject()->id);
      $this->redirect('consumer_group/admin');
    }
  }

  public function executeLeave(sfWebRequest $request)
  {
    if ($request->getParameter("consumer_id"))
    {
      $this->consumer=Doctrine::getTable("Consumer")->findOneById($request->getParameter("consumer_id"));
      $this->consumer->consumer_group_id=null;
      $this->consumer->consumer_state_id=1;
      $this->consumer->setConsumerGroupJoinDate(date("Y-m-d"));//se guarda la fecha de salir del grupo.
      $this->consumer->save();
      $this->getUser()->setFlash('notice', 'Se ha dado de baja a la/el usuaria/o '.$this->consumer->name." ".$this->consumer->surname);
    }
    else {
      $this->internal_user->consumer_group_id=null;
      $this->internal_user->consumer_state_id=1;
      $this->internal_user->setConsumerGroupJoinDate(date("Y-m-d"));//se guarda la fecha de salir del grupo.
      $this->internal_user->save();
      $this->getUser()->setFlash('notice', 'Te has dado de baja correctamente');
    }

    $this->redirect('profile/data');
  }

  public function executeLookfor(sfWebRequest $request)
  {
    $type=$request->getParameter("type");

    if ($type=="consumer")
    {
       
      $this->near_consumers=array();
      $this->consumers=Doctrine::getTable("Consumer")->createQuery()->where("consumer_group_id is null")->andWhere("id <>?",$this->internal_user->id)->execute();

      foreach ($this->consumers as $consumer)
      {
        if ($this->internal_user->isNear($consumer->getCity()))
        {
          $this->near_consumers[]=$consumer;
        }
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
      foreach ($this->near_consumers as $i=>$consumer)
      {
        $row=$consumer->City->latitude."\t";
        $row.=$consumer->City->longitude+($i*0.001)."\t";
        $row.=$consumer->name."\t";
        $row.=$consumer->City->name."\t";
        $row.="32,37\t";
        $row.="0,0\t";
        $row.="/images/icons/consumer-green.png\t";
        $row.="\n";
        fwrite($fh,$row);
      }
      fclose($fh);

    }
    else if ($type=="group")//busca grupos de consumo
    {
      $this->near_groups=array();
      $this->groups=Doctrine::getTable("ConsumerGroup")->createQuery()->execute();
      foreach ($this->groups as $group)
      {
        if ($this->internal_user->isNear($group->getCity()))
        {
          $this->near_groups[]=$group;
        }
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
      foreach ($this->near_groups as $i=>$group)
      {
        $row=$group->City->latitude."\t";
        $row.=$group->City->longitude+($i*0.001)."\t";
        $row.=$group->name."\t";
        $row.=$group->City->name."\t";
        $row.="32,37\t";
        $row.="0,0\t";
        $row.="/images/icons/group-2-red.png\t";
        $row.="\n";
        fwrite($fh,$row);
      }
      fclose($fh);
      $this->setTemplate("lookforGroup");
    }

    else if ($type=="consumers_by_group")//el grupo de consumo busca consumidores cercanos.
    {
      $this->near_consumers=array();
      $this->consumer_group=Doctrine::getTable("ConsumerGroup")->findOneById($this->getUser()->getInternalUser()->ConsumerGroup->id);
      $this->consumers=Doctrine::getTable("Consumer")->createQuery()->where("consumer_group_id is null")->execute();

      foreach ($this->consumers as $consumer)
      {
        if ($this->consumer_group->isNear($consumer->getCity()))
        {
          $this->near_consumers[]=$consumer;
        }
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
      foreach ($this->near_consumers as $i=>$consumer)
      {
        $row=$consumer->City->latitude."\t";
        $row.=$consumer->City->longitude+($i*0.001)."\t";
        $row.=$consumer->name."\t";
        $row.=$consumer->City->name."\t";
        $row.="32,37\t";
        $row.="0,0\t";
        $row.="/images/icons/consumer-green.png\t";
        $row.="\n";
        fwrite($fh,$row);
      }
      fclose($fh);
    }
  }

  public function executeContact(sfWebRequest $request)
  {
    $this->type=$request->getParameter("type");
    $this->form=new ContactSimpleForm();
  }


  public function executeContacted(sfWebRequest $request)
  {
    $this->type=$request->getParameter("type");
    $this->form=new ContactSimpleForm();
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->processContactForm($request, $this->form,$this->type);
    $this->setTemplate("contact");
  }

  protected function processContactForm(sfWebRequest $request, sfForm $form,$type)
  {
    //$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      if ($type=="group")
      {
        $group=Doctrine::getTable("ConsumerGroup")->findOneById($this->form->getValue("id"));
        $to=array($group->Consumer->email);
        $from=$this->internal_user->email;
        $subject=$this->form->getValue("subject");
        $body=$this->form->getValue("body");
        $this->sendMail($to,$from,$subject,$body);
        $this->getUser()->setFlash('notice', 'Se ha enviado el correo electrónico a la/el responsable del grupo de consumo '.$group->name);
        $this->redirect("profile/data");
      }
      else if ($type=="member")
      {
        $consumer=Doctrine::getTable("Consumer")->findOneById($this->form->getValue("id"));
        $to=array($consumer->email);
        $from=$this->internal_user->email;
        $subject=$this->form->getValue("subject");
        $body=$this->form->getValue("body");
        $this->sendMail($to,$from,$subject,$body);
        $this->getUser()->setFlash('notice', 'Se ha enviado el correo electrónico a la/el consumidora/or '.$consumer->name." ".$consumer->surname);
        $this->redirect("profile/data");
      }

      else if ($type=="provider")
      {
        $provider=Doctrine::getTable("Provider")->findOneById($this->form->getValue("id"));
        $to=array($provider->email);
        $from=$this->internal_user->email;
        $subject=$this->form->getValue("subject");
        $body=$this->form->getValue("body");
        $this->sendMail($to,$from,$subject,$body);
        $this->getUser()->setFlash('notice', 'Se ha enviado el correo electrónico a la/el proveedora/or '.$provider->name);
        $this->redirect("profile/data");
      }

      else if ($type=="all")
      {
        $group=Doctrine::getTable("ConsumerGroup")->findOneById($this->form->getValue("id"));
        $to=array();
        foreach ($group->ConsumerList as $consumer)
        {
          $to[]=$consumer->email;
        }
        $from=$this->internal_user->email;
        $subject=$this->form->getValue("subject");
        $body=$this->form->getValue("body");
        $this->sendMail($to,$from,$subject,$body);
        $this->getUser()->setFlash('notice', 'Se ha enviado el correo electrónico a todo el grupo');
        //$this->redirect("profile/data");
      }


    }
  }


  /* public function sendMail($to,$from,$subject,$body,$consumer=null,$group=null){
   $mensaje = Swift_Message::newInstance();
  $context = array('consumer' => $consumer, "group"=>$group);
  $mensaje->setFrom($from);
  $mensaje->setTo($to);
  $mensaje->setSubject($subject);
  $mensaje->setBody($body);
  if ($consumer)
  {
  $mensaje->setBody($this->getPartial('consumer_group/'.$body, $context), 'text/html');
  }
  else {
  $mensaje->setBody($body);
  }

  $this->getMailer()->send($mensaje);
  }*/

  public function sendMail($to, $from, $subject, $body, array $params = NULL)
  {
    $mensaje = Swift_Message::newInstance();
    $mensaje->setFrom($from);
    $mensaje->setTo($to);
    $mensaje->setSubject($subject);

    if ($params)
    {
      $context = array();
      foreach ($params as $param)
      {
        $context[sfInflector::underscore(get_class($param))] = $param;
      }

      $mensaje->setBody($this->getPartial('consumer_group/' . $body, $context),'text/html');
    }
    else
    {
      $mensaje->setBody($body);
    }

    $this->getMailer()->send($mensaje);
  }

  public function executeJoinrequest(sfWebRequest $request)
  {
    $this->group=Doctrine::getTable("ConsumerGroup")->findOneById($request->getParameter("id"));
    if ($request->getParameter("repeat")){
      $subject="Has recibido un recordatorio de petición de incorporación";
    } else {
      $subject="Has recibido una petición de incorporación al grupo de consumo";
    }

    $this->sendMail($this->group->Consumer->email,$this->internal_user->email,
        $subject,"joinrequest",array($this->internal_user,$this->group));
    $this->internal_user->consumer_group_id=$this->group->id;
    $this->internal_user->consumer_state_id=4;
    $this->internal_user->save();
    $this->getUser()->setFlash('notice', 'Se ha enviado la petición a la/el responsable del grupo. En breve se pondrán en contacto contigo');
    $this->redirect("profile/data");
  }

  public function executeDeleterequest()
  {
    $this->internal_user->consumer_group_id=null;
    $this->internal_user->setConsumerStateId(1);
    $this->internal_user->save();
    $this->getUser()->setFlash('notice', 'Se ha anulado la petición de participación en el grupo de consumo');
    $this->redirect("profile/data");
  }

  public function executePendingrequest(sfWebRequest $request)
  {
    $this->members=Doctrine::getTable("Consumer")->createQuery()->where("consumer_group_id=?",$request->getParameter("id"))->andWhere("consumer_state_id=4")->execute();
  }

  public function executeProcessjoinrequest(sfWebRequest $request)
  {
    $this->consumer=Doctrine::getTable("Consumer")->findOneById($request->getParameter("consumer_id"));
    if ($request->getParameter("process")=="validate")
    {
      $this->consumer->setConsumerStateId(2);
      $this->consumer->setConsumerGroupJoinDate(date("Y-m-d"));
      $this->consumer->save();
      $this->sendMail($this->consumer->email,$this->internal_user->email,
          "Su petición de incorporación al grupo de consumo ha sido aceptada","accepted",array($this->consumer,$this->internal_user->ConsumerGroup));
      $this->getUser()->setFlash('notice', 'Se ha aceptado la petición');
      if ($this->internal_user->ConsumerGroup->hasJoinRequestPending()){
        $this->redirect("consumer_group/pendingrequest?id=".$this->internal_user->ConsumerGroup->id);
      } else {
        $this->getUser()->setFlash('notice', 'Se ha aceptado la petición. No hay más peticiones pendientes');
        $this->redirect("profile/data");
      }

    } else if ($request->getParameter("process")=="reject")
    {
      $this->consumer->setConsumerGroupId(null);
      $this->consumer->setConsumerStateId(1);
      $this->consumer->save();
      $this->sendMail($this->consumer->email,$this->internal_user->email,
          "Su petición de incorporación al grupo de consumo ha sido rechazada","rejected",array($this->consumer,$this->internal_user->ConsumerGroup));
      $this->getUser()->setFlash('notice', 'Se ha rechazado la petición');

      if ($this->internal_user->ConsumerGroup->hasJoinRequestPending()){
        $this->redirect("consumer_group/pendingrequest?id=".$this->internal_user->ConsumerGroup->id);
      } else {
        $this->getUser()->setFlash('notice', 'Se ha rechazado la petición. No hay más peticiones pendientes');
        $this->redirect("profile/data");
      }
    }
  }

  public function executeChangetrust(sfWebRequest $request)
  {
    $this->members=Doctrine::getTable("Consumer")->createQuery()
    ->where("consumer_group_id=?",$request->getParameter("id"))
    ->andWhere("consumer_state_id=2")
    ->andWhere("id <> ?",$this->internal_user->ConsumerGroup->consumer_trust_id)
    ->execute();
  }

  public function executeChangedtrust(sfWebRequest $request)
  {
    $this->group=Doctrine::getTable("ConsumerGroup")->findOneById($request->getParameter("group_id"));
    $this->consumer=Doctrine::getTable("Consumer")->findOneById($request->getParameter("consumer_id"));
    $this->group->consumer_trust_id=$request->getParameter("consumer_id");
    $this->group->save();
    $this->getUser()->setFlash('notice', 'Se ha actualizado la persona responsable del grupo. Ahora es '.$this->consumer->name." ".$this->consumer->surname);
    $this->redirect("profile/data");
  }

  public function executeReviewmembers(sfWebRequest $request)
  {
    $this->members=Doctrine::getTable("Consumer")->createQuery()
    ->where("consumer_group_id=?",$request->getParameter("id"))
    ->andWhere("consumer_state_id=2")->execute();
  }

  public function executeForum()
  {
    $this->redirect("sfSimpleForum/forumGroup");
  }

  public function executeUtil(sfWebRequest $request)
  {
    $this->type=$request->getParameter("type");
    $this->consumer_group_only=$request->getParameter("consumer_group_only");

    $this->pager = new sfDoctrinePager(ucfirst($this->type),
        sfConfig::get('app_utils_list')
    );
    $query=Doctrine::getTable(ucfirst($this->type))
    ->createQuery("a");
    if ($this->consumer_group_only)
    {
      $query->whereIn("publish_state_id",7)->andWhere("consumer_group_id=?",$this->internal_user->ConsumerGroup->id)->andWhere('published=?',1);
    }
    else
    {
      $query->whereIn("publish_state_id",$this->getUser()->getAllowPublishStates())->andWhere('published=?',1);
    }
    $query->orderBy("created_at DESC");
    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();

  }

  public function executeUtilShow(sfWebRequest $request)
  {
    $this->type=$request->getParameter("type");
    $this->util=Doctrine::getTable(ucfirst($this->type))
    ->createQuery("a")
    ->leftJoin("a.Translation t")
    ->where("t.slug=?",$request->getParameter("slug"))
    ->fetchOne();
    $this->setTemplate($this->type."Show");
    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N'));
    $this->getResponse()->setTitle(__("Grupos de consumo. ").$this->util->name);
  }

  public function executeUtilList(sfWebRequest $request)
  {

  }

  public function executeUtilAdd(sfWebRequest $request)
  {
    $this->type=$request->getParameter("type");
    $this->form_name=$this->type."ConsumerGroupForm";
    $this->form=new $this->form_name();
    $this->setTemplate($this->type."Add");
  }

  public function executeUtilEdit(sfWebRequest $request)
  {
    $this->type=$request->getParameter("type");
    $this->form_name=$this->type."ConsumerGroupForm";
    $this->util=Doctrine::getTable(ucfirst($this->type))->findOneById($request->getParameter("id"));
    $this->form=new $this->form_name($this->util);
    $this->setTemplate($this->type."Add");
  }

  public function executeUtilUpdate(sfWebRequest $request)
  {
    $this->type=$request->getParameter("type");
    $this->form_name=$this->type."ConsumerGroupForm";
    $this->util=Doctrine::getTable(ucfirst($this->type))->findOneById($request->getParameter("id"));
    $this->form=new $this->form_name($this->util);
    $this->processFormUtils($request, $this->form,$this->type);
    $this->setTemplate($this->type."Add");
  }

  public function executeUtilAdded(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->type=$request->getParameter("type");
    $this->form_name=$this->type."ConsumerGroupForm";
    $this->form=new $this->form_name();

    $this->processFormUtils($request, $this->form,$this->type);
    $this->setTemplate($this->type."Add");
  }


   
  public function executeUtilDelete(sfWebRequest $request)
  {
    $this->type=$request->getParameter("type");
    $this->util=Doctrine::getTable(ucfirst($this->type))->findOneById($request->getParameter("id"));
    if ($this->util->delete())
    {
      $this->getUser()->setFlash('notice', 'The '.$this->type.' have been succesfully deleted');
    }
    else {
      $this->getUser()->setFlash('error', 'There has been an error. Try again later');
    }
    $this->redirect('consumer_group/util?type='.$this->type);
  }

  protected function processFormUtils(sfWebRequest $request, sfForm $form,$type)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()){
      $record = $form->save();
      if ($form->isNew())
      {
        $this->getUser()->setFlash('notice', 'The '.$type." has been created succesfully");

      } else
      {
        $this->getUser()->setFlash('notice', 'El archivo se ha modificado correctamente.');
      }

      $this->redirect('@util_show_'.$type.'?slug='.$record->slug);
    }
    /*
     * Esto es para evitar un error que no entiendo, cuando se produce que el archivo es demasiado grande,
    * el formulario no carga los valores por defecto y no funciona. Así redirijo a la página inicial d
    * utilidades y listo.
    */
    else if (in_array("The form submission cannot be processed. It probably means that you have uploaded a file that is too big.",$form->getGlobalErrors()))
    {
      $this->getUser()->setFlash('error', 'The form submission cannot be processed. It probably means that you have uploaded a file that is too big. Try again');
      $this->redirect('consumer_group/util?type='.$type);
    }
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->consumer_group=Doctrine::getTable("ConsumerGroup")->findOneById($request->getParameter("id"));
  }

  public function executeAcept(sfWebRequest $request)
  {
    $this->form=new AceptedProviderConsumerGroupForm();
    $this->provider=Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
  }

  public function executeAcepted(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new AceptedProviderConsumerGroupForm();
    $this->processFormAcept($request, $this->form);
    $this->setTemplate("acept");
  }

  public function executeChangetrustprovider(sfWebRequest $request)
  {
    $this->aceptedProvider=Doctrine::getTable("AceptedProviderConsumerGroup")->createQuery()
    ->where("provider_id=?",$request->getParameter("provider_id"))
    ->andWhere("consumer_group_id=?",$request->getParameter("consumer_group_id"))
    ->fetchOne();
    $this->form=new AceptedProviderConsumerGroupForm($this->aceptedProvider);
    $this->setTemplate("acept");
  }


  public function executeChangedtrustprovider(sfWebRequest $request)
  {
    $this->aceptedProvider=Doctrine::getTable("AceptedProviderConsumerGroup")->findOneById($request->getParameter("id"));
    $this->form=new AceptedProviderConsumerGroupForm($this->aceptedProvider);
    $this->processFormAcept($request, $this->form);
    $this->setTemplate("acept");
  }

  public function executeReject(sfWebRequest $request)
  {
     
    $this->acepted_provider=Doctrine::getTable("AceptedProviderConsumerGroup")->createQuery()
    ->where("provider_id=?",$request->getParameter("provider_id"))
    ->andWhere("consumer_group_id=?",$request->getParameter("consumer_group_id"))
    ->fetchOne();
    $this->acepted_provider->acepted_provider_state_id=2;//rechazada/o
    $this->acepted_provider->save();
    $this->redirect("provider/profile?id=".$request->getParameter("provider_id"));
  }

  /*
   * volver a aceptar
  */
  public function executeReacept(sfWebRequest $request)
  {
     
    $this->acepted_provider=Doctrine::getTable("AceptedProviderConsumerGroup")->createQuery()
    ->where("provider_id=?",$request->getParameter("provider_id"))
    ->andWhere("consumer_group_id=?",$request->getParameter("consumer_group_id"))
    ->fetchOne();
    $this->acepted_provider->acepted_provider_state_id=1;//rechazada/o
    $this->acepted_provider->save();
    $this->redirect("provider/profile?id=".$request->getParameter("provider_id"));
  }

  protected function processFormAcept(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()){
      $record = $form->save();
      if ($form->isNew())
      {
        $this->getUser()->setFlash('notice', 'El proveedor ha sido aceptado correctamente');
      }
      else {
        $this->getUser()->setFlash('notice', 'El proveedor ha sido actualizado correctamente');
      }

      /*
       * envío de emails a las consumidoras del grupo
      */
      $provider=Doctrine::getTable("Provider")->findOneById($record->provider_id);

      $body=$this->getPartial('consumer_group/sendMailAceptProvider',array("provider"=>$provider));
      $this->sendMail($this->getUser()->getInternalUser()->getAllEmailsConsumers(),$this->getUser()->getInternalUser()->email,"Se ha aceptado una/un nueva/o proveedora/or",$body);

      /*
       * mail para el responsable del proveedor
      */
      $consumer_trust=Doctrine::getTable("Consumer")->findOneById($record->provider_consumer_trust_id);
      $body_trust=$this->getPartial('consumer_group/sendMailAceptProviderTrust',array("provider"=>$provider));
      $this->sendMail($consumer_trust->email,$this->getUser()->getInternalUser()->email,"Eres la/el responsable de una/un nueva/o proveedora/or",$body_trust);

      $this->redirect('provider/profile?id='.$record->provider_id);
    }
  }

  public function executeOrder(sfWebRequest $request)
  {

    $this->provider=Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
    $this->form=new OrdersForm(array(),array("provider"=>$this->provider));
  }

  public function executeOrdered(sfWebRequest $request)
  {
    $this->provider=Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
    $this->form=new OrdersForm(array(),array("provider"=>$this->provider));
    $this->forward404Unless($request->isMethod('post'));
    $this->processFormOrder($request, $this->form);
    $this->setTemplate("order");
  }

  protected function processFormOrder(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()){
      $record = $form->save();
      /*
       * si al crear el pedido, la fecha de apertura es posterior al día de hoy
      * se pone con estado 13-pendiente.
      * Al crear un pedido, por defecto se crea como abierto
      */
      if ($form->getObject()->date_in>date("Y-m-d"))
      {
        $form->getObject()->order_state_id=13;
        $form->getObject()->save();
      }

      if ($form->isNew())
      {
        $this->getUser()->setFlash('notice', 'El pedido se ha abierto correctamente');

        /*
         * Manda correos a los consumidores del grupo
        */
        $provider=Doctrine::getTable("Provider")->findOneById($record->provider_id);
        $consumer_trust=Doctrine::getTable("Consumer")->findOneById($record->consumer_id);
        $body=$this->getPartial('consumer_group/sendMailNewOrder',array("provider"=>$provider,"order"=>$record));
        $this->sendMail($this->getUser()->getInternalUser()->getAllEmailsConsumers(),$consumer_trust->email,
            "Se ha abierto un pedido para la/el ".$provider->ProviderType->name." ".$provider->name,$body);

        /*
         * manda correo al proveedor
        */
        $body_provider=$this->getPartial('consumer_group/sendMailNewOrderProvider',array("provider"=>$provider,"order"=>$record));
        $this->sendMail($provider->email,$consumer_trust->email,
            "El grupo de consumo ".$consumer_trust->ConsumerGroup->name." acaba de abrir un pedido",$body_provider);
      }
      else {
        $this->getUser()->setFlash('notice', 'El pedido se ha modificado correctamente');
      }
      $this->redirect('consumer_group/orderlist');
    }
  }

  public function executeOpenorder(sfWebRequest $request)
  {
    $this->order=Doctrine::getTable("Orders")->findOneById($request->getParameter("id"));
    $this->provider=Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
    $this->form=new OpenOrderForm($this->order,array("provider"=>$this->provider));
    $this->setTemplate("order");
  }

  public function executeUpdateorder(sfWebRequest $request)
  {
    $this->order=Doctrine::getTable("Orders")->findOneById($request->getParameter("id"));
    $this->provider=Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
    $this->form=new OpenOrderForm($this->order,array("provider"=>$this->provider));
    $this->processFormOrder($request, $this->form);
    $this->setTemplate("order");
  }


  public function executeExtendorder(sfWebRequest $request)
  {
    $this->order=Doctrine::getTable("Orders")->findOneById($request->getParameter("id"));
    $this->provider=Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
    $this->form=new ExtendsOrderForm($this->order,array("provider"=>$this->provider));
    $this->setTemplate("extendorder");
  }

  public function executeExtended(sfWebRequest $request)
  {
    $this->order=Doctrine::getTable("Orders")->findOneById($request->getParameter("id"));
    $this->provider=Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
    $this->form=new ExtendsOrderForm($this->order,array("provider"=>$this->provider));
    $this->processExtendsFormOrder($request, $this->form);
    /*
     * Cómo sólo se puede ampliar si está abierto o cerrado,
    * lo pongo en estado abierto y listo si está cerrado.
    */
    if ($this->form->getObject()->getOrderStateId()==2)
    {
      $this->form->getObject()->setOrderStateId(1);
      $this->form->getObject()->save();
    }

    $this->setTemplate("extendorder");
  }


  protected function processExtendsFormOrder(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $record = $form->save();
      /*
       * si al cambiar las fechas, el pedido pendiente tiene fecha de apertura el día de hoy o antes
      * se pasa a estado 1-Abierto.
      */
      if($form->getObject()->date_in<=date("Y-m-d")&&$form->getObject()->order_state_id==13)
      {
        $form->getObject()->order_state_id=1;
        $form->getObject()->save();
      }
      if ($record->getOrderStateId()==2)
      {
        if ($record->date_out>date("Y-m-d"))
        {
          $record->setOrderStateId(1);
          $record->save();
        }

      }
      $provider=Doctrine::getTable("Provider")->findOneById($record->provider_id);
      $body=$this->getPartial('consumer_group/sendMailExtendOrder',array("provider"=>$provider,"order"=>$record));
      $consumer_trust=Doctrine::getTable("Consumer")->findOneById($record->consumer_id);
      $this->sendMail($this->getUser()->getInternalUser()->getAllEmailsConsumers(),$consumer_trust->email,
          "Se ha modificado la fecha de cierre del pedido ".$record->name,$body);
      $this->getUser()->setFlash('notice', 'El pedido se ha modificado correctamente');
      $this->redirect('consumer_group/orderlist');
    }
  }

  public function executeOrderlist(sfWebRequest $request)
  {
    $this->order_states=Doctrine::getTable("OrderState")->createQuery()->orderBy("position asc")->execute();
  }

  public function executeStateorder(sfWebRequest $request)
  {
    $this->order=Doctrine::getTable("Orders")->findOneById($request->getParameter("order_id"));
    $this->provider=Doctrine::getTable("Provider")->findOneById($this->order->provider_id);
    $this->order->order_state_id=$request->getParameter("state_id");
    if ($request->getParameter("state_id")==2)
    {
      $this->order->date_out=date("Y-m-d");
      $this->order->group_close_date=date("Y-m-d");
    }
    elseif ($request->getParameter("state_id")==3)
    {
      $this->order->group_send_to_provider_date=date("Y-m-d");
      $body=$this->getPartial('consumer_group/confirmOrder',array("provider"=>$this->provider,"order"=>$this->order));

      $this->sendMail($this->provider->email,$this->order->Consumer->email,
          "Has recibido un pedido del grupo de consumo ".$this->order->Consumer->ConsumerGroup->name,$body);
      /*
       * enviar correo a los que hayan hecho el pedido y al administrador
      * con su pedido y el importe total de todo el grupo
      */
      $body_all_consumers=$this->getPartial('consumer_group/confirmOrderAllConsumers',array("provider"=>$this->provider,"order"=>$this->order));
      $this->sendMail($this->order->getAllConsumerOrder(),$this->order->Consumer->email,"Se ha confirmado el pedido ".$this->order->name,$body_all_consumers);
    }
    else if ($request->getParameter("state_id")==4)
    {
      $this->order->provider_accept_date=date("Y-m-d");
      if ($this->provider->segregated_orders)
      {
        $body=$this->getPartial('consumer_group/confirmOrderSegregated',array("provider"=>$this->provider,"order"=>$this->order));
      }
      else {
        $body=$this->getPartial('consumer_group/confirmOrderNoSegregated',array("provider"=>$this->provider,"order"=>$this->order));
      }

      $this->sendMail($this->provider->email,$this->order->Consumer->email,
          "Has recibido un pedido del grupo de consumo ".$this->order->Consumer->ConsumerGroup->name,$body);
      /*
       * enviar correo a los que hayan hecho el pedido y al administrador
      * con su pedido y el importe total de todo el grupo
      */
      $body_all_consumers=$this->getPartial('consumer_group/confirmOrderAllConsumers',array("provider"=>$this->provider,"order"=>$this->order));
      $this->sendMail($this->order->getAllConsumerOrder(),$this->order->Consumer->email,"Se ha confirmado el pedido ".$this->order->name,$body_all_consumers);
    }

    else if ($request->getParameter("state_id")==11)
    {
      /*
       * body provisional;
      */
      $body="";
      $this->order->group_receive_date=date("Y-m-d");
      $this->sendMail($this->provider->email,$this->order->Consumer->email,
          "El grupo de consumo ".$this->order->Consumer->ConsumerGroup->name." ha recibido el pedido ".$this->order->name,$body);
    }

    $this->getUser()->setFlash('notice', 'El pedido se ha actualizado correctamente');
    $this->order->save();

    $this->redirect("@orders_show?slug=".$this->order->slug);
  }

  /*
   * hace el cambio de las órdenes de pedido de cada consumidor para cada producto
  */
  public function executeChange_order_consumer(sfWebRequest $request)
  {
    $this->amount=$request->getParameter("amount");
    $this->consumer_order=Doctrine::getTable("ConsumerOrder")->findOneById($request->getParameter("id"));
    if ($request->getParameter("amount")!=''&&$request->getParameter("amount")>0)
    {
      /*
       * si los cambios se hacen cuando el pedido está en estado 6, es
      * decir, que el productor lo ha modificado y retornado al grupo
      * el estado pasa a ser 7 (en modificación por el grupo) para que cuando termine de hacer
      * los cambios, lo valide, y le llegue al productor que tendrá
      * que revisarlo y terminarlo o modificarlo de nuevo.
      */
      if ($this->consumer_order->Orders->order_state_id==6)
      {
        $this->consumer_order->Orders->order_state_id=7;
        $this->consumer_order->Orders->save();
      }

      /*
       * en estados 6 y 7 las modificaciones qeu haga el responsable, deben guardarse para
      * futuras comparaciones
      */
      if (in_array($this->consumer_order->Orders->order_state_id,array(6,7)))
      {
        if (!$this->consumer_order->hasModifyOrder())
        {
          $new_consumer_order=new ConsumerOrder();
          $new_consumer_order->order_id=$this->consumer_order->order_id;
          $new_consumer_order->consumer_id=$this->consumer_order->consumer_id;
          $new_consumer_order->product_id=$this->consumer_order->product_id;
          $new_consumer_order->provider_id=$this->consumer_order->provider_id;
          $new_consumer_order->provider_product_id=$this->consumer_order->provider_product_id;
          $new_consumer_order->amount=$this->consumer_order->amount;
          $new_consumer_order->consumer_order_state_id=2;
          $new_consumer_order->save();
        }
      }

      $this->consumer_order->setAmount($request->getParameter("amount"));
      $this->consumer_order->save();
      $this->sendMail($this->consumer_order->Consumer->email,$this->consumer_order->Orders->Consumer->email,"Tu pedido dentro del pedido ".$this->consumer_order->Orders->name." ha sido modificado","");
    }

  }


  public function executeDeleteconsumerorder(sfWebRequest $request)
  {
    $this->consumer_order=Doctrine::getTable("ConsumerOrder")->findOneById($request->getParameter("consumer_order_id"));
    /*
     * Si no existe orden de modificación, la que hay se pone en estado 3 y a correr
    */
    if (!$this->consumer_order->hasModifyOrder()){
      $this->consumer_order->setConsumerOrderStateId(3);
      $this->consumer_order->save();
    }
    /*
     * si existe orden de modificación, la modificada (estado 2) se pone
    * en estado 3 y la orden actual se borra.
    */
    else {
      $consumer_order_modify=$this->consumer_order->getModifyOrder();
      $consumer_order_modify->setConsumerOrderStateId(3);
      $consumer_order_modify->save();
      $this->consumer_order->delete();
    }

    if ($this->consumer_order->Orders->order_state_id==6)
    {
      $this->consumer_order->Orders->order_state_id=7;
      $this->consumer_order->Orders->save();
    }
     
    $this->sendMail($this->consumer_order->Consumer->email,$this->consumer_order->Orders->Consumer->email,"Tu pedido dentro del pedido ".$this->consumer_order->Orders->name." ha sido modificado","");
    $this->getUser()
    ->setFlash('notice', 'El producto se ha eliminado del pedido correctamente');
    $this->redirect("@orders_show?slug=".$this->consumer_order->Orders->slug."&detail=1");
  }


  public function executeDeleteorder(sfWebRequest $request)
  {
    $this->order=Doctrine::getTable("Orders")->findOneById($request->getParameter("order_id"));
    /*
     * retorna el pedido al proveedor. Pasa a estado 4, aceptado, para comenzar de nuevo el ciclo.
    */
    $this->order->setOrderStateId(12);
    $this->order->save();
    $this->getUser()->setFlash('notice', 'El pedido se ha eliminado correctamente');

    $this->redirect("consumer_group/orderlist");
  }


  public function executeGobackorder(sfWebRequest $request)
  {
    $this->order=Doctrine::getTable("Orders")->findOneById($request->getParameter("order_id"));
    /*
     * retorna el pedido al proveedor. Pasa a estado 4, aceptado, para comenzar de nuevo el ciclo.
    */
    $this->order->setOrderStateId(4);
    $this->order->save();
    $this->getUser()->setFlash('notice', 'El pedido se ha retornado al proveedor correctamente');
    $this->sendMail($this->order->Provider->email,$this->order->Consumer->email,"El pedido ".$this->order->name." ha sido modificado por el grupo","Este pedido ya fue aceptado y modificiado. Ahora el grupo lo ha revisado. Debes revisarlo tú.");
    $this->redirect("consumer_group/orderlist");
  }

  public function executeAddProduct(sfWebRequest $request)
  {
    /*
     * le paso al formulario el objeto de la tabla ProviderProduct que viene del request         *
    */
    $this->order=Doctrine::getTable("Orders")->findOneById($request->getParameter("order_id"));
    $this->form=new ConsumerOrderIncreaseForm(array(), array('order' => $this->order));


  }
  public function executeAddedProduct(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->order=Doctrine::getTable("Orders")->findOneById($request->getParameter("order_id"));
    $this->form=new ConsumerOrderIncreaseForm(array(), array('order' => $this->order));
    $this->processFormProduct($request, $this->form);
    $this->setTemplate("addProduct");
  }

  protected function processFormProduct(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()){
      $record = $form->save();
      if ($form->isNew())
      {
        if ($record->Orders->order_state_id==6)
        {
          $record->Orders->order_state_id=7;
          $record->Orders->save();
        }
        $this->getUser()->setFlash('notice', "El pedido se ha realizado correctamente");
      }
      $this->redirect("consumer_group/orderlist");
    }
  }

  public function executeAdmin()
  {

  }

  public function executeProfile(sfWebRequest $request)
  {
    $this->consumer_group=Doctrine::getTable("ConsumerGroup")->findOneById($request->getParameter("id"));
  }

  /*
   * compra a través del catálogo
  * se hace a través de ajax
  */
  public function executeConsumer_order_purchase(sfWebRequest $request)
  {
    $this->amount=$request->getParameter("amount");

    $this->order=Doctrine::getTable("Orders")->findOneById($request->getParameter("order_id"));
    $this->consumer=Doctrine::getTable("Consumer")->findOneById($request->getParameter("consumer_id"));
    $this->provider_product=Doctrine::getTable("ProviderProduct")->findOneById($request->getParameter("provider_product_id"));
    if ($this->amount>0)
    {
      if ($this->consumer->hasBuyProduct($this->provider_product->id,$this->order->id))
      {
        $this->consumer_order=$this->consumer->getBuyProduct($this->provider_product->id,$this->order->id);
        $this->consumer_order->setAmount($this->amount);
        $this->consumer_order->save();
      }
      else  {
        $this->consumer_order=new ConsumerOrder();
        $this->consumer_order->provider_product_id=$this->provider_product->id;
        $this->consumer_order->order_id=$this->order->id;
        $this->consumer_order->consumer_id=$this->consumer->id;
        $this->consumer_order->product_id=$this->provider_product->product_id;
        $this->consumer_order->provider_id=$this->provider_product->provider_id;
        $this->consumer_order->amount=$this->amount;
        $this->consumer_order->consumer_order_state_id=1;
        $this->consumer_order->save();
      }
    }
    if ($request->getParameter("redirect"))
    {
      $this->redirect("@provider_catalogue?slug=".$this->provider_product->Provider->slug."&buy_consumer_id=".$this->consumer->id);
    }
  }

  public function executeConsumer_order_detail(sfWebRequest $request)
  {
    $this->order=Doctrine::getTable("Orders")->findOneById($request->getParameter("order_id"));
    $this->consumer=Doctrine::getTable("Consumer")->findOneById($request->getParameter("consumer_id"));
  }

  public function executeProviderlist(sfWebRequest $request)
  {
    $query=Doctrine::getTable("Provider")->createQuery("l")
    ->leftJoin("l.AceptedProviderConsumerGroup s")
    ->andWhere("acepted_provider_state_id=?",1)
    ->andWhere("provider_state_id=?",1)
    ->andWhere("consumer_group_id=?",$this->getUser()->getInternalUser()->consumer_group_id);

    if ($request->getParameter("type")=="trust")
    {
      $this->type=$request->getParameter("type");
      $query->andWhere("provider_consumer_trust_id=?",$this->getUser()->getInternalUser()->getId());
    }

    $this->acepted_providers=$query->execute();
  }



  public function executeInvite(sfWebRequest $request)
  {
    $this->form=new InviteForm();
  }



  public function executeInvited(sfWebRequest $request)
  {
    $this->params=$request->getParameter("invite");
    /*sfApplicationConfiguration::getActive()->loadHelpers(array('TextPurifier'));
     $this->body=cleanPurifier($request->getParameter("body"));*/

    $this->emails_textarea=$this->params["emails"];
    $this->emails=str_replace(" ","",$this->emails_textarea);
    $this->emails=str_replace("\r",",",$this->emails);
    $this->emails=str_replace(";",",",$this->emails);
    //echo $this->emails;
    $this->emails=explode(",",$this->emails);
    //echo count($this->emails);
    $this->corrected_emails=array();
    //print_r($this->emails);

    $v = new sfValidatorEmail();
    foreach ($this->emails as $i=>$email)
    {
      try {
        $this->corrected_emails[]=$v->clean(trim($email));
      }catch (sfValidatorError $e) {
        // email invalid
      }
    }
     

    if (count($this->corrected_emails))
    {
      /*
       * compruebo los emails que ya están en la base de datos.
      */
      $repeated_email=array();
      $existing_individuals_users=0;
      foreach ($this->corrected_emails as $email)
      {
        $query=Doctrine::getTable("sfGuardUserProfile")->createQuery()->where("email=?",$email);
        if ($query->count())
        {
          $repeated_email[]=$email;
          $user_profile=$query->fetchOne();
          if ($user_profile->getUser()->hasPermission("consumer")&&in_array($user_profile->getUser()->getConsumer()->getConsumerStateId(),array(1,3,4)))
          {
            $invitation=new ConsumerGroupInvitation();
            $invitation->email=$email;
            $invitation->consumer_group_id=$this->internal_user->consumer_group_id;
            $invitation->consumer_host_id=$this->internal_user->id;
            $invitation->invitation_code=0;
            $invitation->invitation_status_id=1;
            $invitation->save();
            $existing_individuals_users+=1;
            $this->sendMail($email, sfConfig::get("app_default_mailfrom"), "Has recibido una invitación en http://grupoagrupo.net", "sendMail_existing_user_invite",array($invitation,$this->internal_user->ConsumerGroup));
          }
        }
      }

      //emails aceptados, los que no están repetidos
      $this->acepted_emails=array_diff($this->corrected_emails, $repeated_email);

      foreach ($this->acepted_emails as $email)
      {

        $invitation=new ConsumerGroupInvitation();
        $invitation->email=$email;
        $invitation->consumer_group_id=$this->internal_user->consumer_group_id;
        $invitation->consumer_host_id=$this->internal_user->id;
        $invitation->invitation_code=$this->createGuid();
        $invitation->invitation_status_id=1;
        $invitation->save();
        $this->sendMail($email, sfConfig::get("app_default_mailfrom"), "Has recibido una invitación en http://grupoagrupo.net", "sendMail_invite",array($invitation,$this->internal_user->ConsumerGroup));
      }
      if (count($this->acepted_emails)!=count($this->emails))
      {
        if ($existing_individuals_users)
        {
          if (count($this->emails)==$existing_individuals_users)
          {
            $this->getUser()->setFlash('notice', "Se ha invitado a ".$existing_individuals_users." consumidoras/es individuales que ya estaban de alta en GAG");
          }
          else if (count($this->emails)==($existing_individuals_users+count($this->acepted_emails)))
          {
            $this->getUser()->setFlash('notice', "Se han envíado ".(count($this->acepted_emails)+$existing_individuals_users)." invitaciones,
                ".$existing_individuals_users." de las cuales a consumidoras/es individuales que ya estaban de alta en GAG.
                Revisa en el menú administración el estado de las invitaciones.");
          }

          else
          {
            $this->getUser()->setFlash('notice', "Alguno de los correos introducidos no era válido o ya estaba en nuestra base de datos.
                Se han envíado ".(count($this->acepted_emails)+$existing_individuals_users)." invitaciones,
                ".$existing_individuals_users." de las cuales a consumidoras/es individuales que ya estaban de alta en GAG.
                Revisa en el menú administración el estado de las invitaciones.");
          }


        }
        else {
          $this->getUser()->setFlash('notice', "Alguno de los correos introducidos no era válido o ya estaba en nuestra base de datos.
              Se han envíado ".(count($this->acepted_emails)+$existing_individuals_users)." invitaciones. Revisa en el menú administración el estado de las invitaciones. ");
        }


      }
      else {
        $this->getUser()->setFlash("notice","Se han envíado ".count($this->acepted_emails)." invitaciones. Revisa en el menú administración el estado de las invitaciones");
      }

      $this->redirect("consumer_group/admin");
    }
    else {
      $this->getUser()->setFlash('error', "No has introducido ningún correo electrónico válido");
      $this->redirect("consumer_group/invite");
    }
  }

  /*
   * esto lo saco del apply plugin
  */
  private function createGuid()
  {
    $guid = "";
    for ($i = 0; ($i < 8); $i++) {
      $guid .= sprintf("%02x", mt_rand(0, 255));
    }
    return $guid;
  }

  public function executeCheck_invitation(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->getUser()->setFlash('error', "No se puede activar una invitación por una/un usuaria/o registrada/o");
    }
    else {
      $this->invitation=Doctrine::getTable("ConsumerGroupInvitation")->createQuery()->where("invitation_code=?",$request->getParameter("code"))->fetchOne();
      if ($this->invitation)
      {
        if ($this->invitation->invitation_status_id==1)
        {
          $this->form=new inviteUserForm(array(),array("invitation"=>$this->invitation));
        }
        else  if ($this->invitation->invitation_status_id==3)
        {
          $this->getUser()->setFlash('error', "El código de invitación  ha caducado ya");
        }
         
        else  if ($this->invitation->invitation_status_id==2)
        {
          $this->getUser()->setFlash('error', "El código de invitación ya ha sido activado");
        }
      }
      else
      {
        $this->getUser()->setFlash('error', "El código de invitación no es válido");
      }
    }
  }
  public function executeChecked_invitation(sfWebRequest $request)
  {
    $this->invitation=Doctrine::getTable("ConsumerGroupInvitation")->createQuery()->where("invitation_code=?",$request->getParameter("code"))->fetchOne();
    $this->forward404Unless($request->isMethod('post'));
    $this->form = new inviteUserForm(array(),array("invitation"=>$this->invitation));
    $this->processCheckInvitationForm($request, $this->form);
    $this->setTemplate("check_invitation");
  }


  protected function processCheckInvitationForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName()));
    if ($form->isValid()){
      $record = $form->save();
      $invitation=$form->getOption("invitation");
      //logueo al usuario que se acaba de registrar
      $this->getUser()->signin($record->getUser());
      $invitation->setInvitationStatusId(2);
      $invitation->save();

      $this->getUser()->setFlash('notice', "La/el usuaria/o se ha creado correctamente");

      $this->redirect("register/complete?invited_for_consumer_group_id=".$invitation->consumer_group_id);
    }
  }

  public function executeReview_invitations(sfWebRequest $request)
  {
    $this->invitations=Doctrine::getTable("ConsumerGroupInvitation")->createQuery()->where("consumer_group_id=?",$this->internal_user->ConsumerGroup->id)->execute();
  }

  public function executeResend_invitation(sfWebRequest $request)
  {
    $this->invitation=Doctrine::getTable("ConsumerGroupInvitation")->createQuery()->where("id=?",$request->getParameter("consumer_group_invitation_id"))->fetchOne();
    $this->invitation->invitation_status_id=1;
    $this->invitation->created_at=date("Y-m-d h:m:s");
    $this->invitation->save();
    $this->sendMail($this->invitation->email, sfConfig::get("app_default_mailfrom"), "Has recibido una invitación en http://grupoagrupo.net", "sendMail_invite",array($this->invitation,$this->internal_user->ConsumerGroup));

    $this->getUser()->setFlash('notice', "La invitación se ha reenviado correctamente");

    $this->redirect("consumer_group/review_invitations");
  }

  public function executeOrderShow(sfWebRequest $request)
  {
    $this->order=Doctrine::getTable('Orders')
    ->createQuery("t")
    ->where("t.slug=?",$request->getParameter("slug"))
    ->fetchOne();

  }

  public function executeInvited_user(sfWebRequest $request)
  {
    if (in_array($this->getUser()->getInternalUser()->consumer_state_id,array(2,5))||!$this->getUser()->hasCredential("consumer"))
    {
      $this->getUser()->setFlash('error', "No tienes los suficientes permisos para acceder a esa página");
      $this->redirect("@homepage");
    }
    $this->invitations=$this->getUser()->getInternalUser()->getInvitationToConsumerGroup();

  }

  public function executeProcess_invitation(sfWebRequest $request)
  {
    $invitation=Doctrine::getTable("ConsumerGroupInvitation")->findOneById($request->getParameter("invitation_id"));
    $type=$request->getParameter("type","reject");
    if ($type=='reject')
    {
      $invitation->delete();
      $this->getUser()->setFlash('notice', "La invitación se ha eliminado correctamente");

    }
    else if ($type=="accept")
    {
      
      foreach ($this->getUser()->getInternalUser()->getInvitationToConsumerGroup() as $invitation)
      {
        $invitation->invitation_status_id=2;
        $invitation->save();
      }
      $this->getUser()->getInternalUser()->consumer_state_id=2;
      $this->getUser()->getInternalUser()->consumer_group_id=$invitation->ConsumerGroup->id;
      $this->getUser()->getInternalUser()->consumer_group_join_date=date("Y-m-d");
      $this->getUser()->getInternalUser()->save();

      $this->sendMail($this->getUser()->getInternalUser()->email,sfConfig::get("app_default_mailfrom") , "[Grupo a Grupo] Has sido aceptada/o en el grupo de consumo ".$invitation->ConsumerGroup->name,
          "A partir de ahora formas parte del grupo de consumo ".$invitation->ConsumerGroup->name.". Gracias por participar en Grupo a Grupo. http://grupoagrupo.net");
      $this->sendMail($invitation->ConsumerGroup->getEmailAddress(),sfConfig::get("app_default_mailfrom"),"[Grupo a Grupo] Invitación aceptada",
          "La/el consumidora/or ".$this->getUser()->getInternalUser()->getFullName()." ha aceptado la invitación para unirse a vuestro grupo de consumo. Gracias por participar en Grupo a Grupo. http://grupoagrupo.net");
      $this->getUser()->setFlash('notice', "Ahora formas parte del grupo de consumo ".$invitation->ConsumerGroup->name);

    }

    $this->redirect("consumer_group/admin");
  }

}

