<?php

/**
 * LandingTranslation form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LandingTranslationForm extends BaseLandingTranslationForm
{
    public function configure()
    {
        $this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCE(
        array(
		'config' => sfConfig::get('app_tiny_mce_simple')
        ));
        $this->widgetSchema->setLabels(array("name"=>"Título","menu_link"=>"Enlace del menú","content"=>"Contenido"));
    }
}
