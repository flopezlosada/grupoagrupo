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

/*lo dejo de usar*/

class sfApplyConsumerGroupForm extends sfApplyApplyForm
{
    public function configure()
    {
        $this->widgetSchema['internal_class_id']= new sfWidgetFormInputHidden();
        /*$this->widgetSchema['email']= new sfWidgetFormInputHidden();
        $this->widgetSchema['email2']= new sfWidgetFormInputHidden();
        $this->setDefault("email",sfContext::getInstance()->getUser()->getGuardUser()->getEmailAddress());
        $this->setDefault("email2",sfContext::getInstance()->getUser()->getGuardUser()->getEmailAddress());*/
        $this->setDefault("internal_class_id",3);
        parent::configure();

    }
}