<?php

/**
 * event actions.
 *
 * @package    grupos_consumo
 * @subpackage event
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eventActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {

  }

  public function executeShow(sfWebRequest $request)
  {
    $this->event=Doctrine::getTable("Event")
    ->createQuery("a")
    ->leftJoin("a.Translation t")
    ->where("t.slug=?",$request->getParameter("slug"))
    ->fetchOne();
    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N'));    
    $this->getResponse()->setTitle(__("Grupos de consumo. ").$this->event->name);
  }

  public function executeAdd(sfWebRequest $request)
  {
    $this->form=new EventForm();
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->form=new EventForm();
    $this->event=Doctrine::getTable("Event")
    ->createQuery("a")
    ->leftJoin("a.Translation t")
    ->where("t.slug=?",$request->getParameter("slug"))
    ->fetchOne();
    $this->form=new EventForm($this->event);
    $this->setTemplate("add");
  }

  public function executeUpdate(sfWebRequest $request)
  {

    $this->form=new EventForm();
    $this->event=Doctrine::getTable("Event")
    ->createQuery("a")
    ->leftJoin("a.Translation t")
    ->where("t.slug=?",$request->getParameter("slug"))
    ->fetchOne();
    $this->form=new EventForm($this->event);
    $this->processForm($request, $this->form);
    $this->setTemplate("add");

  }

  public function executeAdded(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));
    $this->form=new EventForm();
    $this->processForm($request, $this->form);
    $this->setTemplate("add");
  }


   
  public function executeDelete(sfWebRequest $request)
  {

    $this->event=Doctrine::getTable("Event")
    ->createQuery("a")
    ->leftJoin("a.Translation t")
    ->where("t.slug=?",$request->getParameter("slug"))
    ->fetchOne();
    if ($this->event->delete())
    {
      $this->getUser()->setFlash('notice', 'The event have been succesfully deleted');
    }
    else {
      $this->getUser()->setFlash('error', 'There has been an error. Try again later');
    }
    $this->redirect('event/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()){

      $record = $form->save();

      if ($record->end_date=='')
      {
        $record->setEndDate(null);
        $record->save();
      }

      if ($record->getPublishStateId()==7)
      {
        $record->setConsumerGroupId($this->getUser()->getInternalUser()->ConsumerGroup->id);
        $record->save();
      }

      if ($form->isNew())
      {
        $this->getUser()->setFlash('notice', 'The event has been created succesfully.');

      } else
      {
        $this->getUser()->setFlash('notice', 'The event has been modified succesfully.');
      }

      $this->redirect('event/show?slug='.$record->slug);
    }
    /*
     * Esto es para evitar un error que no entiendo, cuando se produce que el archivo es demasiado grande,
    * el formulario no carga los valores por defecto y no funciona. Así redirijo a la página inicial d
    * utilidades y listo.
    */
    else if (in_array("The form submission cannot be processed. It probably means that you have uploaded a file that is too big.",$form->getGlobalErrors()))
    {
      $this->getUser()->setFlash('error', 'The form submission cannot be processed. It probably means that you have uploaded a file that is too big. Try again');
      $this->redirect('event/index');
    }
  }



  public function executeGetJsonUtil(sfWebRequest $request)
  {
    sfApplicationConfiguration::getActive()->loadHelpers(array('Url', 'Tag'));
    $this->getResponse()->setHttpHeader('Content-Type', 'application/json; charset=utf-8');
    $events=Doctrine::getTable("Event")->createQuery()->whereIn("publish_state_id",$this->getUser()->getAllowPublishStates())->andWhere('published=?',1)->execute();

    $result=array();
    $object_json=array();
    foreach($events as $event)
    {

      $object_json["id"]=$event->getId();
      $object_json["title"]=$event->getName();
      $object_json["start"]=$event->getStartDate();
      $object_json["url"]=url_for("@event?slug=".$event->getSlug());
      $object_json["place"]=$event->Venue->getName();
      $object_json["end"]=$event->getEndDate();
      $object_json["allDay"]=false;
      if ($event->publish_state_id==1)
      {
        $object_json['backgroundColor']='#82D582';
        $object_json['borderColor']='#217721';
      }

      if ($event->publish_state_id==2)
      {
        $object_json['backgroundColor']='#438DEF';
        $object_json['borderColor']='#143C71';
      }
      if ($event->publish_state_id==7)
      {
        $object_json['backgroundColor']='#D14B16';
        $object_json['borderColor']='#942F08';

        if ($this->getUser()->hasCredential("consumer"))
        {
          if ($event->consumer_group_id==$this->getUser()->getInternalUser()->getConsumerGroupId())
          {
            $result[]=$object_json;
          }
        }
      }
      else
      {
        $result[]=$object_json;
      }
    }

    return $this->renderText(json_encode($result));
  }

  public function executeShow_group(sfWebRequest $request)
  {
    if ($this->getUser()->hasCredential("consumer"))
    {
      $query=Doctrine::getTable("Event")
      ->createQuery()
      ->where("publish_state_id=?",7)
      ->andWhere("consumer_group_id=?",$this->getUser()->getInternalUser()->consumer_group_id)
      ->andWhere('published=?',1)
      ->orderBy("start_date desc");

      $this->pager = new sfDoctrinePager("Event",
          sfConfig::get('app_utils_list')
      );
      $this->pager->setQuery($query);
      $this->pager->setPage($request->getParameter('page', 1));
      $this->pager->init();
    }
    else
    {
      $this->redirect("@homepage");
    }

  }

  /*
   * muestra los eventos del proveedor
  */
  public function executeProvider(sfWebRequest $request)
  {
    $this->provider=Doctrine::getTable("Provider")->findOneBySlug($request->getParameter("slug"));
    $query=Doctrine::getTable("Event")
    ->createQuery()
    ->whereIn("publish_state_id",$this->getUser()->getAllowPublishStates())
    ->andWhere("user_id=?",$this->provider->user_id)
    ->andWhere('published=?',1)
    ->orderBy("start_date desc");

    $this->pager = new sfDoctrinePager("Event",
        sfConfig::get('app_utils_list')
    );
    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }
}


