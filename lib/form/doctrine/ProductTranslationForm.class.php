<?php

/**
 * ProductTranslation form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     info@diphda.net
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductTranslationForm extends BaseProductTranslationForm
{
    public function configure()
    {
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('sf_admin');
        $this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCE(
        array(
		'config' => sfConfig::get('app_tiny_mce_simple')
        ));
    }
}
