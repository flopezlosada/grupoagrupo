<?php

/**
 * register actions.
 *
 * @package    grupos_consumo
 * @subpackage register
 * @author     info@diphda.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class registerActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */

    public function preExecute()
    {
        /*
         * Obtengo el tipo de usuario que es, si provider o consumer
        */
        if ($this->getUser()->isAuthenticated())
        {
            $this->class=$this->getUser()->getProfile()->InternalClass->class;
            $this->form_name=$this->class."RegisterForm";
        }
    }

    public function executeIndex(sfWebRequest $request)
    {
        /*
         * compruebo primero que el usuario tenga internal_class_id=6, es decir
        * que haya iniciado el registro como grupo de consumo
        */
        if ($this->getUser()->getGuardUser()->getProfile()->profile_group==2)
        {
            $this->redirect("consumer_group/add");
        }

        /*
         * busco si ha rellenado ya sus datos personales. Para ello saco su clase Provider o Consumer y
        * si existe el id es que ya lo ha rellenado
        */

        $complete_profile=$this->getUser()->getGuardUser()->{$this->class};
        if ($complete_profile->id)
        {
            if ($this->getUser()->hasCredential("consumer")&&!$this->getUser()->getInternalUser()->belongConsumerGroup())
            {
                $this->redirect('@homepage');
            } else {
                $this->redirect('profile/data');
            }
        } else            
        {
            $query=Doctrine::getTable("ConsumerGroupInvitation")->createQuery()->where("email=?",$this->getUser()->getGuardUser()->email_address);
            if ($query->count())
            {
                $check_invitation=$query->fetchOne();
                $this->redirect("register/complete?invited_for_consumer_group_id=".$check_invitation->consumer_group_id);
            }
            else {
                $this->redirect("register/complete");
            }
        }
    }

    public function executeComplete(sfWebRequest $request)
    {
        if ($request->hasParameter("invited_for_consumer_group_id"))
        {
            $this->invited_for_consumer_group_id=$request->getParameter("invited_for_consumer_group_id");
            $this->consumer_group=Doctrine::getTable("ConsumerGroup")->findOneById($request->getParameter("invited_for_consumer_group_id"));
        }
        $this->form=new $this->form_name;
        $this->setTemplate(strtolower($this->class));
    }

    public function executeCreate(sfWebRequest $request)
    {
        //$this->tipo=$request->getParameter("tipo");

        $this->forward404Unless($request->isMethod('post'));

        $this->form = new $this->form_name;

        $this->processForm($request, $this->form);

        $this->setTemplate(strtolower($this->class));
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName()));
        if ($form->isValid()){
            $registro = $form->save();
            if ($this->getUser()->getGuardUser()->getProfile()->profile_group==1)
            {
                $this->getUser()->getGuardUser()->getProfile()->profile_group=2;
                $this->getUser()->getGuardUser()->getProfile()->save();
                $this->getUser()->setFlash('notice', 'Su perfil se ha creado correctamente');

                $this->redirect("consumer_group/add");
            }

            if($form->isNew())
            {
                if ($request->hasParameter("invited_for_consumer_group_id"))
                {
                    $consumer_group=Doctrine::getTable("ConsumerGroup")->findOneById($request->getParameter("invited_for_consumer_group_id"));
                    $this->getUser()->setFlash('notice', 'Su perfil se ha creado correctamente. A partir de ahora estás inscrita/o en el grupo de consumo '.$consumer_group->name);
                }
                else {
                    $this->getUser()->setFlash('notice', 'Su perfil se ha creado correctamente');
                }
            } else
            {
                $this->getUser()->setFlash('notice', 'Su perfil se ha modificado correctamente');

            }
            $this->redirect('profile/data');
        }
        else
        {
            $this->getUser()->setFlash('error', 'No se ha podido completar la acción porque hay errores. Revisa los datos.', false);
        }
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->register = Doctrine::getTable($this->class)->findOneById($this->getUser()->getInternalUser()->id);
        $this->form = new $this->form_name($this->register);
        $this->setTemplate(strtolower($this->class));
    }

    public function executeUpdate(sfWebRequest $request)
    {
        $this->register = Doctrine::getTable($this->class)->findOneById($this->getUser()->getInternalUser()->id);
        $this->form = new $this->form_name($this->register);
        $this->processForm($request, $this->form);
        $this->setTemplate(strtolower($this->class));
    }


    public function executeLogin()
    {

    }

    public function executeDelete()
    {
        /*
         * cuando se elimina un productor, se borran sus pedidos de estado menor que 9 (finalizado)
        * las cuentas no se borran sino que se pasan a inactivo, ya veremos cómo se recuperan.
        * Con el consumidor, se borran sus consumer_order de los pedidos que no han finalizado(9)
        */

        if ($this->getUser()->getInternalClassName()=="Consumer")
        {
            $this->getUser()->getInternalUser()->consumer_state_id=5;
            foreach ($this->getUser()->getInternalUser()->getProvidersInPendingOrders() as $provider)
            {
                $this->sendMail($provider->email,sfConfig::get("app_default_mailfrom"),"La/el consumidora/or ".$this->getUser()->getInternalUser()->name." se ha dado de baja de grupoagrupo.net",
                        "Todos los pedidos que había realizado esta/e consumidora/or han sido eliminados.");
            }
            $this->getUser()->getInternalUser()->deletePendingOrders();

        }
        else if ($this->getUser()->getInternalClassName()=="Provider")
        {
            $this->getUser()->getInternalUser()->provider_state_id=2;
            foreach ($this->getUser()->getInternalUser()->getConsumerInPendingOrders() as $consumer)
            {
                $this->sendMail($consumer->email,sfConfig::get("app_default_mailfrom"),"La/el proveedora/or ".$this->getUser()->getInternalUser()->name." se ha dado de baja de grupoagrupo.net",
                        "Todos los pedidos que tenías con esta/e proveedora/or han sido eliminados.");
            }
            $this->getUser()->getInternalUser()->deletePendingOrders();
        }

        $this->getUser()->getInternalUser()->save();
        $this->getUser()->getGuardUser()->is_active=0;
        $this->getUser()->getGuardUser()->save();
        $this->getUser()->setFlash('notice', 'La/el usuaria/o se ha eliminado correctamente.');
        $this->redirect("@sf_guard_signout");
    }


    public function sendMail($to,$from,$subject,$body){
        $mensaje = Swift_Message::newInstance();
        $mensaje->setFrom($from);
        $mensaje->setTo($to);
        $mensaje->setSubject($subject);
        $mensaje->setBody($body);
        $this->getMailer()->send($mensaje);
    }
}
