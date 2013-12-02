<?php
/*
 © Copyright 2011 Francisco López Losada && Sodepaz
 flopezlosada@yahoo.es


 Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia
 Pública General de GNU según es publicada por la Free Software Foundation, bien de la versión 3 de dicha
 Licencia o bien (según su elección) de cualquier versión posterior.

 Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin l
 garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la
 Licencia Pública General de GNU para más detalles.

 Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así,
 escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, MA 02139, EEUU.

 La licencia se encuentra en el archivo licencia.txt*/

class ContactSimpleForm extends sfFormSymfony
{
    public function setup()
    {
        $this->widgetSchema['subject']=new sfWidgetFormInput();
        $this->widgetSchema['body']=new sfWidgetFormTextarea();
        $this->widgetSchema->setFormFormatterName('list');
        $this->widgetSchema->setNameFormat('contact[%s]');
        $this->widgetSchema['id']=new sfWidgetFormInputHidden();
        $this->setDefault("id",sfContext::getInstance()->getRequest()->getParameter("id"));

        $this->validatorSchema["subject"]=new sfValidatorString(array("required"=>"true"));
        $this->validatorSchema["id"]=new sfValidatorString(array("required"=>"true"));
        $this->validatorSchema["body"]=new sfValidatorString(array("required"=>"true"));
        $this->widgetSchema->setLabels(array("subject"=>"Asunto","body"=>"Contenido del mensaje"));
        parent::setup();

    }
}

class ContactMapObjectForm extends sfFormSymfony
{
    public function setup()
    {
        $this->widgetSchema['subject']=new sfWidgetFormInput();
        $this->widgetSchema['body']=new sfWidgetFormTextarea();
        $this->widgetSchema->setFormFormatterName('list');
        $this->widgetSchema->setNameFormat('contact[%s]');
        $this->widgetSchema['id']=new sfWidgetFormInputHidden();
        $this->setDefault("id",sfContext::getInstance()->getRequest()->getParameter("id"));

        $this->validatorSchema["subject"]=new sfValidatorString(array("required"=>"true"));
        $this->validatorSchema["id"]=new sfValidatorString(array("required"=>"true"));
        $this->validatorSchema["body"]=new sfValidatorString(array("required"=>"true"));
        parent::setup();

    }
}

class ContactGuestForm extends sfFormSymfony
{
    public function setup()
    {
        $this->widgetSchema['subject']=new sfWidgetFormInput();
        $this->widgetSchema['body']=new sfWidgetFormTextarea();
        $this->widgetSchema->setFormFormatterName('list');
        $this->widgetSchema->setNameFormat('contact[%s]');
        $this->widgetSchema['email']=new sfWidgetFormInput();
        

        $this->validatorSchema["subject"]=new sfValidatorString(array("required"=>"true"));
        $this->validatorSchema["email"]=new sfValidatorString(array("required"=>"true"));
        $this->validatorSchema["body"]=new sfValidatorString(array("required"=>"true"));
        $this->widgetSchema->setLabels(array("subject"=>"Asunto","body"=>"Contenido del mensaje","email"=>"Correo electrónico"));
        parent::setup();

    }
}