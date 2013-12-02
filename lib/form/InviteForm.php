<?php
/*
 © Copyright 2012 diphda.net && Sodepaz
info@diphda.net


Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia
Pública General de GNU según es publicada por la Free Software Foundation, bien de la versión 3 de dicha
Licencia o bien (según su elección) de cualquier versión posterior.

Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin l
garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la
Licencia Pública General de GNU para más detalles.

Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así,
escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, MA 02139, EEUU.

La licencia se encuentra en el archivo licencia.txt*/


class InviteForm extends sfForm
{
    public function setup()
    {
        $this->setWidgets(array(
                'emails'                 => new sfWidgetFormTextarea(array(),array("wrap"=>"hard")),
                //'body'                    => new sfWidgetFormTextarea()
        ));

        $this->setValidators(array(
                'emails'                 => new sfValidatorString(array('required' => true)),
                //'body'                    => new sfValidatorPass()                
        ));

        $this->widgetSchema->setFormFormatterName('list');
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
        $this->widgetSchema->setNameFormat('invite[%s]');
    }
}

class inviteUserForm extends sfApplyApplyForm
{
    public function configure()
    {
        parent::configure();
        $this->widgetSchema["email"]=new sfWidgetFormInputHidden();
        $this->widgetSchema["email2"]=new sfWidgetFormInputHidden();
        $this->widgetSchema["internal_class_id"]=new sfWidgetFormInputHidden();
        $invitation=$this->getOption("invitation");
        $this->setDefault("email2",$invitation->email);
        $this->setDefault("email",$invitation->email);
        $this->setDefault("internal_class_id",3);

    }

    public function doSave($con = null)
    {
        $user = new sfGuardUser();
        $user->setUsername($this->getValue('username'));
        $user->setPassword($this->getValue('password'));
        $user->setEmailAddress($this->getValue('email'));
        // They must confirm their account first
        $user->setIsActive(true);
        $user->save();        
       

        $user->addPermissionByName("consumer");
        $user->addGroupByName("Consumers");//en plural y la primera en mayúscula
        $this->userId = $user->getId();

        return parent::parentDoSave($con);
    }

}