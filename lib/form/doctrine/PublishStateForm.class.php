<?php

/**
 * PublishState form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PublishStateForm extends BasePublishStateForm
{
    public function configure()
    {
        unset($this['position']);

        unset($this["created_at"], $this["updated_at"]);

        $cultureEmbed=array(sfContext::getInstance()->getUser()->getCulture());
        if($this->getObject()->getCultureTranslation())
        {
            $cultureEmbed[]=$this->getObject()->getCultureTranslation();
        }



        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('sf_admin');

        $this->embedI18n($cultureEmbed);

    }
}
